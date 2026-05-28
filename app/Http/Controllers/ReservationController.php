<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\ReservationData;
use App\Models\ReservationProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Liste toutes les réservations (admin)
     */
    public function index(Request $request)
    {
        $query = Table::with(['user', 'tableData'])->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $reservations = $query->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Détail d'une réservation avec ses produits (admin)
     */
    public function show($id)
    {
        $reservation = Table::with(['user', 'tableData', 'products.product'])
            ->findOrFail($id);

        // Calculer le montant total
        $totalAmount = 0;
        foreach ($reservation->products as $item) {
            $totalAmount += $item->quantity * $item->product->price;
        }

        return view('admin.reservations.show', compact('reservation', 'totalAmount'));
    }

    /**
     * Soumission du formulaire de réservation avec pré-commandes (vitrine publique)
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'reservation_time' => 'required|date|after:now',
            'guests'           => 'required|integer|min:1|max:20',
            'items'            => 'nullable|array',
            'items.*.quantity' => 'nullable|integer|min:0|max:20'
        ]);

        // 2. Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            session()->put('url.intended', url('/') . '#reservation');
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter pour réserver une table.');
        }

        // 3. Début de la transaction
        DB::beginTransaction();

        try {
            // 4. Vérifier s'il y a des tables dans la base de données
            $allTables = ReservationData::all();
            
            if ($allTables->isEmpty()) {
                DB::rollBack();
                Log::error('Tentative de réservation - Aucune table configurée dans la base', [
                    'user_id' => auth()->id(),
                    'guests' => $request->guests
                ]);
                
                return redirect()->route('home')
                    ->with('error', '⚠️ Service temporairement indisponible. Veuillez nous contacter directement au +216 22 123 456 pour réserver.')
                    ->withFragment('reservation');
            }

            // 5. Chercher une table disponible avec capacité suffisante
            $availableTable = ReservationData::where('is_available', true)
                ->where('capacity', '>=', $request->guests)
                ->orderBy('capacity', 'asc')
                ->first();

            if (!$availableTable) {
                DB::rollBack();
                Log::warning('Aucune table disponible pour le nombre de convives', [
                    'guests' => $request->guests,
                    'user_id' => auth()->id()
                ]);
                
                $availableCapacities = $allTables->where('is_available', true)->pluck('capacity')->implode(', ');
                return redirect()->route('home')
                    ->with('error', 'Désolé, aucune table disponible pour ' . $request->guests . ' personne(s). Capacités disponibles : ' . ($availableCapacities ?: 'aucune') . ' places.')
                    ->withFragment('reservation');
            }

            // 6. Vérifier si la table n'est pas déjà réservée à cette heure
            $existingReservation = Table::where('table_id', $availableTable->id)
                ->where('reservation_time', '>=', $request->reservation_time)
                ->where('reservation_time', '<=', date('Y-m-d H:i:s', strtotime($request->reservation_time . ' +2 hours')))
                ->whereIn('status', ['pending', 'confirmed'])
                ->first();

            if ($existingReservation) {
                DB::rollBack();
                return redirect()->route('home')
                    ->with('error', 'La ' . $availableTable->table_number . ' est déjà réservée pour cette tranche horaire. Veuillez choisir un autre horaire.')
                    ->withFragment('reservation');
            }

            // 7. Créer la réservation principale
            $reservation = Table::create([
                'user_id'          => auth()->id(),
                'table_id'         => $availableTable->id,
                'reservation_time' => $request->reservation_time,
                'status'           => 'pending',
            ]);

            // 8. Enregistrer les produits pré-commandés (UNIQUEMENT si des quantités > 0)
            $productsCount = 0;
            $totalProducts = 0;
            
            // Vérifier si items existe et est un tableau
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $productId => $item) {
                    // S'assurer que quantity existe et est un nombre valide
                    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                    
                    // N'enregistrer que si la quantité est supérieure à 0
                    if ($quantity > 0) {
                        // Vérifier que le produit existe dans la base
                        $productExists = Product::where('id', $productId)->exists();
                        
                        if ($productExists) {
                            $productsCount++;
                            $totalProducts += $quantity;
                            
                            ReservationProduct::create([
                                'reservation_id' => $reservation->id,
                                'product_id'     => $productId,
                                'quantity'       => $quantity,
                            ]);
                        } else {
                            Log::warning('Produit non trouvé lors de la réservation', [
                                'product_id' => $productId,
                                'reservation_id' => $reservation->id
                            ]);
                        }
                    }
                }
            }

            // 9. Commit de la transaction
            DB::commit();

            // 10. Message de succès personnalisé
            $successMessage = '✅ Réservation confirmée ! Table: ' . $availableTable->table_number . ' pour ' . $request->guests . ' personne(s) le ' . date('d/m/Y à H:i', strtotime($request->reservation_time));
            
            if ($productsCount > 0) {
                $successMessage .= ' 📋 ' . $totalProducts . ' produit(s) pré-commandé(s) avec succès.';
            } else {
                $successMessage .= ' ☕ Vous pourrez commander sur place.';
            }

            Log::info('Réservation créée avec succès', [
                'reservation_id' => $reservation->id,
                'table' => $availableTable->table_number,
                'user_id' => auth()->id(),
                'guests' => $request->guests,
                'products_count' => $productsCount,
                'total_products' => $totalProducts
            ]);

            return redirect()->route('home')
                ->with('success', $successMessage)
                ->withFragment('reservation');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('ERREUR CRITIQUE - Création de réservation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->route('home')
                ->with('error', '❌ Erreur technique: ' . $e->getMessage() . '. Veuillez contacter l\'administrateur.')
                ->withFragment('reservation');
        }
    }

    /**
     * Changer le statut de la réservation (admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        try {
            $reservation = Table::findOrFail($id);
            $oldStatus = $reservation->status;
            $reservation->update(['status' => $request->status]);

            $statusMessages = [
                'confirmed' => 'confirmée ✅',
                'cancelled' => 'annulée ❌',
                'pending' => 'remise en attente ⏳'
            ];

            Log::info('Statut de réservation modifié', [
                'reservation_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('reservations.index')
                ->with('success', 'Réservation ' . $statusMessages[$request->status] . ' avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de statut', [
                'error' => $e->getMessage(),
                'reservation_id' => $id
            ]);

            return redirect()->route('reservations.index')
                ->with('error', 'Erreur lors de la mise à jour du statut.');
        }
    }

    /**
     * Supprimer une réservation (admin)
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $reservation = Table::findOrFail($id);
            
            // Supprimer d'abord les produits associés
            ReservationProduct::where('reservation_id', $id)->delete();
            
            // Puis supprimer la réservation
            $reservation->delete();
            
            DB::commit();

            Log::warning('Réservation supprimée', [
                'reservation_id' => $id,
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('reservations.index')
                ->with('success', 'Réservation et ses produits associés supprimés avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la suppression', [
                'error' => $e->getMessage(),
                'reservation_id' => $id
            ]);

            return redirect()->route('reservations.index')
                ->with('error', 'Erreur lors de la suppression de la réservation.');
        }
    }

    /**
     * Récupérer les réservations d'un utilisateur connecté
     */
    public function myReservations()
    {
        $reservations = Table::with(['tableData', 'products.product'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.reservations', compact('reservations'));
    }

    /**
     * Annuler une réservation par le client lui-même
     */
    public function cancelByClient($id)
    {
        try {
            $reservation = Table::where('id', $id)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->firstOrFail();

            $reservation->update(['status' => 'cancelled']);

            Log::info('Réservation annulée par le client', [
                'reservation_id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('reservations.my')
                ->with('success', 'Votre réservation a été annulée avec succès.');

        } catch (\Exception $e) {
            return redirect()->route('reservations.my')
                ->with('error', 'Impossible d\'annuler cette réservation.');
        }
    }

    /**
     * Gérer les tables (admin)
     */
    public function manageTables()
    {
        $tables = ReservationData::all();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Ajouter une table (admin)
     */
    public function storeTable(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|unique:reservations_data,table_number',
            'capacity' => 'required|integer|min:1|max:20',
            'is_available' => 'sometimes|boolean'
        ]);

        $data = $request->all();
        $data['is_available'] = $request->has('is_available') ? $request->is_available : true;
        
        ReservationData::create($data);

        return redirect()->route('tables.index')
            ->with('success', 'Table ajoutée avec succès.');
    }

    /**
     * Modifier une table (admin)
     */
    public function updateTable(Request $request, $id)
    {
        $request->validate([
            'table_number' => 'required|string|unique:reservations_data,table_number,' . $id,
            'capacity' => 'required|integer|min:1|max:20',
            'is_available' => 'sometimes|boolean'
        ]);

        $table = ReservationData::findOrFail($id);
        $data = $request->all();
        $data['is_available'] = $request->has('is_available') ? $request->is_available : $table->is_available;
        
        $table->update($data);

        return redirect()->route('tables.index')
            ->with('success', 'Table mise à jour avec succès.');
    }

    /**
     * Supprimer une table (admin)
     */
    public function destroyTable($id)
    {
        try {
            $table = ReservationData::findOrFail($id);
            
            // Vérifier si la table a des réservations
            $hasReservations = Table::where('table_id', $id)->exists();
            
            if ($hasReservations) {
                return redirect()->route('tables.index')
                    ->with('error', 'Impossible de supprimer cette table car elle a des réservations associées.');
            }
            
            $table->delete();

            return redirect()->route('tables.index')
                ->with('success', 'Table supprimée avec succès.');
                
        } catch (\Exception $e) {
            return redirect()->route('tables.index')
                ->with('error', 'Erreur lors de la suppression de la table.');
        }
    }
}