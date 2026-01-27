@extends('layouts.app')

@section('title', 'Tableau de bord - Étudiant')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">
                    Bonjour {{ auth()->user()->nom }} !
                </h1>
                
                <!-- Cartes d'action rapide -->
                <div class="grid md:grid-cols-3 gap-6 mb-10">
                    <a href="/universites" class="bg-blue-50 p-6 rounded-xl hover:bg-blue-100 transition duration-200">
                        <div class="text-blue-600 text-2xl mb-3">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Rechercher des universités</h3>
                        <p class="text-gray-600 text-sm">Explorez les universités de Lomé</p>
                    </a>
                    
                    <a href="/test-orientation" class="bg-green-50 p-6 rounded-xl hover:bg-green-100 transition duration-200">
                        <div class="text-green-600 text-2xl mb-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Test d'orientation</h3>
                        <p class="text-gray-600 text-sm">Découvrez votre voie idéale</p>
                    </a>
                    
                    <a href="http://127.0.0.1:8000/mes-favoris" class="bg-yellow-50 p-6 rounded-xl hover:bg-yellow-100 transition duration-200">
                        <div class="text-yellow-600 text-2xl mb-3">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Mes favoris</h3>
                        <p class="text-gray-600 text-sm">Retrouvez vos préférences</p>
                    </a>
                </div>
                
                <!-- Section profil -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h2 class="text-xl font-bold mb-4">Mon profil</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600"><strong>Email :</strong> {{ auth()->user()->email }}</p>
                            <p class="text-gray-600"><strong>Date de naissance :</strong> {{ auth()->user()->date_naissance ?? 'Non renseignée' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600"><strong>Statut :</strong> Étudiant</p>
                            <p class="text-gray-600"><strong>Compte créé le :</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Modifier mon profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection