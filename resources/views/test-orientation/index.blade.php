@extends('layouts.app')

@section('title', 'Test d\'orientation - UniLomé')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Test d'orientation universitaire
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Découvrez les formations qui correspondent le mieux à votre profil
            </p>
            
            @if($dejaPasse)
            <div class="inline-block bg-blue-50 border border-blue-200 rounded-xl px-6 py-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-blue-800">Vous avez déjà passé ce test</p>
                        <p class="text-blue-600 text-sm">Un étudiant ne peut passer ce test qu'une seule fois. <a href="{{ route('test-orientation.resultat', \Auth::user()->resultatsTests()->where('test_id', $test->id)->first()) }}" class="underline font-semibold">Voir vos résultats</a></p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Informations du test -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-10">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $test->nombre_questions }}</div>
                    <div class="text-gray-600">Questions</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $test->duree_minutes }} min</div>
                    <div class="text-gray-600">Durée estimée</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">100%</div>
                    <div class="text-gray-600">Personnalisé</div>
                </div>
            </div>
            
            <div class="prose max-w-none mb-8">
                <p class="text-gray-700">{{ $test->description }}</p>
            </div>
            
            <!-- Bouton commencer -->
            <div class="text-center">
                @auth
                    @if($dejaPasse)
                        <button disabled 
                                class="inline-flex items-center justify-center px-8 py-4 bg-gray-400 text-white font-bold rounded-xl cursor-not-allowed text-lg">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            Test déjà complété
                        </button>
                        <p class="text-gray-600 text-sm mt-4">
                            <i class="fas fa-lock mr-2"></i>
                            Un étudiant ne peut passer ce test qu'une fois.
                        </p>
                    @else
                        <a href="{{ route('test-orientation.show', $test) }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition duration-300 text-lg">
                            <i class="fas fa-play-circle mr-3 text-xl"></i>
                            Commencer le test
                        </a>
                    @endif
                @else
                    <div class="space-y-4">
                        <a href="{{ route('test-orientation.show', $test) }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition duration-300 text-lg">
                            <i class="fas fa-play-circle mr-3 text-xl"></i>
                            Essayer le test (sans compte)
                        </a>
                        <p class="text-gray-500 text-sm">
                            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Créez un compte</a> 
                            pour sauvegarder vos résultats
                        </p>
                    </div>
                @endauth
            </div>
        </div>
        
        <!-- Avantages -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-blue-50 p-6 rounded-xl">
                <div class="text-blue-600 text-2xl mb-3">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Analyse intelligente</h3>
                <p class="text-gray-600">Algorithme basé sur vos intérêts, compétences et personnalité</p>
            </div>
            
            <div class="bg-green-50 p-6 rounded-xl">
                <div class="text-green-600 text-2xl mb-3">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Recommandations précises</h3>
                <p class="text-gray-600">Suggestions de formations adaptées à votre profil</p>
            </div>
        </div>
    </div>
</div>
@endsection