@extends('layouts.app')

@section('title', $formation->nom . ' - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Navigation --}}
        <div class="flex items-center gap-2 mb-8">
            <a href="{{ route('formations.index') }}" 
               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Toutes les formations
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-600">{{ $formation->nom }}</span>
        </div>

        {{-- En-tête avec hero --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-lg p-8 mb-8">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $formation->nom }}</h1>
                    
                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-3 mb-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            <i class="fas fa-book mr-2"></i>{{ $formation->niveau }}
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-graduation-cap mr-2"></i>{{ $formation->domaine }}
                        </span>
                        @if($formation->est_active)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                <i class="fas fa-pause-circle mr-2"></i>Inactive
                            </span>
                        @endif
                    </div>

                    {{-- Université --}}
                    @if($formation->universite)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-university text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Offerte par</p>
                            <p class="font-semibold text-gray-900">{{ $formation->universite->nom }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Contenu principal --}}
            <div class="lg:col-span-2">
                
                {{-- Description --}}
                @if($formation->description)
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-align-left text-blue-600 mr-3"></i>
                        Description
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $formation->description }}</p>
                </div>
                @endif

                {{-- Prérequis --}}
                @if($formation->prerequis)
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        Prérequis
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $formation->prerequis }}</p>
                </div>
                @endif

                {{-- Débouchés --}}
                @if($formation->debouches)
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-briefcase text-purple-600 mr-3"></i>
                        Débouchés professionnels
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $formation->debouches }}</p>
                </div>
                @endif

                {{-- Informations détaillées en grille --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Durée --}}
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900">Durée</h4>
                        </div>
                        <p class="text-2xl font-bold text-blue-600">{{ $formation->duree_mois }} mois</p>
                    </div>

                    {{-- Frais d'inscription --}}
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-money-bill text-green-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900">Frais</h4>
                        </div>
                        <p class="text-2xl font-bold text-green-600">
                            @if($formation->frais_inscription)
                                {{ number_format($formation->frais_inscription, 0, ',', ' ') }} FCFA
                            @else
                                <span class="text-gray-400 text-sm">Non spécifié</span>
                            @endif
                        </p>
                    </div>

                    {{-- Places disponibles --}}
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-users text-purple-600"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900">Places</h4>
                        </div>
                        <p class="text-2xl font-bold {{ $formation->places_disponibles > 0 ? 'text-purple-600' : 'text-red-600' }}">
                            {{ $formation->places_disponibles }}
                        </p>
                    </div>

                    {{-- Date limite --}}
                    @if($formation->date_limite_inscription)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 {{ \Carbon\Carbon::parse($formation->date_limite_inscription)->isPast() ? 'bg-red-100' : 'bg-green-100' }} rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar {{ \Carbon\Carbon::parse($formation->date_limite_inscription)->isPast() ? 'text-red-600' : 'text-green-600' }}"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900">Date limite</h4>
                        </div>
                        <p class="text-lg font-bold {{ \Carbon\Carbon::parse($formation->date_limite_inscription)->isPast() ? 'text-red-600' : 'text-green-600' }}">
                            {{ \Carbon\Carbon::parse($formation->date_limite_inscription)->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($formation->date_limite_inscription)->diffForHumans() }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar Actions --}}
            <div class="space-y-6">
                {{-- Boutons d'action --}}
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        @if($formation->places_disponibles > 0 && $formation->est_active)
                            @if(!\Carbon\Carbon::parse($formation->date_limite_inscription)->isPast())
                                <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Postuler à cette formation
                                </button>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-4 rounded-lg cursor-not-allowed flex items-center justify-center">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Délai dépassé
                                </button>
                            @endif
                        @elseif($formation->places_disponibles <= 0)
                            <button disabled class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-4 rounded-lg cursor-not-allowed flex items-center justify-center">
                                <i class="fas fa-ban mr-2"></i>
                                Aucune place disponible
                            </button>
                        @endif
                        
                        <a href="{{ route('formations.index') }}" 
                           class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-list mr-2"></i>
                            Voir toutes les formations
                        </a>
                    </div>
                </div>

                {{-- Université --}}
                @if($formation->universite)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">À propos de l'université</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-university text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $formation->universite->nom }}</h4>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $formation->universite->ville }}, {{ $formation->universite->pays }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('universites.show', $formation->universite) }}" 
                       class="inline-flex items-center w-full justify-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-2 px-4 rounded-lg transition">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Voir l'université
                    </a>
                </div>
                @endif

                {{-- Contact --}}
                @if($formation->universite)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-phone text-blue-600 mr-2"></i>
                        Contact
                    </h3>
                    <div class="space-y-3">
                        @if($formation->universite->email)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <a href="mailto:{{ $formation->universite->email }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium break-all">
                                {{ $formation->universite->email }}
                            </a>
                        </div>
                        @endif
                        
                        @if($formation->universite->telephone)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Téléphone</p>
                            <a href="tel:{{ $formation->universite->telephone }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                {{ $formation->universite->telephone }}
                            </a>
                        </div>
                        @endif
                        
                        @if($formation->universite->site_web)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Site web</p>
                            <a href="{{ $formation->universite->site_web }}" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                <i class="fas fa-globe mr-1"></i>
                                Visiter
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Informations supplémentaires --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6">
                    <h4 class="text-sm font-bold text-gray-900 mb-3">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Informations
                    </h4>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Formation</span>
                            <span class="font-mono bg-white px-2 py-1 rounded">{{ $formation->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Créée le</span>
                            <span>{{ $formation->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dernière mise à jour</span>
                            <span>{{ $formation->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection