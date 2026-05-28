@extends('layouts.admin')

@section('title', 'Détails de l\'Utilisateur | Caffée Rajel Kbir')
@section('page_title', 'Fiche Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-sm text-stone-500 hover:text-coffee-900 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>

        <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-coffee-900 hover:bg-coffee-800 text-white text-xs font-semibold uppercase tracking-wider rounded-xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Modifier le profil
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-coffee-100 shadow-sm overflow-hidden">
        
        <div class="p-6 bg-coffee-50 border-b border-coffee-100 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-coffee-100 text-coffee-900 font-serif font-bold text-2xl flex items-center justify-center border-2 border-white shadow-md">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="font-serif text-2xl font-bold text-coffee-900">{{ $user->name }}</h2>
                <div class="mt-1">
                    @if($user->role === 'admin')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brick-600 text-white tracking-wide uppercase">
                            Administrateur
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-coffee-800 text-white tracking-wide uppercase">
                            Client
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-1">Adresse Email</span>
                    <div class="text-sm font-medium text-coffee-900 bg-coffee-50/50 px-4 py-2.5 rounded-xl border border-coffee-100/50">
                        {{ $user->email }}
                    </div>
                </div>

                <div>
                    <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-1">Numéro de Téléphone</span>
                    <div class="text-sm font-medium text-coffee-900 bg-coffee-50/50 px-4 py-2.5 rounded-xl border border-coffee-100/50">
                        {{ $user->phone ?? 'Aucun numéro enregistré' }}
                    </div>
                </div>
            </div>

            <hr class="border-coffee-100/60">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-1">Inscrit le</span>
                    <div class="text-sm text-stone-600">
                        {{ $user->created_at ? $user->created_at->format('d F Y à H:i') : 'Date inconnue' }}
                    </div>
                </div>

                <div>
                    <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-1">Dernière modification</span>
                    <div class="text-sm text-stone-600">
                        {{ $user->updated_at ? $user->updated_at->format('d F Y à H:i') : 'Jamais modifié' }}
                    </div>
                </div>
            </div>

        </div>

        <div class="p-4 bg-stone-50 border-t border-coffee-100/60 flex items-center justify-between text-xs text-stone-400">
            <span>Identifiant Système único: #{{ $user->id }}</span>
        </div>

    </div>
</div>
@endsection