<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>9ahwa - Caffée Rajel Kbir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .modal-overlay { backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); }
        .modal-box { animation: fadeUp 0.25s ease; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        
        /* Toast notification styles */
        .toast-notification {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-left: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .btn-loading .loading-spinner {
            display: inline-block;
        }
        
        .btn-loading .btn-text {
            opacity: 0.7;
        }

        /* Custom scrollbar */
        .products-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .products-scroll::-webkit-scrollbar-track {
            background: #fef3c7;
            border-radius: 10px;
        }
        
        .products-scroll::-webkit-scrollbar-thumb {
            background: #b45309;
            border-radius: 10px;
        }
        
        .products-scroll::-webkit-scrollbar-thumb:hover {
            background: #78350f;
        }
    </style>
</head>
<body class="bg-amber-50/30 text-gray-800 font-sans antialiased">

{{-- ==================== NAVBAR ==================== --}}
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="9ahwa Logo" class="h-16 w-16 object-contain rounded-full border border-amber-200">
                <span class="text-xl font-black text-amber-950 tracking-wider font-serif">9AHWA</span>
            </div>

            <div class="flex items-center space-x-6">
                <a href="#menu" class="text-gray-700 hover:text-amber-700 font-medium transition">Notre Menu</a>
                <a href="#reservation" class="text-gray-700 hover:text-amber-700 font-medium transition">Réserver</a>
                
                <button onclick="openAbout()" class="text-gray-700 hover:text-amber-700 font-medium transition flex items-center gap-1">
                    <i class="fa-solid fa-code text-amber-700 text-sm"></i> À propos
                </button>

                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-amber-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-amber-900 transition shadow">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('reservations.my') }}" class="text-amber-900 font-semibold bg-amber-100/60 px-3 py-1.5 rounded-md text-sm hover:bg-amber-200 transition">
                                ☕ Mes réservations
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-amber-700 text-sm font-medium transition">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-amber-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-amber-900 transition shadow">
                            Inscription
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- ==================== TOAST NOTIFICATIONS ==================== --}}
<div id="toastContainer" class="toast-notification"></div>

{{-- ==================== HERO ==================== --}}
<header class="relative bg-amber-950 text-white py-24 px-4 text-center overflow-hidden">
    <div class="absolute inset-0 opacity-25 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=1600');"></div>
    <div class="relative z-10 max-w-3xl mx-auto flex flex-col items-center">
        <div class="mb-6 p-2 bg-white rounded-full shadow-2xl">
            <img src="{{ asset('images/logo.png') }}" alt="9ahwa Grand Logo" class="h-32 w-32 md:h-40 md:w-40 object-contain rounded-full">
        </div>
        <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight font-serif text-amber-100">
            Caffée Rajel Kbir
        </h1>
        <p class="text-lg md:text-xl text-amber-200/90 max-w-2xl font-light italic mb-8">
            "Yochrb Fi 9ahwa" — Venez savourer l'authenticité et la convivialité au cœur de notre espace.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="#menu" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition duration-200">
                Consulter la Carte
            </a>
            <a href="#reservation" class="bg-white hover:bg-amber-50 text-amber-950 font-bold px-6 py-3 rounded-xl shadow-lg transition duration-200">
                Réserver une Table
            </a>
        </div>
    </div>
</header>

{{-- ==================== MESSAGES FLASH ==================== --}}
@if(session('success'))
    <div class="max-w-4xl mx-auto mt-6 px-4" id="flashMessage">
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check text-green-500 mr-3 text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-4xl mx-auto mt-6 px-4" id="flashMessage">
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-exclamation text-red-500 mr-3 text-lg"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </div>
@endif

{{-- ==================== MENU ==================== --}}
<main id="menu" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-extrabold text-amber-950 font-serif">Notre Carte Exclusive</h2>
        <div class="w-24 h-1 bg-amber-600 mx-auto mt-3 rounded-full"></div>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Des boissons traditionnelles aux gourmandises sucrées et salées.</p>
    </div>

    @forelse($categories as $category)
        @if($category->products->count() > 0)
            <div class="mb-16">
                <h3 class="text-2xl font-bold text-amber-900 border-b border-amber-200 pb-3 mb-8 flex items-center">
                    <span class="bg-amber-800 text-white px-3 py-1 rounded-lg text-sm mr-3 shadow-sm">
                        <i class="fa-solid fa-mug-saucer"></i>
                    </span>
                    {{ $category->name }}
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($category->products as $product)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <div class="h-48 w-full bg-amber-50 relative">
                                    @if($product->image && !str_contains($product->image, ':\\') && $product->image)
                                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-full w-full flex flex-col items-center justify-center bg-amber-100/50 text-amber-800">
                                            <i class="fa-solid fa-mug-hot text-5xl mb-2 opacity-70"></i>
                                            <span class="text-xs font-bold uppercase tracking-wider px-2 text-center text-amber-900">{{ $product->name }}</span>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 right-3 bg-amber-900 text-amber-100 font-extrabold px-3 py-1 rounded-xl text-sm shadow-md">
                                        {{ number_format($product->price, 3, '.', '') }} DT
                                    </span>
                                </div>

                                <div class="p-5 pb-4">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $product->name }}</h4>
                                    <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                                        {{ $product->description ?? 'Aucune description disponible.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-5 pt-0 mt-auto">
                                <a href="{{ route('products.show.public', $product->id) }}" class="block w-full text-center bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 font-semibold py-2 px-4 rounded-xl transition duration-200 shadow-sm">
                                    <i class="fa-solid fa-eye mr-2 text-amber-700"></i> Voir les détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @empty
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
            <i class="fa-solid fa-store-slash text-gray-300 text-5xl mb-3"></i>
            <p class="text-gray-500 font-medium">Aucun produit ou catégorie disponible pour le moment.</p>
        </div>
    @endforelse
</main>

{{-- ==================== RESERVATION & PRÉCOMMANDE ==================== --}}
<section id="reservation" class="bg-amber-950 text-white py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold font-serif text-amber-100 mb-4">Réservez & Pré-commandez</h2>
            <p class="text-amber-200/70 max-w-xl mx-auto">Configurez vos places et choisissez vos consommations à l'avance pour un service instantané.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/20 backdrop-blur-sm border border-red-400 text-red-100 p-4 rounded-xl mb-8 text-left shadow-lg max-w-2xl mx-auto">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-300 text-lg mt-0.5"></i>
                    <div>
                        <p class="font-bold mb-2">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form id="reservationForm" action="{{ route('reservations.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            @csrf
            
            {{-- Colonne 1 : Informations de réservation --}}
            <div class="bg-white text-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl lg:col-span-5 space-y-6 border border-amber-900/10 sticky top-24">
                <h3 class="text-xl font-bold font-serif text-amber-950 border-b border-amber-100 pb-3">
                    <i class="fa-regular fa-calendar-days text-amber-700 mr-2"></i>1. Informations de réservation
                </h3>
                
                <div>
                    <label class="block text-left text-sm font-semibold text-gray-700 mb-2">
                        <i class="fa-regular fa-calendar mr-1 text-amber-600"></i> Date & Heure
                    </label>
                    <input type="datetime-local" 
                           name="reservation_time" 
                           id="reservation_time" 
                           required 
                           value="{{ old('reservation_time') }}"
                           min="{{ date('Y-m-d\TH:i', strtotime('+1 hour')) }}"
                           class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-amber-600 focus:border-amber-600 outline-none transition">
                    <p class="text-xs text-gray-500 mt-1">Minimum 1 heure à l'avance</p>
                </div>
                
                <div>
                    <label class="block text-left text-sm font-semibold text-gray-700 mb-2">
                        <i class="fa-solid fa-users mr-1 text-amber-600"></i> Nombre de convives
                    </label>
                    <select name="guests" id="guests" required class="w-full border border-gray-300 rounded-xl p-3 bg-white focus:ring-2 focus:ring-amber-600 focus:border-amber-600 outline-none transition">
                        <option value="1" {{ old('guests') == 1 ? 'selected' : '' }}>👤 1 Personne (Solo work)</option>
                        <option value="2" {{ old('guests') == 2 ? 'selected' : '' }}>👥 2 Personnes</option>
                        <option value="3" {{ old('guests') == 3 ? 'selected' : '' }}>👥 3 Personnes</option>
                        <option value="4" {{ old('guests') == 4 ? 'selected' : '' }}>👨‍👩‍👧‍👦 4 Personnes</option>
                        <option value="6" {{ old('guests') == 6 ? 'selected' : '' }}>🎉 Espace groupe (6+)</option>
                    </select>
                </div>
                
                <div class="bg-amber-50 p-4 rounded-xl">
                    <p class="text-xs text-amber-800 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle"></i>
                        <span>Votre réservation sera confirmée dans les plus brefs délais.</span>
                    </p>
                </div>
                
                <div class="pt-4">
                    <button type="submit" id="submitBtn" class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-4 px-4 rounded-xl transition shadow-lg tracking-wide text-center flex items-center justify-center gap-2">
                        <span class="btn-text">Confirmer la réservation</span>
                        <div class="loading-spinner"></div>
                    </button>
                </div>
            </div>

            {{-- Colonne 2 : Sélection des produits (Pré-commande OPTIONNELLE) --}}
            <div class="bg-white text-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl lg:col-span-7 border border-amber-900/10">
                <h3 class="text-xl font-bold font-serif text-amber-950 border-b border-amber-100 pb-3 mb-6">
                    <i class="fa-solid fa-basket-shopping text-amber-700 mr-2"></i>2. Pré-commande <span class="text-sm font-normal text-gray-500">(Optionnel)</span>
                </h3>
                
                <div class="space-y-8 max-h-[500px] overflow-y-auto pr-2 products-scroll">
                    @forelse($categories as $category)
                        @if($category->products->count() > 0)
                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-wider text-amber-800 bg-amber-50 px-3 py-2 rounded-lg mb-4 shadow-sm border border-amber-100/50 flex items-center gap-2">
                                    <i class="fa-solid fa-tag text-amber-600 text-xs"></i>
                                    {{ $category->name }}
                                    <span class="text-xs font-normal text-gray-500 ml-auto">{{ $category->products->count() }} produits</span>
                                </h4>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($category->products as $product)
                                        <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50/30 transition shadow-sm group">
                                            <div class="flex flex-col pr-2 flex-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-900 text-sm leading-tight">{{ $product->name }}</span>
                                                    @if($product->description)
                                                        <div class="relative inline-block">
                                                            <i class="fa-regular fa-circle-question text-gray-400 text-xs cursor-help hover:text-amber-600 transition" title="{{ $product->description }}"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-amber-700 font-bold bg-amber-100/50 inline-block w-max px-2 py-0.5 rounded mt-1">
                                                    {{ number_format($product->price, 3, '.', '') }} DT
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center space-x-2 shrink-0 bg-gray-50 p-1 rounded-lg border border-gray-200 group-hover:border-amber-300 transition">
                                                <button type="button" class="decrement-qty w-6 h-6 rounded-md bg-gray-100 hover:bg-amber-600 hover:text-white transition flex items-center justify-center text-gray-600 font-bold" data-product="{{ $product->id }}">
                                                    <i class="fa-solid fa-minus text-xs"></i>
                                                </button>
                                                <input type="number" 
                                                       name="items[{{ $product->id }}][quantity]" 
                                                       id="qty_{{ $product->id }}"
                                                       min="0" 
                                                       max="20" 
                                                       value="0" 
                                                       class="quantity-input w-12 border-0 bg-white rounded p-1 text-center font-bold focus:ring-1 focus:ring-amber-600 outline-none text-sm shadow-inner">
                                                <button type="button" class="increment-qty w-6 h-6 rounded-md bg-gray-100 hover:bg-amber-600 hover:text-white transition flex items-center justify-center text-gray-600 font-bold" data-product="{{ $product->id }}">
                                                    <i class="fa-solid fa-plus text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-8">
                            <i class="fa-solid fa-plate-wheat text-gray-300 text-4xl mb-2"></i>
                            <p class="text-gray-400">Aucun produit disponible pour le moment.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">
                            <i class="fa-regular fa-clock mr-1"></i> La pré-commande est optionnelle
                        </span>
                        <span class="text-amber-700 font-semibold" id="totalProductsCount">0 produit(s) sélectionné(s)</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- ==================== FOOTER ==================== --}}
<footer class="bg-gray-950 text-gray-500 py-12 border-t border-gray-900">
    <div class="max-w-7xl mx-auto px-4 text-center space-y-6">
        <div class="flex justify-center items-center space-x-3 opacity-80">
            <img src="{{ asset('images/logo.png') }}" alt="9ahwa Logo Footer" class="h-10 w-10 grayscale rounded-full">
            <span class="text-white font-bold tracking-widest font-serif text-sm">9AHWA CAFÉ</span>
        </div>
        <p class="text-sm">📍 Tunis, Tunisie — 📞 +216 22 123 456</p>
        <div class="w-12 h-px bg-gray-800 mx-auto"></div>
        <p class="text-xs">&copy; {{ date('Y') }} 9ahwa. Conçu pour le plaisir du vrai café.</p>
        <p class="text-xs text-gray-600">
            Développé par
            <button onclick="openAbout()" class="text-amber-600 hover:text-amber-500 underline underline-offset-2 transition">
                Moez Ben Khelil
            </button>
        </p>
    </div>
</footer>

{{-- ==================== MODAL ABOUT ==================== --}}
<div id="modalAbout" class="fixed inset-0 z-50 hidden modal-overlay bg-black/50 flex items-center justify-center px-4">
    <div class="modal-box bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="bg-amber-950 px-8 py-7 relative text-white">
            <button onclick="closeAbout()" class="absolute top-4 right-4 text-white/50 hover:text-white transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-full bg-amber-600 flex items-center justify-center text-white font-black text-2xl font-serif shadow-lg shrink-0">MB</div>
                <div>
                    <h3 class="text-xl font-bold font-serif text-amber-100">Moez Ben Khelil</h3>
                    <p class="text-amber-300 text-sm mt-0.5">Développeur Web Full Stack</p>
                    <p class="text-amber-400/70 text-xs mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot"></i> Ariana, Tunisie
                    </p>
                </div>
            </div>
        </div>

        <div class="p-8 space-y-8">
            <div>
                <h4 class="text-base font-bold text-amber-950 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-mug-saucer text-amber-700"></i> À propos de cette application
                </h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    <strong class="text-amber-900">9ahwa — Caffée Rajel Kbir</strong> est une application web complète de gestion d'un café traditionnel tunisien.
                </p>
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach(['Laravel 11', 'PHP 8.3', 'Blade', 'Tailwind CSS', 'MySQL', 'MariaDB'] as $tech)
                        <span class="bg-amber-50 border border-amber-200 text-amber-900 text-xs font-semibold px-3 py-1.5 rounded-xl">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            <button onclick="closeAbout()" class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 rounded-xl transition text-sm">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>
    // Auto-hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.querySelectorAll('#flashMessage');
        flashMessages.forEach(message => {
            setTimeout(() => {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }, 5000);
        });
        
        // Set minimum datetime for reservation
        const datetimeInput = document.getElementById('reservation_time');
        if (datetimeInput) {
            const now = new Date();
            now.setHours(now.getHours() + 1);
            const minDateTime = now.toISOString().slice(0, 16);
            datetimeInput.min = minDateTime;
        }
        
        // Update total products count
        updateTotalCount();
    });
    
    // Quantity increment/decrement buttons
    document.querySelectorAll('.increment-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.product;
            const input = document.getElementById(`qty_${productId}`);
            let value = parseInt(input.value);
            if (value < 20) {
                input.value = value + 1;
                updateTotalCount();
            }
        });
    });
    
    document.querySelectorAll('.decrement-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.product;
            const input = document.getElementById(`qty_${productId}`);
            let value = parseInt(input.value);
            if (value > 0) {
                input.value = value - 1;
                updateTotalCount();
            }
        });
    });
    
    // Update total products count
    function updateTotalCount() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let total = 0;
        quantityInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        const totalSpan = document.getElementById('totalProductsCount');
        if (totalSpan) {
            totalSpan.textContent = total + ' produit(s) sélectionné(s)';
        }
    }
    
    // Validate quantity inputs
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value)) value = 0;
            if (value < 0) this.value = 0;
            if (value > 20) this.value = 20;
            updateTotalCount();
        });
    });
    
    // Form submission with loading state
    const form = document.getElementById('reservationForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validate datetime
            const datetime = document.getElementById('reservation_time').value;
            if (!datetime) {
                e.preventDefault();
                showToast('Veuillez sélectionner une date et heure', 'error');
                return;
            }
            
            const selectedDate = new Date(datetime);
            const now = new Date();
            if (selectedDate <= now) {
                e.preventDefault();
                showToast('La date et heure doivent être dans le futur', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });
    }
    
    // Toast notification function
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;
        
        const icons = {
            success: 'fa-circle-check',
            error: 'fa-circle-exclamation',
            info: 'fa-info-circle'
        };
        
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            info: 'bg-blue-500'
        };
        
        const toast = document.createElement('div');
        toast.className = `mb-3 ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3`;
        toast.style.animation = 'slideInRight 0.3s ease';
        toast.innerHTML = `
            <i class="fa-solid ${icons[type]} text-white text-xl"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white/80 hover:text-white">
                <i class="fa-solid fa-times"></i>
            </button>
        `;
        
        toastContainer.appendChild(toast);
        
        setTimeout(() => {
            if (toast && toast.parentElement) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }
    
    // Scroll to reservation section if there are errors
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            const reservationSection = document.getElementById('reservation');
            if (reservationSection) {
                reservationSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    @endif
    
    // Modal functions
    function openAbout() {
        document.getElementById('modalAbout').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeAbout() {
        document.getElementById('modalAbout').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

</body>
</html>