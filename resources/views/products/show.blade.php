<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — 9ahwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-amber-50/30 text-gray-800 font-sans antialiased min-h-screen">

{{-- ==================== NAVBAR ==================== --}}
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="9ahwa Logo"
                     class="h-16 w-16 object-contain rounded-full border border-amber-200">
                <span class="text-xl font-black text-amber-950 tracking-wider font-serif">9AHWA</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-2 text-gray-600 hover:text-amber-700 font-medium transition text-sm">
                    <i class="fa-solid fa-arrow-left text-amber-700"></i>
                    Retour à la carte
                </a>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('products.index') }}"
                           class="bg-amber-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-amber-900 transition shadow">
                            Dashboard Admin
                        </a>
                    @else
                        <span class="text-amber-900 font-semibold bg-amber-100/60 px-3 py-1.5 rounded-md text-sm">
                            ☕ {{ Auth::user()->name }}
                        </span>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ==================== BREADCRUMB ==================== --}}
<div class="max-w-5xl mx-auto px-4 pt-6">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-amber-700 transition">
            <i class="fa-solid fa-house text-xs"></i> Accueil
        </a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        <a href="{{ route('home') }}#menu" class="hover:text-amber-700 transition">Menu</a>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        <span class="text-amber-800 font-semibold">{{ $product->name }}</span>
    </nav>
</div>

{{-- ==================== CONTENU PRINCIPAL ==================== --}}
<main class="max-w-5xl mx-auto px-4 py-10">

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- ---- IMAGE ---- --}}
            <div class="h-80 md:h-full min-h-80 bg-amber-100 relative">
                @if($product->image && !str_contains($product->image, ':\\'))
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-amber-700 min-h-80">
                        <i class="fa-solid fa-mug-hot text-8xl mb-3 opacity-40"></i>
                        <span class="text-sm font-semibold text-amber-800 opacity-60 px-4 text-center">
                            {{ $product->name }}
                        </span>
                    </div>
                @endif

                {{-- Badge catégorie --}}
                <span class="absolute top-4 left-4 bg-amber-950/80 text-amber-100 text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-mug-saucer mr-1"></i>
                    {{ $product->category->name ?? 'Non classé' }}
                </span>

                {{-- Badge prix --}}
                <span class="absolute bottom-4 right-4 bg-amber-900 text-amber-100 font-extrabold px-4 py-2 rounded-2xl text-lg shadow-lg">
                    {{ number_format($product->price, 3, '.', '') }} DT
                </span>
            </div>

            {{-- ---- INFOS ---- --}}
            <div class="p-8 md:p-10 flex flex-col justify-between">
                <div>
                    {{-- Nom --}}
                    <h1 class="text-3xl font-black text-gray-900 font-serif mb-2 leading-tight">
                        {{ $product->name }}
                    </h1>

                    {{-- Catégorie --}}
                    <p class="text-sm text-amber-700 font-semibold mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-tag text-xs"></i>
                        {{ $product->category->name ?? 'Non classé' }}
                    </p>

                    {{-- Description --}}
                    <div class="mb-8">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                            Description
                        </h2>
                        @if($product->description)
                            <p class="text-gray-700 leading-relaxed text-sm whitespace-pre-line">
                                {{ $product->description }}
                            </p>
                        @else
                            <p class="text-gray-400 italic text-sm">
                                Aucune description disponible pour ce produit.
                            </p>
                        @endif
                    </div>

                    <div class="border-t border-amber-100 mb-6"></div>

                    {{-- Prix mis en avant --}}
                    <div class="flex items-center justify-between bg-amber-50 border border-amber-200 rounded-2xl px-6 py-4 mb-6">
                        <div>
                            <p class="text-xs text-amber-700 font-semibold uppercase tracking-wide">Prix</p>
                            <p class="text-3xl font-black text-amber-900 mt-0.5">
                                {{ number_format($product->price, 3, '.', '') }}
                                <span class="text-base font-semibold text-amber-700">DT</span>
                            </p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center text-amber-700">
                            <i class="fa-solid fa-mug-hot text-2xl"></i>
                        </div>
                    </div>

                    {{-- Infos supplémentaires --}}
                    <div class="grid grid-cols-2 gap-3 mb-8">
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-center border border-gray-100">
                            <p class="text-xs text-gray-400 mb-1">Catégorie</p>
                            <p class="text-sm font-bold text-gray-800">
                                {{ $product->category->name ?? '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-center border border-gray-100">
                            <p class="text-xs text-gray-400 mb-1">Disponibilité</p>
                            <p class="text-sm font-bold text-green-600">
                                <i class="fa-solid fa-circle-check text-xs mr-1"></i>Disponible
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Boutons action --}}
                <div class="space-y-3">
                    <a href="{{ route('home') }}#reservation"
                       class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-calendar-check"></i>
                        Réserver une table
                    </a>
                    <a href="{{ route('home') }}#menu"
                       class="w-full bg-amber-50 hover:bg-amber-100 text-amber-900 font-bold py-3 px-4 rounded-xl transition border border-amber-200 flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                        Retour au menu
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== PRODUITS SIMILAIRES ==================== --}}
    @if($related->count() > 0)
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-amber-950 font-serif mb-2">
                Dans la même catégorie
            </h3>
            <div class="w-16 h-1 bg-amber-600 rounded-full mb-8"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($related as $rel)
                    <a href="{{ route('products.show.public', $rel->id) }}"
                       class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">

                        {{-- Image --}}
                        <div class="h-40 w-full bg-amber-50 relative overflow-hidden">
                            @if($rel->image && !str_contains($rel->image, ':\\'))
                                <img src="{{ asset('storage/' . $rel->image) }}"
                                     alt="{{ $rel->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-amber-100/50 text-amber-700">
                                    <i class="fa-solid fa-mug-hot text-4xl opacity-50"></i>
                                </div>
                            @endif

                            <span class="absolute top-2 right-2 bg-amber-900 text-amber-100 font-bold px-2.5 py-0.5 rounded-lg text-xs shadow">
                                {{ number_format($rel->price, 3, '.', '') }} DT
                            </span>
                        </div>

                        {{-- Texte --}}
                        <div class="p-4 flex-grow">
                            <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1">{{ $rel->name }}</h4>
                            <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed">
                                {{ $rel->description ?? 'Aucune description disponible.' }}
                            </p>
                        </div>

                        <div class="px-4 pb-4">
                            <span class="w-full bg-amber-800 text-white text-xs font-bold py-2 px-3 rounded-lg flex items-center justify-center gap-1 group-hover:bg-amber-900 transition">
                                <i class="fa-regular fa-eye text-xs"></i> Voir les détails
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</main>

{{-- ==================== FOOTER ==================== --}}
<footer class="bg-gray-950 text-gray-500 py-12 border-t border-gray-900 mt-16">
    <div class="max-w-7xl mx-auto px-4 text-center space-y-6">
        <div class="flex justify-center items-center space-x-3 opacity-80">
            <img src="{{ asset('images/logo.png') }}" alt="9ahwa Logo Footer"
                 class="h-10 w-10 grayscale rounded-full">
            <span class="text-white font-bold tracking-widest font-serif text-sm">9AHWA CAFÉ</span>
        </div>
        <p class="text-sm">📍 Tunis, Tunisie — 📞 +216 22 123 456</p>
        <div class="w-12 h-px bg-gray-800 mx-auto"></div>
        <p class="text-xs">&copy; {{ date('Y') }} 9ahwa. Conçu pour le plaisir du vrai café.</p>
        <p class="text-xs text-gray-600">
            Développé par <span class="text-amber-600">Moez Ben Khelil</span>
        </p>
    </div>
</footer>

</body>
</html>