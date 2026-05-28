@extends('layouts.admin')

@section('title', 'Gestion des Catégories | Caffée Rajel Kbir')
@section('page_title', 'Catégories')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="space-y-6" x-data="{ openAddModal: false, openEditModal: false, editId: '', editName: '', editDescription: '' }">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl flex items-center gap-2 shadow-sm animate-fade-in">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-brick-50 border border-brick-100 text-brick-700 text-sm rounded-xl space-y-1 shadow-sm">
            <p class="font-semibold">Veuillez corriger les erreurs suivantes :</p>
            <ul class="list-disc pl-5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif text-xl font-bold text-coffee-900">Liste des catégories disponibles</h2>
            <p class="text-xs text-stone-400 mt-0.5">Organisez les produits de votre menu (Cafés, Chichas, Boissons...).</p>
        </div>
        
        <button @click="openAddModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-coffee-900 hover:bg-coffee-800 text-white text-xs font-semibold uppercase tracking-wider rounded-xl shadow-sm transition cursor-pointer border-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nouvelle Catégorie
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-coffee-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-coffee-50 border-b border-coffee-100 text-xxs font-semibold uppercase tracking-wider text-coffee-900/60">
                    <th class="py-4 px-6 w-20">ID</th>
                    <th class="py-4 px-6 w-1/4">Nom de la catégorie</th>
                    <th class="py-4 px-6">Description</th>
                    <th class="py-4 px-6 text-right w-44">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-coffee-50 text-sm text-coffee-900">
                @forelse($categories as $category)
                    <tr class="hover:bg-coffee-50/40 transition">
                        <td class="py-4 px-6 font-mono text-xs text-stone-400">#{{ $category->id }}</td>
                        <td class="py-4 px-6 font-semibold text-coffee-900">{{ $category->name }}</td>
                        <td class="py-4 px-6 text-stone-500 max-w-md truncate">{{ $category->description ?? 'Aucune description rédigée.' }}</td>
                        <td class="py-4 px-6 text-right space-x-3">
                            <button @click="editId = '{{ $category->id }}'; editName = '{{ addslashes($category->name) }}'; editDescription = '{{ addslashes($category->description) }}'; openEditModal = true" 
                                    class="text-amber-600 hover:text-amber-800 font-medium text-xs uppercase tracking-wider transition cursor-pointer border-0 bg-transparent">
                                Modifier
                            </button>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer la catégorie &quot;{{ $category->name }}&quot; ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-brick-600 hover:text-brick-700 font-medium text-xs uppercase tracking-wider transition cursor-pointer border-0 bg-transparent">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-stone-400">
                            <svg class="w-12 h-12 mx-auto text-stone-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v4.25A2.25 2.25 0 0118 21.75H6a2.25 2.25 0 01-2.25-2.25V15a2.25 2.25 0 012.25-2.25z"/></svg>
                            <span class="text-sm">Aucune catégorie enregistrée pour le moment.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-show="openAddModal" class="fixed inset-0 bg-stone-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-transition style="display: none;">
        <div @click.outside="openAddModal = false" class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-coffee-100 overflow-hidden animate-slide-up">
            <div class="p-6 bg-coffee-50 border-b border-coffee-100 flex justify-between items-center">
                <h3 class="font-serif text-lg font-bold text-coffee-900">Ajouter une catégorie</h3>
                <button @click="openAddModal = false" class="text-stone-400 hover:text-stone-600 transition text-2xl border-0 bg-transparent cursor-pointer leading-none">&times;</button>
            </div>
            
            <form method="POST" action="{{ route('categories.store') }}" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Nom de la catégorie</label>
                    <input type="text" name="name" required placeholder="Ex: Boissons Chaudes, Chichas..." class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Description courte des produits de cette catégorie..." class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all resize-none"></textarea>
                </div>
                <div class="border-t border-coffee-100 pt-4 flex justify-end gap-3">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs font-medium rounded-xl transition cursor-pointer border-0">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-coffee-900 hover:bg-coffee-800 text-white text-xs font-medium rounded-xl shadow-sm transition cursor-pointer border-0">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openEditModal" class="fixed inset-0 bg-stone-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-transition style="display: none;">
        <div @click.outside="openEditModal = false" class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-coffee-100 overflow-hidden animate-slide-up">
            <div class="p-6 bg-coffee-50 border-b border-coffee-100 flex justify-between items-center">
                <h3 class="font-serif text-lg font-bold text-coffee-900">Modifier la catégorie</h3>
                <button @click="openEditModal = false" class="text-stone-400 hover:text-stone-600 transition text-2xl border-0 bg-transparent cursor-pointer leading-none">&times;</button>
            </div>
            
            <form method="POST" :action="'/admin/categories/' + editId" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Nom de la catégorie</label>
                    <input type="text" name="name" :value="editName" required class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all resize-none" x-model="editDescription"></textarea>
                </div>
                <div class="border-t border-coffee-100 pt-4 flex justify-end gap-3">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs font-medium rounded-xl transition cursor-pointer border-0">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-coffee-900 hover:bg-coffee-800 text-white text-xs font-medium rounded-xl shadow-sm transition cursor-pointer border-0">Sauvegarder les changements</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection