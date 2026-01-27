@extends('layouts.app')

@section('title', 'Tableau de bord - Université')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">
                    Bienvenue {{ auth()->user()->nom_universite }}
                </h1>
                
                <!-- Notification validation -->
                @if(auth()->user()->est_valide)
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">
                                ✅ Votre compte a été validé ! Vous pouvez maintenant publier des formations.
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-yellow-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-medium">
                                ⏳ Votre compte est en attente de validation par l'administrateur.
                                Vous pourrez publier des formations une fois validé.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Cartes d'action -->
                <div class="grid md:grid-cols-3 gap-6 mb-10">
                    <a href="/universite/formations" class="bg-purple-50 p-6 rounded-xl hover:bg-purple-100 transition duration-200">
                        <div class="text-purple-600 text-2xl mb-3">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Gérer les formations</h3>
                        <p class="text-gray-600 text-sm">Ajoutez vos programmes</p>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="bg-indigo-50 p-6 rounded-xl hover:bg-indigo-100 transition duration-200">
                        <div class="text-indigo-600 text-2xl mb-3">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Profil université</h3>
                        <p class="text-gray-600 text-sm">Modifiez vos informations</p>
                    </a>
                    
                    <a href="/universite/statistiques" class="bg-teal-50 p-6 rounded-xl hover:bg-teal-100 transition duration-200">
                        <div class="text-teal-600 text-2xl mb-3">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Statistiques</h3>
                        <p class="text-gray-600 text-sm">Consultez votre visibilité</p>
                    </a>
                </div>
                
                <!-- Informations université -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h2 class="text-xl font-bold mb-4"><i class="fas fa-info-circle text-blue-600 mr-2"></i>Informations de votre université</h2>
                    <div class="space-y-3">
                        <p><strong>Localisation :</strong> {{ auth()->user()->localisation ?? 'Non renseignée' }}</p>
                        <p><strong>Téléphone :</strong> {{ auth()->user()->telephone ?? 'Non renseigné' }}</p>
                        <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Statut :</strong> 
                            @if(auth()->user()->est_valide)
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                    <i class="fas fa-check-circle"></i>
                                    Validée
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                                    <i class="fas fa-hourglass-half"></i>
                                    En attente
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection