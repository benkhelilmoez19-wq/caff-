@extends('layouts.admin')

@section('title', 'Ajouter un Produit | Caffée Rajel Kbir')
@section('page_title', 'Nouveau Produit')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-stone-500 hover:text-coffee-900 transition duration-150 group no-underline">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Retour à la liste</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-coffee-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-coffee-100 bg-coffee-50/30">
            <h2 class="font-serif font-bold text-xl text-coffee-900">Ajouter un nouveau délice à la carte</h2>
            <p class="text-xs text-stone-500 mt-1">Remplissez les informations ci-dessous pour publier le produit sur la vitrine client.</p>
        </div>

        @if ($errors->any())
            <div class="p-4 mx-6 mt-6 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1">
                <p class="font-semibold">Veuillez corriger les erreurs suivantes :</p>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-3 flex flex-col items-center lg:items-start">
                    <label class="block text-sm font-semibold text-coffee-900">Illustration du produit</label>
                    
                    <div class="relative w-full aspect-square max-w-[260px] bg-stone-50 rounded-2xl border-2 border-dashed border-stone-200 hover:border-coffee-600/40 transition flex flex-col items-center justify-center overflow-hidden p-2 group">
                        
                        <img id="image-preview" src="#" alt="Aperçu" class="hidden w-full h-full object-cover rounded-xl">
                        
                        <div id="preview-placeholder" class="text-center p-4 space-y-2 pointer-events-none">
                            <div class="mx-auto w-10 h-10 rounded-xl bg-coffee-100/60 flex items-center justify-center text-coffee-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-stone-600">Aucune image sélectionnée</p>
                            <p class="text-[10px] text-stone-400">PNG, JPG ou WEBP (Max. 2Mo)</p>
                        </div>

                        <button type="button" id="clear-image" class="hidden absolute top-3 right-3 bg-white/90 hover:bg-white text-stone-700 hover:text-brick-600 shadow-sm p-1.5 rounded-full transition cursor-pointer border-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <label class="w-full max-w-[260px] inline-flex items-center justify-center gap-2 bg-coffee-100 hover:bg-coffee-200/80 text-coffee-900 text-xs font-semibold px-4 py-2.5 rounded-xl transition cursor-pointer shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span>Choisir un fichier</span>
                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                    </label>
                </div>

                <div class="lg:col-span-2 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="name" class="block text-sm font-semibold text-coffee-900">Nom du produit <span class="text-brick-600">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Ex: Capucin, Thé aux pignons..." required
                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-coffee-600 focus:ring-2 focus:ring-coffee-600/10 outline-none transition text-sm bg-stone-50/30">
                        </div>

                        <div class="space-y-1.5">
                            <label for="category_id" class="block text-sm font-semibold text-coffee-900">Catégorie <span class="text-brick-600">*</span></label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-coffee-600 focus:ring-2 focus:ring-coffee-600/10 outline-none transition text-sm bg-white cursor-pointer shadow-sm">
                                <option value="" disabled selected>Choisir une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5 w-full md:w-1/2">
                        <label for="price" class="block text-sm font-semibold text-coffee-900">Prix de vente <span class="text-brick-600">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.001" name="price" id="price" value="{{ old('price') }}" placeholder="0.000" required
                                class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-stone-200 focus:border-coffee-600 focus:ring-2 focus:ring-coffee-600/10 outline-none transition text-sm bg-stone-50/30">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-xs font-bold text-coffee-800">
                                DT
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="description" class="block text-sm font-semibold text-coffee-900">Description / Ingrédients</label>
                        <textarea name="description" id="description" rows="4" placeholder="Décrivez votre produit (ex: Thé vert traditionnel, menthe fraîche de Kebili, pignons croquants)..."
                            class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-coffee-600 focus:ring-2 focus:ring-coffee-600/10 outline-none transition text-sm resize-none bg-stone-50/30">{{ old('description') }}</textarea>
                    </div>
                </div>

            </div>

            <div class="pt-5 border-t border-coffee-100 flex items-center justify-end gap-3">
                <a href="{{ route('products.index') }}" 
                    class="px-5 py-2.5 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 transition font-medium text-sm text-center no-underline">
                    Annuler
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 rounded-xl bg-brick-600 hover:bg-brick-700 text-white font-medium text-sm transition shadow-sm cursor-pointer border-0">
                    Enregistrer le produit
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');
        const clearBtn = document.getElementById('clear-image');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    imagePreview.setAttribute('src', this.result);
                    imagePreview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    clearBtn.classList.remove('hidden');
                });
                
                reader.readAsDataURL(file);
            }
        });

        // Supprimer l'image choisie
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            imageInput.value = ''; // Réinitialise l'input file
            imagePreview.setAttribute('src', '#');
            imagePreview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            clearBtn.classList.add('hidden');
        });
    });
</script>
@endsection