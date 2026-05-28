<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Réservation - 9ahwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-amber-800 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Détail de la réservation #{{ $reservation->id }}</h1>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="font-bold text-gray-700 mb-2">Informations client</h2>
                        <p><strong>Nom:</strong> {{ $reservation->user->name }}</p>
                        <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                        <p><strong>Téléphone:</strong> {{ $reservation->user->phone ?? 'Non renseigné' }}</p>
                    </div>
                    
                    <div>
                        <h2 class="font-bold text-gray-700 mb-2">Détails réservation</h2>
                        <p><strong>Table:</strong> {{ $reservation->tableData->table_number ?? 'N/A' }}</p>
                        <p><strong>Date/Heure:</strong> {{ date('d/m/Y H:i', strtotime($reservation->reservation_time)) }}</p>
                        <p><strong>Statut:</strong> 
                            <span class="px-2 py-1 rounded text-xs font-bold
                                @if($reservation->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($reservation->status == 'confirmed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $reservation->status }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h2 class="font-bold text-gray-700 mb-2">Produits commandés</h2>
                    @if($reservation->products->count() > 0)
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 text-left">Produit</th>
                                    <th class="py-2 px-4 text-center">Quantité</th>
                                    <th class="py-2 px-4 text-right">Prix unitaire</th>
                                    <th class="py-2 px-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation->products as $item)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $item->product->name }}</td>
                                    <td class="py-2 px-4 text-center">{{ $item->quantity }}</td>
                                    <td class="py-2 px-4 text-right">{{ number_format($item->product->price, 3) }} DT</td>
                                    <td class="py-2 px-4 text-right">{{ number_format($item->quantity * $item->product->price, 3) }} DT</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold">
                                <tr>
                                    <td colspan="3" class="py-2 px-4 text-right">TOTAL :</td>
                                    <td class="py-2 px-4 text-right">{{ number_format($totalAmount, 3) }} DT</td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <p class="text-gray-500 italic">Aucun produit pré-commandé</p>
                    @endif
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('reservations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                        Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>