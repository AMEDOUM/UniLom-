@extends('layouts.app')

@section('title', 'Gestion des formations - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Gestion des formations
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ $universite->nom_universite }}
                    </p>
                </div>
                <a href="{{ route('formations.create') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Nouvelle formation
                </a>
            </div>
            
            <!-- Statistiques -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $formations->count() }}</div>
                    <div class="text-gray-600">Formations</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $formations->where('est_active', true)->count() }}
                    </div>
                    <div class="text-gray-600">Actives</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $formations->where('niveau', 'licence')->count() }}
                    </div>
                    <div class="text-gray-600">Licences</div>
                </div>
            </div>
        </div>
        
        <!-- Liste des formations -->
        @if($formations->count() > 0)
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Formation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Niveau</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durée</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frais</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($formations as $formation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $formation->nom }}</div>
                            <div class="text-sm text-gray-500">{{ $formation->domaine }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $formation->niveau === 'licence' ? 'bg-blue-100 text-blue-800' : 
                                   ($formation->niveau === 'master' ? 'bg-green-100 text-green-800' : 
                                   'bg-purple-100 text-purple-800') }}">
                                {{ ucfirst($formation->niveau) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $formation->duree_formatee }}
                        </td>
                        <td class="px-6 py-4">
                            @if($formation->frais_scolarite_annuel)
                            <div class="text-sm font-medium text-gray-900">
                                {{ number_format($formation->frais_scolarite_annuel, 0, ',', ' ') }} FCFA
                            </div>
                            <div class="text-xs text-gray-500">par an</div>
                            @else
                            <span class="text-green-600 font-medium">Gratuit</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($formation->est_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('formations.show', $formation) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-4">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="text-yellow-600 hover:text-yellow-900 mr-4">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- État vide -->
        <div class="text-center py-16 bg-white rounded-xl shadow">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-book text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-3">
                Aucune formation pour l'instant
            </h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Commencez par ajouter vos premières formations pour les présenter aux étudiants.
            </p>
            <a href="{{ route('formations.create') }}" 
               class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Créer ma première formation
            </a>
        </div>
        @endif
    </div>
</div>
@endsection