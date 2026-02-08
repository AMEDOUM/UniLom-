@extends('layouts.app')

@section('title', 'Résultats du test - UniLomé')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec succès -->
        <div class="text-center mb-12">
            <div class="w-24 h-24 bg-gradient-to-r from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-trophy text-4xl text-green-600"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Test complété avec succès !
            </h1>
            <p class="text-xl text-gray-600">
                Voici vos résultats personnalisés
            </p>
            <div class="mt-4 text-gray-500">
                <i class="far fa-calendar mr-2"></i>
                {{ $resultat->date_completion->format('d/m/Y à H:i') }}
            </div>
        </div>
        
        <!-- Scores par domaine -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                 Vos scores par domaine
            </h2>
            
            <div class="space-y-6">
                @php
                    $scores = (array) $resultat->scores;
                    arsort($scores);
                    $topScore = max($scores);
                @endphp
                
                @foreach($scores as $domaine => $score)
                @php
                    $pourcentage = $topScore > 0 ? ($score / $topScore * 100) : 0;
                    $couleurs = [
                        'sciences' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'bar' => 'bg-blue-600'],
                        'medecine' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'bar' => 'bg-red-600'],
                        'droit' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'bar' => 'bg-purple-600'],
                        'lettres' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'bar' => 'bg-yellow-600'],
                        'commerce' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'bar' => 'bg-green-600'],
                        'ingenierie' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'bar' => 'bg-indigo-600'],
                    ];
                    $couleur = $couleurs[$domaine] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'bar' => 'bg-gray-600'];
                @endphp
                
                <div>
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center">
                            <span class="font-bold capitalize mr-3">{{ $domaine }}</span>
                            <span class="{{ $couleur['bg'] }} {{ $couleur['text'] }} px-3 py-1 rounded-full text-sm font-medium">
                                {{ $score }} points
                            </span>
                        </div>
                        <span class="font-bold">{{ round($pourcentage) }}%</span>
                    </div>
                    
                    <div class="h-4 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full {{ $couleur['bar'] }} rounded-full transition-all duration-1000" 
                             style="width: {{ $pourcentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Top 3 recommandations -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg p-8 mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                Top 3 des domaines pour vous
            </h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                @php
                    $top3 = array_slice($scores, 0, 3, true);
                    $icons = [
                        'sciences' => 'fas fa-flask',
                        'medecine' => 'fas fa-stethoscope',
                        'droit' => 'fas fa-gavel',
                        'lettres' => 'fas fa-book',
                        'commerce' => 'fas fa-chart-line',
                        'ingenierie' => 'fas fa-cogs',
                    ];
                    $descriptions = [
                        'sciences' => 'Biologie, chimie, physique, mathématiques',
                        'medecine' => 'Médecine, pharmacie, kinésithérapie, soins',
                        'droit' => 'Droit civil, pénal, des affaires, international',
                        'lettres' => 'Littérature, langues, philosophie, histoire',
                        'commerce' => 'Gestion, marketing, finance, entrepreneuriat',
                        'ingenierie' => 'Informatique, génie civil, électrique, mécanique',
                    ];
                @endphp
                
                @foreach($top3 as $domaine => $score)
                @php
                    $position = $loop->iteration;
                    $medailles = ['🥇', '🥈', '🥉'];
                @endphp
                
                <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">{{ $medailles[$loop->index] ?? '🎯' }}</div>
                    <div class="text-4xl mb-4">
                        <i class="{{ $icons[$domaine] ?? 'fas fa-star' }} text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold capitalize mb-3">{{ $domaine }}</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        {{ $descriptions[$domaine] ?? 'Domaine académique' }}
                    </p>
                    <div class="text-2xl font-bold text-blue-600">{{ $score }} pts</div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Actions -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Explorer les formations -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold mb-4">
                    <i class="fas fa-search mr-2 text-blue-600"></i>
                    Explorer les formations
                </h3>
                <p class="text-gray-600 mb-6">
                    Découvrez les formations universitaires correspondant à votre profil.
                </p>
                <a href="/universites" 
                   class="inline-block w-full text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                    Voir les universités →
                </a>
            </div>
            
            <!-- Repasser le test -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold mb-4">
                    <i class="fas fa-redo mr-2 text-green-600"></i>
                    Améliorer vos résultats
                </h3>
                <p class="text-gray-600 mb-6">
                    Repassez le test pour affiner vos recommandations.
                </p>
                <a href="/test-orientation" 
                   class="inline-block w-full text-center border-2 border-green-600 text-green-600 py-3 rounded-lg hover:bg-green-50">
                    Repasser le test
                </a>
            </div>
        </div>
        
        <!-- Partage -->
        <div class="mt-10 text-center">
            <p class="text-gray-600 mb-4">Partagez vos résultats :</p>
            <div class="flex justify-center space-x-4">
                <button class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                    <i class="fab fa-facebook-f"></i>
                </button>
                <button class="w-12 h-12 bg-green-100 text-green-600 rounded-full hover:bg-green-200">
                    <i class="fab fa-whatsapp"></i>
                </button>
                <button class="w-12 h-12 bg-blue-300 text-white rounded-full hover:bg-blue-400">
                    <i class="fab fa-twitter"></i>
                </button>
                <button class="w-12 h-12 bg-gray-800 text-white rounded-full hover:bg-gray-900">
                    <i class="fab fa-github"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Animation des barres de progression
document.addEventListener('DOMContentLoaded', function() {
    const bars = document.querySelectorAll('.rounded-full > div');
    bars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });
});
</script>
@endsection