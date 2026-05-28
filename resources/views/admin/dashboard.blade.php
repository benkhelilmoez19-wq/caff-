@extends('layouts.admin')

@section('title', 'Tableau de Bord | Caffée Rajel Kbir')
@section('page_title', 'Vue d\'ensemble')

@section('content')
<div class="space-y-8">
    
    <div class="bg-gradient-to-r from-coffee-900 to-coffee-800 text-white p-8 rounded-3xl shadow-md relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        <div class="relative z-10">
            <h2 class="font-serif text-3xl font-bold mb-2">Marhba bik, {{ Auth::user()->name ?? 'Admin' }} !</h2>
            <p class="text-coffee-100/80 max-w-xl">
                Voici les statistiques en temps réel pour la gestion de votre salon de thé **Caffée Rajel Kbir**.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-coffee-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-stone-400 font-medium tracking-wide uppercase">Produits en Stock</p>
                <h3 class="text-4xl font-bold text-coffee-900 mt-2 font-serif">{{ $totalProducts }}</h3>
                <a href="{{ route('products.index') }}" class="text-xs text-brick-600 hover:underline font-medium inline-flex items-center gap-1 mt-4">
                    Gérer les produits &rarr;
                </a>
            </div>
            <div class="p-4 bg-amber-50 text-amber-700 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-coffee-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-stone-400 font-medium tracking-wide uppercase">Clients Inscrits</p>
                <h3 class="text-4xl font-bold text-coffee-900 mt-2 font-serif">{{ $totalUsers }}</h3>
                <a href="/admin/users" class="text-xs text-brick-600 hover:underline font-medium inline-flex items-center gap-1 mt-4">
                    Voir la liste &rarr;
                </a>
            </div>
            <div class="p-4 bg-blue-50 text-blue-700 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292MM15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-coffee-100 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm text-stone-400 font-medium tracking-wide uppercase">Tables Réserver</p>
                <h3 class="text-4xl font-bold text-coffee-900 mt-2 font-serif">{{ $totalReservations }}</h3>
                <a href="/admin/reservations" class="text-xs text-brick-600 hover:underline font-medium inline-flex items-center gap-1 mt-4">
                    Vérifier le calendrier &rarr;
                </a>
            </div>
            <div class="p-4 bg-brick-600/10 text-brick-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-coffee-100">
        <h3 class="font-serif text-xl font-bold text-coffee-900 mb-4">Actions Rapides</h3>
        <div class="flex flex-wrap gap-4">
            <a href="/products/create" class="px-4 py-2 bg-coffee-900 hover:bg-coffee-600 text-white text-sm font-medium rounded-xl transition-colors">
                + Ajouter un Produit
            </a>
            <a href="/admin/categories" class="px-4 py-2 bg-coffee-100 hover:bg-coffee-600/10 text-coffee-900 text-sm font-medium rounded-xl transition-colors">
                Gérer les Catégories
            </a>
        </div>
    </div>

</div>
@endsection