@extends('layouts.app')

@section('title', 'UniLomé - Trouvez votre université idéale à Lomé')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-8">
                <i class="fas fa-graduation-cap text-3xl text-white"></i>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Trouvez votre 
                <span class="text-yellow-300">université idéale</span> 
                à Lomé
            </h1>
            
            <p class="text-xl md:text-2xl text-blue-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                La première plateforme d'orientation intelligente qui connecte 
                <span class="font-semibold">les étudiants aux meilleures formations</span> 
                de la capitale.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/universites" 
                   class="group inline-flex items-center justify-center px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition duration-300 text-lg shadow-lg">
                    <i class="fas fa-search mr-3 group-hover:scale-110 transition duration-300"></i>
                    Explorer les universités
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition duration-300"></i>
                </a>
                
                <a href="/test-orientation" 
                   class="group inline-flex items-center justify-center px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-xl hover:bg-yellow-300 transition duration-300 text-lg shadow-lg">
                    <i class="fas fa-brain mr-3"></i>
                    Faire le test d'orientation
                </a>
            </div>
        </div>
    </div>
    
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-current text-white w-full h-16">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="fill-current"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="fill-current"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="fill-current"></path>
        </svg>
    </div>
</section>

<!-- Statistiques en temps réel -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                UniLomé en chiffres
            </h2>
            <p class="text-gray-600 text-lg">
                La plateforme qui transforme l'orientation universitaire au Togo
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Université -->
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-2xl mb-4 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-university text-3xl text-blue-600"></i>
                </div>
                <div class="text-4xl font-bold text-blue-600 mb-2" id="count-universites">
                    {{ \App\Models\Universite::count() }}
                </div>
                <div class="text-gray-700 font-medium">Universités</div>
                <div class="text-gray-500 text-sm mt-1">à Lomé</div>
            </div>
            
            <!-- Étudiants -->
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-2xl mb-4 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-user-graduate text-3xl text-green-600"></i>
                </div>
                <div class="text-4xl font-bold text-green-600 mb-2" id="count-etudiants">
                    {{ \App\Models\User::where('role', 'etudiant')->count() }}
                </div>
                <div class="text-gray-700 font-medium">Étudiants</div>
                <div class="text-gray-500 text-sm mt-1">inscrits</div>
            </div>
            
            <!-- Tests -->
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 rounded-2xl mb-4 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-clipboard-check text-3xl text-purple-600"></i>
                </div>
                <div class="text-4xl font-bold text-purple-600 mb-2" id="count-tests">
                    {{ \App\Models\ResultatTest::count() }}
                </div>
                <div class="text-gray-700 font-medium">Tests</div>
                <div class="text-gray-500 text-sm mt-1">d'orientation passés</div>
            </div>
            
            <!-- Favoris -->
            <div class="text-center group">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-2xl mb-4 group-hover:scale-110 transition duration-300">
                    <i class="fas fa-heart text-3xl text-yellow-600"></i>
                </div>
                <div class="text-4xl font-bold text-yellow-600 mb-2" id="count-favoris">
                    {{ \App\Models\Favori::count() }}
                </div>
                <div class="text-gray-700 font-medium">Favoris</div>
                <div class="text-gray-500 text-sm mt-1">enregistrés</div>
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Tout pour réussir votre orientation
            </h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                Des outils intelligents conçus pour vous guider vers la formation parfaite
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Test d'orientation -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-brain text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Test d'orientation IA</h3>
                <p class="text-gray-600 mb-6">
                    Un questionnaire intelligent qui analyse vos intérêts, compétences et personnalité pour suggérer les formations idéales.
                </p>
                <a href="/test-orientation" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700">
                    Essayer maintenant
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Recherche avancée -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-search text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Recherche intelligente</h3>
                <p class="text-gray-600 mb-6">
                    Filtrez les universités par domaine, localisation, frais de scolarité et taux de réussite. Trouvez l'établissement parfait.
                </p>
                <a href="/universites" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700">
                    Explorer les universités
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Favoris -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-r from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-heart text-2xl text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Liste de favoris</h3>
                <p class="text-gray-600 mb-6">
                    Sauvegardez vos universités préférées, comparez-les et recevez des notifications sur leurs actualités.
                </p>
                <a href="/mes-favoris" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700">
                    Voir mes favoris
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Universités populaires -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Universités populaires
                </h2>
                <p class="text-gray-600">
                    Les établissements les plus consultés par nos étudiants
                </p>
            </div>
            <a href="/universites" class="text-blue-600 hover:text-blue-700 font-semibold">
                Voir toutes
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @php
                // Récupérer 3 universités (ou toutes si moins de 3)
                $universites = \App\Models\Universite::limit(3)->get();
            @endphp
            
            @foreach($universites as $universite)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-university text-2xl text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $universite->nom }}</h3>
                            <div class="flex items-center text-gray-500 text-sm mt-1">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $universite->ville }}, {{ $universite->pays }}
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-6 line-clamp-3">
                        {{ $universite->description ?? 'Établissement universitaire de renom offrant des formations de qualité.' }}
                    </p>
                    
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            @if($universite->nombre_etudiants)
                            <div class="text-lg font-bold text-blue-600">{{ number_format($universite->nombre_etudiants) }}+</div>
                            <div class="text-gray-500 text-sm">Étudiants</div>
                            @endif
                        </div>
                        <div>
                            @if($universite->taux_reussite)
                            <div class="text-lg font-bold text-green-600">{{ $universite->taux_reussite }}%</div>
                            <div class="text-gray-500 text-sm">Réussite</div>
                            @endif
                        </div>
                        <div>
                            <div class="text-lg font-bold text-purple-600">{{ $universite->favoris_count ?? 0 }}</div>                            <div class="text-gray-500 text-sm">Favoris</div>
                        </div>
                    </div>
                    
                    <a href="/universites/{{ $universite->id }}" 
                       class="block w-full text-center bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition duration-300">
                        Voir les formations
                    </a>
                </div>
            </div>
            @endforeach
            
            <!-- Carte "Découvrir plus" -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-dashed border-blue-300 p-8 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-plus text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    Découvrir plus d'universités
                </h3>
                <p class="text-gray-600 mb-6">
                    Explorez notre base complète d'universités et trouvez celle qui vous correspond
                </p>
                <a href="/universites" 
                   class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition duration-300">
                    Parcourir toutes les universités
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Témoignages -->
<section class="py-20 bg-gradient-to-r from-gray-900 to-blue-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Ce que disent nos étudiants
            </h2>
            <p class="text-blue-200 text-lg max-w-3xl mx-auto">
                Découvrez comment UniLomé a transformé leur parcours d'orientation
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Témoignage 1 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-blue-400 rounded-full flex items-center justify-center text-xl font-bold">
                        BE
                    </div>
                    <div class="ml-4">
                        <div class="font-bold">Bernadette Evi</div>
                        <div class="text-blue-200 text-sm">Étudiante en Médecine</div>
                    </div>
                </div>
                <p class="italic text-blue-100 mb-6">
                    "Grâce au test d'orientation d'UniLomé, j'ai découvert ma passion pour la médecine. La plateforme m'a guidée vers l'université parfaite pour moi."
                </p>
                <div class="text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            
            <!-- Témoignage 2 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-green-400 rounded-full flex items-center justify-center text-xl font-bold">
                        LA
                    </div>
                    <div class="ml-4">
                        <div class="font-bold">Louis Amedoume</div>
                        <div class="text-blue-200 text-sm">Étudiant en Informatique</div>
                    </div>
                </div>
                <p class="italic text-blue-100 mb-6">
                    "Les filtres de recherche m'ont permis de trouver une formation en informatique adaptée à mon budget. J'ai économisé des mois de recherches !"
                </p>
                <div class="text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
            
            <!-- Témoignage 3 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-purple-400 rounded-full flex items-center justify-center text-xl font-bold">
                        LW
                    </div>
                    <div class="ml-4">
                        <div class="font-bold">Léonce Woenekou</div>
                        <div class="text-blue-200 text-sm">Étudiante en Droit</div>
                    </div>
                </div>
                <p class="italic text-blue-100 mb-6">
                    "La fonction 'favoris' m'a permis de comparer plusieurs universités. J'ai pu prendre ma décision en toute connaissance de cause."
                </p>
                <div class="text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-5xl font-bold mb-6">
            Prêt à trouver votre voie ?
        </h2>
        <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
            Rejoignez des milliers d'étudiants qui ont transformé leur orientation grâce à UniLomé.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('register') }}" 
               class="group inline-flex items-center justify-center px-10 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition duration-300 text-lg shadow-2xl">
                <i class="fas fa-user-plus mr-3 text-xl"></i>
                Créer mon compte gratuit
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition duration-300"></i>
            </a>
            
            <a href="/test-orientation" 
               class="group inline-flex items-center justify-center px-10 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition duration-300 text-lg">
                <i class="fas fa-play-circle mr-3"></i>
                Essayer le test d'orientation
            </a>
        </div>
        
        <p class="mt-8 text-blue-200">
            Aucune carte bancaire requise • 100% gratuit • Complet en 2 minutes
        </p>
    </div>
</section>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animation des compteurs */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-count {
    animation: countUp 0.8s ease-out forwards;
}
</style>

<script>
// Animation des compteurs
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[id^="count-"]');
    
    counters.forEach(counter => {
        const finalValue = parseInt(counter.textContent);
        let currentValue = 0;
        const duration = 2000; // 2 secondes
        const increment = finalValue / (duration / 16); // 60fps
        
        const updateCounter = () => {
            currentValue += increment;
            if (currentValue < finalValue) {
                counter.textContent = Math.floor(currentValue);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = finalValue;
                counter.classList.add('animate-count');
            }
        };
        
        // Démarrer l'animation quand l'élément est visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });
    
    // Animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observer les cartes
    document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection