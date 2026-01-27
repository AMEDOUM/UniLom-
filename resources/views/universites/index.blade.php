@extends('layouts.app')

@section('title', 'Universités de Lomé - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec recherche -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                 Universités de Lomé
            </h1>
            <p class="text-gray-600 mt-2">
                Découvrez, comparez et choisissez parmi {{ $universites->count() }} universités
            </p>
            
            <!-- Barre de recherche et filtres -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="grid md:grid-cols-4 gap-4">
                    <!-- Recherche par nom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                        <input type="text" placeholder="Nom de l'université..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Filtre par domaine -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Domaine</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Tous les domaines</option>
                            <option value="sciences">Sciences</option>
                            <option value="droit">Droit</option>
                            <option value="medecine">Médecine</option>
                            <option value="commerce">Commerce</option>
                            <option value="ingenierie">Ingénierie</option>
                        </select>
                    </div>
                    
                    <!-- Filtre par type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Public & Privé</option>
                            <option value="public">Public</option>
                            <option value="prive">Privé</option>
                        </select>
                    </div>
                    
                    <!-- Bouton recherche -->
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liste des universités -->
        @if($universites->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($universites as $universite)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 group">
                    <div class="p-6 flex flex-col h-full">
                        <!-- Logo et nom -->
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition">
                                <i class="fas fa-university text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-900 truncate">{{ $universite->nom }}</h3>
                                <p class="text-gray-500 text-sm">{{ $universite->ville }}</p>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        @if($universite->description)
                        <p class="text-gray-600 mb-4 text-sm line-clamp-2">
                            {{ $universite->description }}
                        </p>
                        @endif
                        
                        <!-- Formations -->
                        @if($universite->formations && $universite->formations->count() > 0)
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-gray-700 mb-2">Formations ({{ $universite->formations->count() }})</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($universite->formations->take(3) as $formation)
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded">
                                    {{ $formation->nom }}
                                </span>
                                @endforeach
                                @if($universite->formations->count() > 3)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">
                                    +{{ $universite->formations->count() - 3 }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Statut -->
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                {{ $universite->est_active ? '✓ Active' : 'Inactive' }}
                            </span>
                        </div>
                        
                        <!-- Bouton (flex-1 pour pousser en bas) -->
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ route('universites.show', $universite) }}" 
                               class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-medium transition">
                                <i class="fas fa-arrow-right mr-1"></i> Voir détails
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Carte "Ajouter votre université" (si connecté) -->
                @auth
                    @if(auth()->user()->role === 'universite' && auth()->user()->est_valide)
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-md overflow-hidden border-2 border-dashed border-blue-300 hover:shadow-lg transition duration-300">
                        <div class="p-6 h-full flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-plus text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-lg mb-2">Ajouter une formation</h3>
                            <p class="text-gray-600 mb-4 text-sm">
                                Proposez une nouvelle formation à vos étudiants
                            </p>
                            <a href="{{ route('formations.create') }}" 
                               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium transition">
                                <i class="fas fa-plus mr-1"></i> Créer
                            </a>
                        </div>
                    </div>
                    @endif
                @endauth
            </div>
        @else
        <!-- Aucune université -->
        <div class="bg-gray-50 rounded-xl p-12 text-center">
            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-university text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Aucune université disponible</h3>
            <p class="text-gray-600 mb-6">Les universités seront disponibles très bientôt</p>
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Retour à l'accueil
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>