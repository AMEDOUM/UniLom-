@extends('layouts.admin')

@section('title', 'Gestion des Formations - Admin UniLomé')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- En-tête --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Formations</h1>
                <p class="text-gray-600 mt-2">Gérez toutes les formations proposées sur la plateforme</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('formations.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                    <i class="fas fa-plus mr-2"></i>Ajouter une formation
                </a>
            </div>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total formations</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $formations->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Formations actives</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $formations->where('est_active', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Universités</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ $formations->groupBy('universite_id')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-university text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Places totales</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $formations->sum('places_disponibles') }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Table des formations --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($formations->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Formation</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Université</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Niveau</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Durée</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Places</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Statut</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($formations as $formation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $formation->nom }}</p>
                                <p class="text-sm text-gray-600">{{ $formation->domaine }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($formation->universite)
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-university text-blue-600 text-sm"></i>
                                    </div>
                                    <span class="text-gray-900">{{ $formation->universite->nom }}</span>
                                </div>
                            @else
                                <span class="text-gray-400">Non assignée</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                {{ $formation->niveau }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">
                            {{ $formation->duree_mois }} mois
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 {{ $formation->places_disponibles > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-semibold rounded-full">
                                {{ $formation->places_disponibles }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($formation->est_active)
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-pause-circle mr-1"></i>Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('formations.edit', $formation) }}" 
                                   class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded hover:bg-blue-200 transition">
                                    <i class="fas fa-edit"></i> Éditer
                                </a>
                                <button onclick="confirmDelete({{ $formation->id }})" 
                                        class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200 transition">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                                <form id="delete-form-{{ $formation->id }}" action="{{ route('formations.destroy', $formation) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune formation</h3>
            <p class="text-gray-600 mb-6">Commencez par créer votre première formation</p>
            <a href="{{ route('formations.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                <i class="fas fa-plus mr-2"></i>Créer une formation
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(formationId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette formation ? Cette action est irréversible.')) {
        document.getElementById('delete-form-' + formationId).submit();
    }
}
</script>
@endsection
