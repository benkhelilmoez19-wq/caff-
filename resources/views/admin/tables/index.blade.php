@extends('layouts.admin')

@section('title', 'Gestion des Tables')
@section('page_title', 'Gestion des Tables')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="bg-coffee-800 px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-white">
            <i class="fa-solid fa-chair mr-2"></i> Tables du restaurant
        </h2>
        <button onclick="openAddModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fa-solid fa-plus mr-2"></i> Ajouter une table
        </button>
    </div>
    
    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        @if($tables->isEmpty())
            <div class="text-center py-12">
                <i class="fa-solid fa-chair text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 mb-4">Aucune table configurée</p>
                <button onclick="openAddModal()" class="bg-coffee-600 hover:bg-coffee-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fa-solid fa-plus mr-2"></i> Ajouter votre première table
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tables as $table)
                <div class="border rounded-xl p-4 hover:shadow-lg transition {{ $table->is_available ? 'bg-white' : 'bg-gray-50' }}">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-bold text-lg text-coffee-800">{{ $table->table_number }}</h3>
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $table->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $table->is_available ? 'Disponible' : 'Indisponible' }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        <i class="fa-solid fa-users mr-1"></i> Capacité: {{ $table->capacity }} personnes
                    </p>
                    <div class="flex gap-2">
                        <button onclick="editTable({{ $table->id }}, '{{ $table->table_number }}', {{ $table->capacity }}, {{ $table->is_available }})" 
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm transition">
                            <i class="fa-solid fa-edit mr-1"></i> Modifier
                        </button>
                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Supprimer cette table ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition">
                                <i class="fa-solid fa-trash mr-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Modal Ajouter/Modifier -->
<div id="tableModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md">
        <h3 id="modalTitle" class="text-xl font-bold mb-4">Ajouter une table</h3>
        <form id="tableForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Numéro de table</label>
                <input type="text" name="table_number" id="table_number" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Capacité (personnes)</label>
                <input type="number" name="capacity" id="capacity" min="1" max="20" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_available" id="is_available" value="1" class="rounded">
                    <span class="text-sm font-medium">Table disponible</span>
                </label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-coffee-600 hover:bg-coffee-700 text-white py-2 rounded-lg transition">Enregistrer</button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg transition">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Ajouter une table';
        document.getElementById('tableForm').action = "{{ route('tables.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('table_number').value = '';
        document.getElementById('capacity').value = '';
        document.getElementById('is_available').checked = true;
        document.getElementById('tableModal').classList.remove('hidden');
        document.getElementById('tableModal').style.display = 'flex';
    }
    
    function editTable(id, tableNumber, capacity, isAvailable) {
        document.getElementById('modalTitle').textContent = 'Modifier la table';
        document.getElementById('tableForm').action = `/admin/tables/${id}`;
        document.getElementById('methodField').value = 'PUT';
        document.getElementById('table_number').value = tableNumber;
        document.getElementById('capacity').value = capacity;
        document.getElementById('is_available').checked = isAvailable == 1;
        document.getElementById('tableModal').classList.remove('hidden');
        document.getElementById('tableModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('tableModal').classList.add('hidden');
        document.getElementById('tableModal').style.display = 'none';
    }
    
    // Fermer en cliquant en dehors
    document.getElementById('tableModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection