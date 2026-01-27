@extends('layouts.app')

@section('title', 'Créer une formation - UniLomé')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        {{-- En-tête --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Créer une nouvelle formation</h1>
            <p class="mt-2 text-gray-600">Remplissez les informations ci-dessous pour ajouter une nouvelle formation.</p>
        </div>

        {{-- Carte du formulaire --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- En-tête de la carte --}}
            <div class="bg-indigo-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-white">Informations de la formation</h2>
                </div>
            </div>

            {{-- Corps du formulaire --}}
            <div class="p-6">
                <form action="{{ route('formations.store') }}" method="POST">
                    @csrf

                    {{-- Grille responsive --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Nom de la formation --}}
                        <div class="md:col-span-2">
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom de la formation *
                            </label>
                            <input type="text" 
                                   id="nom" 
                                   name="nom" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>

                        {{-- Domaine --}}
                        <div>
                            <label for="domaine" class="block text-sm font-medium text-gray-700 mb-1">
                                Domaine *
                            </label>
                            <select id="domaine" 
                                    name="domaine" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">Sélectionnez un domaine</option>
                                <option value="Informatique">Informatique</option>
                                <option value="Génie Civil">Génie Civil</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Médecine">Médecine</option>
                                <option value="Droit">Droit</option>
                                <option value="Sciences">Sciences</option>
                                <option value="Lettres">Lettres</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        {{-- Niveau --}}
                        <div>
                            <label for="niveau" class="block text-sm font-medium text-gray-700 mb-1">
                                Niveau *
                            </label>
                            <select id="niveau" 
                                    name="niveau" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">Sélectionnez un niveau</option>
                                <option value="Licence">Licence</option>
                                <option value="Master">Master</option>
                                <option value="Doctorat">Doctorat</option>
                                <option value="BTS">BTS</option>
                                <option value="DUT">DUT</option>
                            </select>
                        </div>

                        {{-- Université --}}
                        <div class="md:col-span-2">
                            <label for="universite_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Université *
                            </label>
                            <select id="universite_id" 
                                    name="universite_id" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">Sélectionnez une université</option>
                                @foreach($universites as $universite)
                                    <option value="{{ $universite->id }}">
                                        {{ $universite->nom }} ({{ $universite->ville }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Durée --}}
                        <div>
                            <label for="duree_mois" class="block text-sm font-medium text-gray-700 mb-1">
                                Durée (mois)
                            </label>
                            <input type="number" 
                                   id="duree_mois" 
                                   name="duree_mois" 
                                   value="36"
                                   min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>

                        {{-- Frais d'inscription --}}
                        <div>
                            <label for="frais_inscription" class="block text-sm font-medium text-gray-700 mb-1">
                                Frais d'inscription (FCFA)
                            </label>
                            <input type="number" 
                                   id="frais_inscription" 
                                   name="frais_inscription" 
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                        </div>

                        {{-- Prérequis --}}
                        <div class="md:col-span-2">
                            <label for="prerequis" class="block text-sm font-medium text-gray-700 mb-1">
                                Prérequis
                            </label>
                            <textarea id="prerequis" 
                                      name="prerequis" 
                                      rows="2"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                        </div>

                        {{-- Débouchés --}}
                        <div class="md:col-span-2">
                            <label for="debouches" class="block text-sm font-medium text-gray-700 mb-1">
                                Débouchés professionnels
                            </label>
                            <textarea id="debouches" 
                                      name="debouches" 
                                      rows="2"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                        </div>

                        {{-- Places disponibles --}}
                        <div>
                            <label for="places_disponibles" class="block text-sm font-medium text-gray-700 mb-1">
                                Places disponibles
                            </label>
                            <input type="number" 
                                   id="places_disponibles" 
                                   name="places_disponibles" 
                                   value="50"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>

                        {{-- Date limite --}}
                        <div>
                            <label for="date_limite_inscription" class="block text-sm font-medium text-gray-700 mb-1">
                                Date limite d'inscription
                            </label>
                            <input type="date" 
                                   id="date_limite_inscription" 
                                   name="date_limite_inscription" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>

                        {{-- Statut actif --}}
                        <div class="md:col-span-2 flex items-center">
                            <input type="checkbox" 
                                   id="est_active" 
                                   name="est_active" 
                                   value="1" 
                                   checked
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="est_active" class="ml-2 block text-sm text-gray-700">
                                Formation active (visible pour les étudiants)
                            </label>
                        </div>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('formations.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour aux formations
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Créer la formation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Aide --}}
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-blue-700">
                        <strong>Astuce :</strong> Tous les champs marqués d'un astérisque (*) sont obligatoires.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection