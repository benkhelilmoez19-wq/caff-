@extends('layouts.admin')

@section('title', 'Réservations | Admin')
@section('page_title', 'Réservations Table')

@section('content')

{{-- Alertes --}}
@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl shadow-sm">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
@endif

{{-- En-tête --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="font-serif text-2xl font-bold text-coffee-900">Réservations de Tables</h2>
        <p class="text-sm text-stone-400 mt-1">{{ $reservations->total() }} réservation(s) au total</p>
    </div>

    {{-- Filtre par statut --}}
    <div class="flex items-center gap-2">
        @foreach(['all' => 'Toutes', 'pending' => 'En attente', 'confirmed' => 'Confirmées', 'cancelled' => 'Annulées'] as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium border transition
               {{ request('status', 'all') === $val 
                  ? 'bg-coffee-900 text-white border-coffee-900' 
                  : 'bg-white text-coffee-700 border-coffee-100 hover:border-coffee-600' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

{{-- Tableau --}}
<div class="bg-white rounded-2xl shadow-sm border border-coffee-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-coffee-50 border-b border-coffee-100">
                <th class="px-6 py-4 text-left font-semibold text-coffee-800">#</th>
                <th class="px-6 py-4 text-left font-semibold text-coffee-800">Client</th>
                <th class="px-6 py-4 text-left font-semibold text-coffee-800">Table</th>
                <th class="px-6 py-4 text-left font-semibold text-coffee-800">Date & Heure</th>
                <th class="px-6 py-4 text-center font-semibold text-coffee-800">Statut</th>
                <th class="px-6 py-4 text-center font-semibold text-coffee-800">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-coffee-50">
            @forelse($reservations as $res)
            <tr class="hover:bg-coffee-50/50 transition duration-150">

                {{-- ID --}}
                <td class="px-6 py-4 text-stone-400 font-mono text-xs">#{{ $res->id }}</td>

                {{-- Client --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-coffee-100 text-coffee-900 font-bold flex items-center justify-center text-sm border border-coffee-200">
                            {{ strtoupper(substr($res->user->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-coffee-900">{{ $res->user->name ?? 'Inconnu' }}</p>
                            <p class="text-xs text-stone-400">{{ $res->user->email ?? '' }}</p>
                        </div>
                    </div>
                </td>

                {{-- Table --}}
                <td class="px-6 py-4">
                    @if($res->tableData)
                        <span class="font-medium text-coffee-800">Table {{ $res->tableData->table_number }}</span>
                        <p class="text-xs text-stone-400">{{ $res->tableData->capacity }} places</p>
                    @else
                        <span class="text-stone-400">—</span>
                    @endif
                </td>

                {{-- Date --}}
                <td class="px-6 py-4 text-coffee-700">
                    {{ \Carbon\Carbon::parse($res->reservation_time)->format('d/m/Y') }}
                    <p class="text-xs text-stone-400">{{ \Carbon\Carbon::parse($res->reservation_time)->format('H:i') }}</p>
                </td>

                {{-- Statut badge --}}
                <td class="px-6 py-4 text-center">
                    @php
                        $badges = [
                            'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                            'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-600 border-red-200',
                        ];
                        $labels = [
                            'pending'   => 'En attente',
                            'confirmed' => 'Confirmée',
                            'cancelled' => 'Annulée',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $badges[$res->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $labels[$res->status] ?? $res->status }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">

                        {{-- Voir détails --}}
                        <button onclick="openDetails({{ $res->id }}, @json($res->products))"
                                class="p-2 rounded-lg bg-coffee-50 text-coffee-700 hover:bg-coffee-100 transition" title="Voir produits">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>

                        {{-- Changer statut --}}
                        <button onclick="openStatus({{ $res->id }}, '{{ $res->status }}')"
                                class="p-2 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 transition" title="Changer statut">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>

                        {{-- Supprimer --}}
                        <form method="POST" action="{{ route('reservations.destroy', $res->id) }}"
                              onsubmit="return confirm('Supprimer cette réservation ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Supprimer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-stone-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-coffee-100" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="font-medium">Aucune réservation trouvée</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($reservations->hasPages())
    <div class="px-6 py-4 border-t border-coffee-100 bg-coffee-50/50">
        {{ $reservations->links() }}
    </div>
    @endif
</div>


{{-- ===== MODAL PRODUITS ===== --}}
<div id="modalDetails" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 flex">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="bg-coffee-900 px-6 py-4 flex items-center justify-between">
            <h3 class="font-serif text-white font-bold text-lg">Produits commandés</h3>
            <button onclick="closeDetails()" class="text-white/60 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <ul id="productList" class="divide-y divide-coffee-50 text-sm"></ul>
            <div id="noProducts" class="hidden text-center text-stone-400 py-6">Aucun produit associé.</div>
        </div>
        <div class="px-6 pb-5">
            <button onclick="closeDetails()" class="w-full py-2.5 rounded-xl bg-coffee-50 text-coffee-800 font-medium hover:bg-coffee-100 transition text-sm">
                Fermer
            </button>
        </div>
    </div>
</div>

{{-- ===== MODAL STATUT ===== --}}
<div id="modalStatus" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 flex">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <div class="bg-coffee-900 px-6 py-4 flex items-center justify-between">
            <h3 class="font-serif text-white font-bold text-lg">Changer le statut</h3>
            <button onclick="closeStatus()" class="text-white/60 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="statusForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div class="space-y-2">
                @foreach(['pending' => ['En attente', 'amber'], 'confirmed' => ['Confirmée', 'green'], 'cancelled' => ['Annulée', 'red']] as $val => [$label, $color])
                <label class="flex items-center gap-3 p-3 rounded-xl border border-coffee-100 hover:bg-coffee-50 cursor-pointer transition">
                    <input type="radio" name="status" value="{{ $val }}"
                           class="accent-coffee-800 w-4 h-4">
                    <span class="text-sm font-medium text-coffee-800">{{ $label }}</span>
                </label>
                @endforeach
            </div>
            <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-coffee-900 text-white font-medium hover:bg-coffee-800 transition text-sm">
                Enregistrer
            </button>
        </form>
    </div>
</div>


<script>
    // --- Modal Produits ---
    function openDetails(id, products) {
        const list = document.getElementById('productList');
        const empty = document.getElementById('noProducts');
        list.innerHTML = '';

        if (!products || products.length === 0) {
            empty.classList.remove('hidden');
        } else {
            empty.classList.add('hidden');
            products.forEach(p => {
                list.innerHTML += `
                    <li class="flex items-center justify-between py-3">
                        <span class="text-coffee-900">${p.name}</span>
                        <div class="flex items-center gap-3">
                            <span class="text-stone-400 text-xs">${p.price} DT</span>
                            <span class="bg-coffee-100 text-coffee-800 text-xs font-bold px-2 py-0.5 rounded-full">x${p.pivot.quantity}</span>
                        </div>
                    </li>`;
            });
        }
        document.getElementById('modalDetails').classList.remove('hidden');
    }
    function closeDetails() {
        document.getElementById('modalDetails').classList.add('hidden');
    }

    // --- Modal Statut ---
    function openStatus(id, currentStatus) {
        const form = document.getElementById('statusForm');
        form.action = `/admin/reservations/${id}/status`;
        form.querySelectorAll('input[name="status"]').forEach(r => {
            r.checked = r.value === currentStatus;
        });
        document.getElementById('modalStatus').classList.remove('hidden');
    }
    function closeStatus() {
        document.getElementById('modalStatus').classList.add('hidden');
    }

    // Fermer en cliquant hors modal
    ['modalDetails', 'modalStatus'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });
</script>

@endsection