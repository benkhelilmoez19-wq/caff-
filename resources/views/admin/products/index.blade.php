@extends('layouts.admin')

@section('title', 'Gestion des Produits | Caffée Rajel Kbir')
@section('page_title', 'Liste des Produits')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-coffee-100 shadow-sm">
        <div>
            <h2 class="font-serif font-bold text-2xl text-coffee-900">Catalogue des Produits</h2>
            <p class="text-sm text-stone-500">Visualisez et gérez les boissons et douceurs affichées sur votre vitrine.</p>
        </div>
        <div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 bg-brick-600 hover:bg-brick-700 text-white font-medium px-5 py-3 rounded-xl transition duration-200 shadow-sm cursor-pointer border-0 no-underline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Ajouter un produit</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products ?? [] as $product)
            <div class="bg-white rounded-2xl shadow-sm border border-coffee-100 overflow-hidden hover:shadow-md transition duration-200 flex flex-col justify-between h-full group">
                
                <div>
                    <div class="h-48 bg-stone-50 overflow-hidden relative border-b border-coffee-100 flex items-center justify-center">
                        @if(isset($product->image) && $product->image)
                            {{-- CORRECTION ICI : Utilisation de Storage::url pour une génération d'URL robuste --}}
                            <img src="{{ Storage::url(str_replace('\\', '/', $product->image)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-coffee-600/30 text-center flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-1" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                                <span class="text-[10px] font-medium tracking-wide uppercase text-stone-400">Aucune Image</span>
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-coffee-800 text-xs font-semibold px-2.5 py-1 rounded-lg shadow-xs border border-coffee-100/50">
                            {{ $product->category->name ?? 'Non classé' }}
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        <h3 class="font-serif font-bold text-lg text-coffee-900 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-stone-500 text-xs line-clamp-2 min-h-[32px]">
                            {{ $product->description ?? 'Aucune description fournie pour ce produit.' }}
                        </p>
                    </div>
                </div>

                <div class="p-5 pt-0 mt-auto border-t border-coffee-50/60 flex items-center justify-between gap-2">
                    <span class="text-base font-bold text-brick-600">
                        {{ number_format($product->price, 3, '.', ' ') }} DT
                    </span>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('products.edit', $product->id) }}" class="p-2 text-stone-400 hover:text-coffee-600 bg-stone-50 hover:bg-coffee-100/50 rounded-xl transition duration-150 no-underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/>
                            </svg>
                        </a>
                        
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');" class="inline m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-stone-400 hover:text-brick-600 bg-stone-50 hover:bg-brick-600/10 rounded-xl transition duration-150 border-0 cursor-pointer flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-coffee-100 p-12 text-center text-stone-400 shadow-sm">
                <svg class="w-14 h-14 mx-auto mb-3 text-stone-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125 0.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
                <p class="text-base font-semibold text-stone-600">Aucun produit trouvé</p>
                <p class="text-xs text-stone-400 mt-1">Commencez par ajouter votre premier produit à la carte pour remplir le catalogue.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection