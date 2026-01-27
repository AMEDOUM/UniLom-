@extends('layouts.app')

@section('title', 'Mes universités favorites - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Mes universités favorites
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ $favoris->total() }} université(s) sauvegardée(s)
                    </p>
                </div>
                
                <a href="/universites" 
                   class="text-blue-600 hover:text-blue-800">
                    ← Retour à la liste
                </a>
            </div>
        </div>
        
        <!-- Liste des favoris -->
        @if($favoris->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favoris as $universite)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 border-2 border-blue-100">
                <div class="p-6">
                    <!-- En-tête avec bouton retirer -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-university text-blue-600"></i>
                            </div>
                            <h3 class="font-bold text-lg">{{ $universite->nom }}</h3>
                        </div>
                        
                        <form action="{{ route('favoris.toggle', $universite->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="text-red-500 hover:text-red-700"
                                    title="Retirer des favoris">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-gray-600 mb-4 text-sm line-clamp-2">
                        {{ $universite->description ?? 'Aucune description disponible.' }}
                    </p>
                    
                    <!-- Infos -->
                    <div class="space-y-2 text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $universite->ville }}, {{ $universite->pays }}
                        </div>
                        @if($universite->nombre_etudiants)
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            {{ number_format($universite->nombre_etudiants) }} étudiants
                        </div>
                        @endif
                    </div>
                    
                    <!-- Boutons -->
                    <div class="flex space-x-2">
                        <a href="/universites/{{ $universite->id }}" 
                           class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                            Voir détails
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($favoris->hasPages())
        <div class="mt-10">
            {{ $favoris->links() }}
        </div>
        @endif
        
        @else
        <!-- État vide -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="far fa-star text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-3">
                Aucune université favorite
            </h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Vous n'avez pas encore ajouté d'université à vos favoris.
                Parcourez la liste et cliquez sur ❤️ pour en sauvegarder.
            </p>
            <a href="/universites" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Explorer les universités
            </a>
        </div>
        @endif
    </div>
</div>
@endsection