@extends('layouts.app')

@section('title', 'Statistiques - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- En-tête --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Statistiques de la plateforme</h1>
        <p class="text-gray-600 mt-2">Analyses et données sur l'utilisation de UniLomé</p>
    </div>
    
    {{-- Bouton retour --}}
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
            ← Retour au dashboard
        </a>
    </div>
    
    {{-- Statistiques générales --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Utilisateurs total</p>
                    <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-university text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Universités</p>
                    <h3 class="text-2xl font-bold">{{ $totalUniversites }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Formations</p>
                    <h3 class="text-2xl font-bold">{{ $totalFormations }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Répartition des utilisateurs --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">Répartition des utilisateurs</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span>Étudiants</span>
                    </div>
                    <div class="font-medium">{{ $etudiants }} ({{ $totalUsers > 0 ? round(($etudiants/$totalUsers)*100) : 0 }}%)</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span>Universités</span>
                    </div>
                    <div class="font-medium">{{ $universitesUsers }} ({{ $totalUsers > 0 ? round(($universitesUsers/$totalUsers)*100) : 0 }}%)</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span>Administrateurs</span>
                    </div>
                    <div class="font-medium">{{ $admins }} ({{ $totalUsers > 0 ? round(($admins/$totalUsers)*100) : 0 }}%)</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold mb-4">Statut des universités</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span>Actives</span>
                    </div>
                    <div class="font-medium">{{ $activeUniversites }} / {{ $totalUniversites }}</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span>Publiques</span>
                    </div>
                    <div class="font-medium">{{ $publicUniversites }} / {{ $totalUniversites }}</div>
                </div>
                
                @if($totalUniversites > 0)
                <div class="mt-4 pt-4 border-t">
                    <div class="text-sm text-gray-500">Taux d'activation</div>
                    <div class="flex items-center mt-1">
                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" 
                                 style="width: {{ ($activeUniversites/$totalUniversites)*100 }}%"></div>
                        </div>
                        <div class="ml-3 text-sm font-medium">
                            {{ round(($activeUniversites/$totalUniversites)*100) }}%
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Formations par domaine --}}
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h3 class="text-lg font-semibold mb-4">Formations par domaine</h3>
        
        @if($formationsParDomaine->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Domaine</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre de formations</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pourcentage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barre</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($formationsParDomaine as $domaine)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $domaine->domaine }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium">{{ $domaine->total }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ $totalFormations > 0 ? round(($domaine->total/$totalFormations)*100) : 0 }}%
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" 
                                         style="width: {{ $totalFormations > 0 ? ($domaine->total/$totalFormations)*100 : 0 }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Aucune formation disponible</p>
        @endif
    </div>
    
    {{-- Dernières activités --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold mb-4">Dernières activités</h3>
        
        <div class="space-y-4">
            {{-- Activité 1 --}}
            <div class="flex items-start">
                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium">Nouvel utilisateur inscrit</p>
                    <p class="text-sm text-gray-500">Il y a 2 heures</p>
                </div>
            </div>
            
            {{-- Activité 2 --}}
            <div class="flex items-start">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <i class="fas fa-university text-green-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium">Nouvelle université ajoutée</p>
                    <p class="text-sm text-gray-500">Hier à 14:30</p>
                </div>
            </div>
            
            {{-- Activité 3 --}}
            <div class="flex items-start">
                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                    <i class="fas fa-graduation-cap text-purple-600"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium">3 nouvelles formations publiées</p>
                    <p class="text-sm text-gray-500">Il y a 2 jours</p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t text-center">
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">
                Voir toutes les activités →
            </a>
        </div>
    </div>
    
    {{-- Actions --}}
    <div class="mt-8 flex justify-between items-center">
        <div class="text-sm text-gray-500">
            Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
        </div>
        
        <div class="space-x-3">
            <button onclick="window.print()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                <i class="fas fa-print mr-2"></i> Imprimer
            </button>
            <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-download mr-2"></i> Exporter
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection