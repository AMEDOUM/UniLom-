@extends('layouts.app')

@section('title', 'Détails Université - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Bouton retour -->
        <div class="mb-6">
            <a href="/universites" class="text-blue-600 hover:text-blue-800">
                ← Retour à la liste
            </a>
        </div>
        
        <!-- En-tête -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-20 h-20 bg-blue-100 rounded-lg flex items-center justify-center mr-6">
                        <i class="fas fa-university text-blue-600 text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Université de Lomé</h1>
                        <div class="flex items-center mt-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                Public
                            </span>
                            <span class="mx-3 text-gray-400">•</span>
                            <span class="text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2"></i>Lomé Centre, Togo
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
<div class="flex space-x-3">
    @auth
        @if(auth()->user()->role === 'etudiant')
        <form action="{{ route('favoris.toggle', $universite->id) }}" method="POST">
            @csrf
            @php
                $estFavori = auth()->user()->aFavori($universite->id);
            @endphp
            <button type="submit" 
                    class="flex items-center px-4 py-2 {{ $estFavori ? 'bg-red-50 border-red-300 text-red-600' : 'border-blue-600 text-blue-600' }} border rounded-lg hover:bg-blue-50 transition duration-200">
                <i class="{{ $estFavori ? 'fas' : 'far' }} fa-heart mr-2"></i>
                {{ $estFavori ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
            </button>
        </form>
        @endif
    @endauth
    
    <button class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
        <i class="fas fa-share-alt mr-2"></i>Partager
    </button>
</div>
        
        <!-- Contenu en deux colonnes -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Colonne gauche (2/3) -->
            <div class="md:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed">
                        L'Université de Lomé est la principale université publique du Togo. 
                        Fondée en 1970, elle offre une large gamme de formations dans divers 
                        domaines académiques et professionnels.
                    </p>
                </div>
                
                <!-- Formations -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">🎓 Formations proposées</h2>
                    <div class="space-y-4">
                        <!-- Formation 1 -->
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <h3 class="font-bold text-lg">Licence en Informatique</h3>
                            <p class="text-gray-600 text-sm mb-2">Faculté des Sciences</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-4"><i class="far fa-clock mr-1"></i>3 ans</span>
                                <span><i class="fas fa-graduation-cap mr-1"></i>Bac+3</span>
                            </div>
                        </div>
                        <!-- Ajouter d'autres formations -->
                    </div>
                </div>
                
                <!-- Avis -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Avis des étudiants</h2>
                    <!-- Avis 1 -->
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <div class="font-medium">Jean K.</div>
                            <div class="text-yellow-400">
                                ★★★★★
                            </div>
                        </div>
                        <p class="text-gray-600">"Excellente université avec des professeurs compétents."</p>
                    </div>
                </div>
            </div>
            
            <!-- Colonne droite (1/3) -->
            <div class="space-y-6">
                <!-- Infos rapides -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4">Informations</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Étudiants</span>
                            <span class="font-bold">15,000+</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Taux de réussite</span>
                            <span class="font-bold text-green-600">85%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Frais annuels</span>
                            <span class="font-bold">27,000 FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fondation</span>
                            <span class="font-bold">1970</span>
                        </div>
                    </div>
                </div>
                
                <!-- Contact -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4">Contact</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-globe text-gray-400 mr-3"></i>
                            <span>www.ul.tg</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                            <span>contact@ul.tg</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-3"></i>
                            <span>+228 22 21 20 19</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-3"></i>
                            <span>Boulevard du 13 Janvier, Lomé</span>
                        </div>
                    </div>
                </div>
                
                <!-- CTA -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-bold text-lg mb-3">Intéressé par cette université ?</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Contactez directement l'université ou ajoutez-la à vos favoris.
                    </p>
                    <div class="space-y-3">
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                            Contacter l'université
                        </button>
                        <button class="w-full border border-blue-600 text-blue-600 py-3 rounded-lg hover:bg-blue-50">
                            Ajouter aux favoris
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection