@extends('layouts.admin')

@section('title', 'Ajouter un Utilisateur | Caffée Rajel Kbir')
@section('page_title', 'Nouvel Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-sm text-stone-500 hover:text-coffee-900 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-coffee-100 shadow-sm overflow-hidden">
        <div class="p-6 bg-coffee-50 border-b border-coffee-100">
            <h2 class="font-serif text-xl font-bold text-coffee-900">Créer un nouveau compte</h2>
            <p class="text-xs text-stone-400 mt-1">Remplissez les informations ci-dessous pour inscrire un client ou un administrateur.</p>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Nom & Prénom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    placeholder="Ex: Mohamed Ali"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 placeholder-stone-400 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                @error('name') <p class="text-brick-700 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    placeholder="Ex: mohamed.ali@gmail.com"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 placeholder-stone-400 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                @error('email') <p class="text-brick-700 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Téléphone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        placeholder="Ex: +216 22 345 678"
                        class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 placeholder-stone-400 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                    @error('phone') <p class="text-brick-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role" class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Rôle Système</label>
                    <select name="role" id="role" required
                        class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                        <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Client</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role') <p class="text-brick-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Adresse Résidentielle</label>
                <textarea name="address" id="address" rows="3" placeholder="Ex: 45 Rue de la République, Zarzis"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 placeholder-stone-400 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all resize-none">{{ old('address') }}</textarea>
                @error('address') <p class="text-brick-700 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-coffee-900 uppercase tracking-wider mb-2">Mot de passe</label>
                <input type="password" name="password" id="password" required
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 placeholder-stone-400 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
                @error('password') <p class="text-brick-700 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-coffee-100 pt-4 flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-600 text-sm font-medium rounded-xl transition">
                    Annuler
                </a>
                <button type="submit" class="px-5 py-2.5 bg-coffee-900 hover:bg-coffee-800 text-white text-sm font-medium rounded-xl shadow-sm transition">
                    Enregistrer l'utilisateur
                </button>
            </div>

        </form>
    </div>
</div>
@endsection