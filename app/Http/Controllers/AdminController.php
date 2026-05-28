<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Table; // Modèle qui gère la table 'tables' de réservation
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * 1. TABLEAU DE BORD (DASHBOARD)
     * Afficher le dashboard admin avec les statistiques.
     */
    public function index()
    {
        $totalUsers = User::where('role', 'client')->count();
        $totalProducts = Product::count();
        $totalReservations = Table::count();

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalReservations'));
    }

    /**
     * 2. LISTE & RECHERCHE (READ)
     * Afficher la liste des utilisateurs avec recherche et filtres.
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Gestion de la barre de recherche
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Gestion du filtrage par rôle (admin ou client)
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Récupération des utilisateurs paginés (10 par page)
        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * 3. FORMULAIRE D'AJOUT (CREATE)
     * Afficher le formulaire de création d'un utilisateur.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * 4. ENREGISTREMENT EN BASE (STORE)
     * Sauvegarder un nouvel utilisateur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,client',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * 5. VUE DETAILS (SHOW)
     * Afficher les informations spécifiques d'un utilisateur.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * 6. FORMULAIRE DE MODIFICATION (EDIT)
     * Afficher le formulaire d'édition d'un utilisateur.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 7. APPLICATION DE LA MODIFICATION (UPDATE)
     * Mettre à jour l'utilisateur dans la base de données.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:admin,client',
            'password' => 'nullable|string|min:6', // Optionnel à l'édition
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        // On ne change le mot de passe que si un nouveau est tapé
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès !');
    }

    /**
     * 8. SUPPRESSION (DESTROY)
     * Supprimer un utilisateur de la base de données.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès !');
    }
}