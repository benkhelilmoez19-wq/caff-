@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs | Caffée Rajel Kbir')
@section('page_title', 'Liste des Utilisateurs')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-coffee-100 shadow-sm">
        <div>
            <h2 class="font-serif text-2xl font-bold text-coffee-900">Utilisateurs inscrits</h2>
            <p class="text-sm text-stone-400 mt-1">Gérez les comptes des clients, du personnel et des administrateurs.</p>
        </div>
        <div>
            {{-- Bouton Ajouter avec Route Laravel --}}
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-coffee-900 hover:bg-coffee-800 text-white text-sm font-medium rounded-xl shadow-sm transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Ajouter un utilisateur</span>
            </a>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-coffee-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <form method="GET" action="{{ route('users.index') }}" class="w-full md:w-96 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-stone-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un nom, email ou téléphone..." 
                class="w-full pl-10 pr-4 py-2.5 bg-coffee-50 border border-coffee-100 rounded-xl text-sm text-coffee-900 placeholder-stone-400 focus:outline-none focus:border-coffee-600 focus:bg-white transition-all">
        </form>

        <div class="flex items-center gap-2 w-full md:w-auto justify-end">
            <span class="text-xs text-stone-400 font-medium">Filtrer par rôle :</span>
            <a href="{{ route('users.index') }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ !request('role') ? 'bg-coffee-100 text-coffee-900' : 'bg-white border border-coffee-100 text-stone-600 hover:bg-coffee-50' }}">Tous</a>
            <a href="{{ route('users.index', ['role' => 'admin']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ request('role') === 'admin' ? 'bg-coffee-100 text-coffee-900' : 'bg-white border border-coffee-100 text-stone-600 hover:bg-coffee-50' }}">Admins</a>
            <a href="{{ route('users.index', ['role' => 'client']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ request('role') === 'client' ? 'bg-coffee-100 text-coffee-900' : 'bg-white border border-coffee-100 text-stone-600 hover:bg-coffee-50' }}">Clients</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-coffee-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-coffee-50 border-b border-coffee-100 text-xs font-semibold text-coffee-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Nom & Prénom</th>
                        <th class="px-6 py-4">Adresse Email</th>
                        <th class="px-6 py-4">Téléphone</th>
                        <th class="px-6 py-4">Rôle</th>
                        <th class="px-6 py-4">Date d'inscription</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-100 text-sm text-coffee-900">
                    @isset($users)
                        @forelse($users as $user)
                            <tr class="hover:bg-coffee-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-coffee-100 text-coffee-900 font-bold flex items-center justify-center border border-coffee-600/10">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-stone-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-stone-500">{{ $user->phone ?? 'Non renseigné' }}</td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-brick-600/10 text-brick-700 border border-brick-600/20">Administrateur</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Client</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-stone-400 text-xs">{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                                
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Bouton Détails --}}
                                        <a href="{{ route('users.show', $user->id) }}" class="p-2 bg-stone-100 hover:bg-stone-200 text-stone-600 rounded-lg transition" title="Détails">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        {{-- Bouton Modifier --}}
                                        <a href="{{ route('users.edit', $user->id) }}" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg border border-amber-200/50 transition" title="Modifier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        {{-- Bouton Supprimer --}}
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-brick-600/10 hover:bg-brick-600 text-brick-700 hover:text-white rounded-lg border border-brick-600/20 transition" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-stone-400">Aucun utilisateur trouvé.</td>
                            </tr>
                        @endforelse
                    @else
                        {{-- EXEMPLES STATIQUES DE SÉCURITÉ --}}
                        <tr class="hover:bg-coffee-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-coffee-100 text-coffee-900 font-bold flex items-center justify-center border border-coffee-600/10">A</div>
                                <span>Administrateur Exemple</span>
                            </td>
                            <td class="px-6 py-4 text-stone-500">admin@rajelkbir.com</td>
                            <td class="px-6 py-4 text-stone-500">+216 22 345 678</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-brick-600/10 text-brick-700 border border-brick-600/20">Administrateur</span>
                            </td>
                            <td class="px-6 py-4 text-stone-400 text-xs">26/05/2026 à 10:30</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2 text-stone-400">
                                    <span class="text-xs italic bg-stone-100 px-2 py-1 rounded">Mode Aperçu (Données absentes)</span>
                                </div>
                            </td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>
        
        {{-- Liens de pagination si nécessaire --}}
        @if(isset($users) && method_exists($users, 'links'))
            <div class="px-6 py-4 border-t border-coffee-100 bg-coffee-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection