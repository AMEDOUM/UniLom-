@extends('layouts.app')

@section('title', 'Statistiques - Université')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('dashboard.universite') }}" class="text-blue-600 hover:text-blue-800 transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">
                    <i class="fas fa-chart-bar text-teal-600 mr-3"></i>Statistiques de visibilité
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Carte Visites -->
                    <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-8 rounded-2xl shadow-sm border border-teal-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-teal-800">Vues du profil</h2>
                            <div class="p-3 bg-white rounded-full shadow-sm text-teal-600">
                                <i class="fas fa-eye text-2xl"></i>
                            </div>
                        </div>
                        <div class="text-5xl font-bold text-gray-800 mb-2">
                            {{ number_format($universite->visites, 0, ',', ' ') }}
                        </div>
                        <p class="text-teal-700">
                            Nombre total de fois que votre page université a été consultée par des étudiants.
                        </p>
                    </div>

                    <!-- Carte Formations (Info complémentaire) -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-700">Vos formations</h2>
                            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                                <i class="fas fa-graduation-cap text-2xl"></i>
                            </div>
                        </div>
                        <div class="text-4xl font-bold text-gray-800 mb-2">
                            {{ $universite->formations()->count() }}
                        </div>
                        <p class="text-gray-500">
                            Formations publiées sur la plateforme.
                        </p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('formations.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Gérer mes formations <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12 bg-gray-50 rounded-xl p-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-800">Comprendre ces chiffres</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <span>Le compteur de vues s'incrémente chaque fois qu'un visiteur accède à votre page de détails.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-yellow-500 mt-1 mr-3"></i>
                            <span>Une visibilité élevée augmente vos chances de recevoir des candidatures.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-rocket text-red-500 mt-1 mr-3"></i>
                            <span>Pour augmenter votre visibilité, assurez-vous que votre description est complète et publiez régulièrement des actualités.</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
