<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations - 9ahwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-badge {
            transition: all 0.3s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-amber-50/30">

{{-- ==================== NAVBAR ==================== --}}
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="9ahwa Logo" class="h-16 w-16 object-contain rounded-full border border-amber-200">
                <span class="text-xl font-black text-amber-950 tracking-wider font-serif">9AHWA</span>
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}#menu" class="text-gray-700 hover:text-amber-700 font-medium transition">Notre Menu</a>
                <a href="{{ route('home') }}#reservation" class="text-gray-700 hover:text-amber-700 font-medium transition">Réserver</a>
                
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-amber-700 font-medium transition flex items-center gap-1">
                    <i class="fa-solid fa-house"></i> Accueil
                </a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-amber-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-amber-900 transition shadow">
                            Dashboard Admin
                        </a>
                    @else
                        <div class="relative group">
                            <span class="text-amber-900 font-semibold bg-amber-100/60 px-3 py-1.5 rounded-md text-sm cursor-pointer">
                                ☕ {{ Auth::user()->name }}
                            </span>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium transition">
                            Déconnexion
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ==================== MESSAGES FLASH ==================== --}}
<div class="max-w-7xl mx-auto px-4 mt-6">
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-xl shadow-sm mb-4">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check text-green-500 mr-3 text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm mb-4">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-exclamation text-red-500 mr-3 text-lg"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif
</div>

{{-- ==================== MES RÉSERVATIONS ==================== --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-amber-950 font-serif">Mes Réservations</h1>
        <div class="w-24 h-1 bg-amber-600 mx-auto mt-3 rounded-full"></div>
        <p class="mt-4 text-gray-600">Retrouvez ici toutes vos réservations et leur statut.</p>
    </div>

    @if($reservations->count() > 0)
        <div class="space-y-6">
            @foreach($reservations as $reservation)
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex flex-wrap justify-between items-start gap-4">
                            {{-- Info réservation --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                        #{{ $reservation->id }}
                                    </span>
                                    <span class="status-badge px-3 py-1 rounded-full text-xs font-bold
                                        @if($reservation->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($reservation->status == 'confirmed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($reservation->status == 'pending')
                                            <i class="fa-regular fa-clock mr-1"></i> En attente
                                        @elseif($reservation->status == 'confirmed')
                                            <i class="fa-regular fa-circle-check mr-1"></i> Confirmée
                                        @else
                                            <i class="fa-regular fa-circle-xmark mr-1"></i> Annulée
                                        @endif
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">
                                            <i class="fa-regular fa-calendar text-amber-600 mr-1"></i> Date & Heure
                                        </p>
                                        <p class="font-semibold text-gray-800">
                                            {{ date('d/m/Y', strtotime($reservation->reservation_time)) }} à 
                                            {{ date('H:i', strtotime($reservation->reservation_time)) }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">
                                            <i class="fa-solid fa-chair text-amber-600 mr-1"></i> Table
                                        </p>
                                        <p class="font-semibold text-gray-800">
                                            {{ $reservation->tableData->table_number ?? 'Non assignée' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">
                                            <i class="fa-solid fa-users text-amber-600 mr-1"></i> Convives
                                        </p>
                                        <p class="font-semibold text-gray-800">
                                            {{ $reservation->tableData->capacity ?? '?' }} personnes
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">
                                            <i class="fa-regular fa-calendar-plus text-amber-600 mr-1"></i> Réservée le
                                        </p>
                                        <p class="font-semibold text-gray-800">
                                            {{ date('d/m/Y à H:i', strtotime($reservation->created_at)) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Boutons d'action --}}
                            <div class="flex flex-col gap-2">
                                @if($reservation->status == 'pending')
                                    <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-xmark"></i> Annuler
                                        </button>
                                    </form>
                                @endif
                                
                                @if($reservation->status == 'confirmed')
                                    <div class="text-center text-green-600 text-sm font-semibold bg-green-50 px-4 py-2 rounded-lg">
                                        <i class="fa-regular fa-circle-check"></i> Réservation confirmée
                                    </div>
                                @endif
                                
                                @if($reservation->status == 'cancelled')
                                    <div class="text-center text-red-600 text-sm font-semibold bg-red-50 px-4 py-2 rounded-lg">
                                        <i class="fa-regular fa-circle-xmark"></i> Réservation annulée
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Produits pré-commandés --}}
                        @if($reservation->products && $reservation->products->count() > 0)
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <p class="text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fa-solid fa-basket-shopping text-amber-600 mr-2"></i> Pré-commande :
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($reservation->products as $item)
                                        <div class="bg-amber-50 rounded-lg px-3 py-1.5 text-sm">
                                            <span class="font-semibold text-amber-900">{{ $item->product->name }}</span>
                                            <span class="text-amber-600"> x{{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $reservations->links() }}
        </div>
    @else
        {{-- Aucune réservation --}}
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
            <i class="fa-regular fa-calendar-xmark text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune réservation</h3>
            <p class="text-gray-500 mb-6">Vous n'avez pas encore effectué de réservation.</p>
            <a href="{{ route('home') }}#reservation" class="inline-block bg-amber-800 hover:bg-amber-900 text-white font-bold px-6 py-3 rounded-xl transition shadow-lg">
                <i class="fa-solid fa-calendar-plus mr-2"></i> Réserver maintenant
            </a>
        </div>
    @endif
</main>

{{-- ==================== FOOTER ==================== --}}
<footer class="bg-gray-950 text-gray-500 py-8 border-t border-gray-900 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-xs">&copy; {{ date('Y') }} 9ahwa - Caffée Rajel Kbir. Tous droits réservés.</p>
    </div>
</footer>

<style>
    /* Style pour la pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .pagination .page-item .page-link {
        padding: 8px 12px;
        border-radius: 8px;
        background-color: white;
        color: #78350f;
        border: 1px solid #fcd34d;
        transition: all 0.3s;
    }
    .pagination .page-item.active .page-link {
        background-color: #78350f;
        color: white;
        border-color: #78350f;
    }
    .pagination .page-item .page-link:hover {
        background-color: #fef3c7;
        transform: translateY(-2px);
    }
</style>

</body>
</html>