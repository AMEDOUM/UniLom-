@extends('layouts.app')

@section('title', $universite->nom . ' - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Bouton retour -->
        <div class="mb-6">
            <a href="{{ route('universites') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
        
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-md p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-20 h-20 bg-blue-100 rounded-lg flex items-center justify-center mr-6">
                        <i class="fas fa-university text-blue-600 text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $universite->nom }}</h1>
                        @if($universite->sigle)
                            <p class="text-gray-500 font-medium">{{ $universite->sigle }}</p>
                        @endif
                        <div class="flex items-center mt-2 gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ $universite->est_public ? 'Public' : 'Privé' }}
                            </span>
                            <span class="text-gray-600">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $universite->ville }}, {{ $universite->pays }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3">
                    @auth
                        @if(auth()->user()->role === 'etudiant')
                        <form action="{{ route('favoris.toggle', $universite) }}" method="POST">
                            @csrf
                            @php
                                $estFavori = auth()->user()->aFavori($universite->id);
                            @endphp
                            <button type="submit" 
                                    class="flex items-center px-4 py-2 {{ $estFavori ? 'bg-red-100 text-red-600 border-red-300' : 'bg-white text-blue-600 border-blue-600' }} border rounded-lg hover:shadow-md transition">
                                <i class="{{ $estFavori ? 'fas' : 'far' }} fa-heart mr-2"></i>
                                {{ $estFavori ? 'Favori' : 'Ajouter aux favoris' }}
                            </button>
                        </form>
                        @endif
                    @endauth
                    
                    <a href="mailto:{{ $universite->email }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-envelope mr-2"></i>Contacter
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu en deux colonnes -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Colonne gauche (2/3) -->
            <div class="md:col-span-2 space-y-8">
                <!-- Description -->
                @if($universite->description)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-align-left text-blue-600 mr-2"></i>
                        Description
                    </h2>
                    <p class="text-gray-700 leading-relaxed">{{ $universite->description }}</p>
                </div>
                @endif
                
                <!-- Vision -->
                @if($universite->vision)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-eye text-purple-600 mr-2"></i>
                        Notre Vision
                    </h2>
                    <p class="text-gray-700 leading-relaxed">{{ $universite->vision }}</p>
                </div>
                @endif
                
                <!-- Formations -->
                @if($universite->formations && $universite->formations->count() > 0)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-book text-green-600 mr-2"></i>
                        Formations proposées ({{ $universite->formations->count() }})
                    </h2>
                    <div class="space-y-4">
                        @foreach($universite->formations as $formation)
                        <div class="border-l-4 border-blue-500 pl-4 py-3 hover:bg-gray-50 rounded transition">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-lg text-gray-900">{{ $formation->nom }}</h3>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded font-semibold">
                                    {{ $formation->niveau }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-2">{{ $formation->domaine }}</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="far fa-clock mr-1"></i>{{ $formation->duree_mois }} mois</span>
                                <span><i class="fas fa-users mr-1"></i>{{ $formation->places_disponibles }} places</span>
                                @if($formation->frais_inscription)
                                <span><i class="fas fa-money-bill mr-1"></i>{{ number_format($formation->frais_inscription, 0, ',', ' ') }} FCFA</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <p class="text-gray-600">Aucune formation disponible pour le moment</p>
                </div>
                @endif

                <!-- Section Avis et Notes -->
                <div class="bg-white rounded-xl shadow-md p-6 mt-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Avis et Notes
                    </h2>

                    <!-- Moyenne globale -->
                    @php
                        $moyenne = $universite->avis()->avg('note');
                        $totalAvis = $universite->avis()->count();
                    @endphp
                    
                    <div class="flex items-center mb-8 bg-gray-50 p-4 rounded-lg">
                        <div class="mr-6 text-center">
                            <span class="text-4xl font-bold text-gray-900">{{ number_format($moyenne, 1) }}</span>
                            <span class="text-gray-500 text-sm">/ 5</span>
                            <div class="text-yellow-400 text-sm my-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= round($moyenne) ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500">{{ $totalAvis }} avis</p>
                        </div>
                        <div class="flex-1 border-l pl-6">
                            <p class="text-gray-600 italic">
                                "Les avis partagés par la communauté étudiante."
                            </p>
                        </div>
                    </div>

                    <!-- Liste des avis -->
                    <div class="space-y-6 mb-8">
                        @forelse($universite->avis()->latest()->get() as $avis)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs mr-3">
                                        {{ substr($avis->user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $avis->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $avis->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-yellow-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $avis->note ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($avis->commentaire)
                                <p class="text-gray-600 text-sm ml-11 bg-gray-50 p-3 rounded-lg">{{ $avis->commentaire }}</p>
                            @endif
                            
                            @if(auth()->check() && (auth()->id() === $avis->user_id || auth()->user()->role === 'admin'))
                                <div class="mt-2 ml-11">
                                    <form action="{{ route('avis.destroy', $avis) }}" method="POST" onsubmit="return confirm('Supprimer cet avis ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-xs hover:underline">Supprimer</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">Aucun avis pour le moment. Soyez le premier !</p>
                        @endforelse
                    </div>

                    <!-- Formulaire d'ajout d'avis (Étudiants seulement) -->
                    @auth
                        @if(auth()->user()->role === 'etudiant')
                            @if(!$universite->avis()->where('user_id', auth()->id())->exists())
                                <div class="bg-blue-50 p-5 rounded-lg border border-blue-100">
                                    <h3 class="font-bold text-gray-900 mb-3">Laisser un avis</h3>
                                    <form action="{{ route('avis.store', $universite) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Note globale</label>
                                            <div class="flex gap-4">
                                                @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="note" value="{{ $i }}" class="hidden peer" required>
                                                    <i class="far fa-star text-2xl text-gray-400 peer-checked:text-yellow-400 hover:text-yellow-400 peer-checked:fas transition"></i>
                                                </label>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">Votre commentaire (optionnel)</label>
                                            <textarea name="commentaire" id="commentaire" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Partagez votre expérience..."></textarea>
                                        </div>
                                        
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full font-semibold">
                                            Publier mon avis
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="bg-green-50 p-4 rounded-lg text-center text-green-700">
                                    <i class="fas fa-check-circle mr-2"></i> Vous avez déjà donné votre avis sur cette université.
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="text-center bg-gray-50 p-4 rounded-lg">
                            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Connectez-vous</a> pour laisser un avis.
                        </div>
                    @endauth
                </div>
            </div>
            
            <!-- Colonne droite (1/3) -->
            <div class="space-y-6">
                <!-- Infos rapides -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Informations
                    </h3>
                    <div class="space-y-3">
                        @if($universite->nombre_etudiants)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Étudiants</span>
                            <span class="font-bold">{{ number_format($universite->nombre_etudiants) }}</span>
                        </div>
                        @endif
                        
                        @if($universite->taux_reussite)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Taux de réussite</span>
                            <span class="font-bold text-green-600">{{ $universite->taux_reussite }}%</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type</span>
                            <span class="font-bold">{{ $universite->est_public ? 'Public' : 'Privé' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Localisation</span>
                            <span class="font-bold">{{ $universite->ville }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Contact -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-phone text-blue-600 mr-2"></i>
                        Contact
                    </h3>
                    <div class="space-y-3">
                        @if($universite->site_web)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-globe text-gray-400 mt-1"></i>
                            <div class="min-w-0 break-words">
                                <p class="text-xs text-gray-500">Site web</p>
                                <a href="{{ $universite->site_web }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ str_replace(['http://', 'https://'], '', $universite->site_web) }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($universite->email)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-envelope text-gray-400 mt-1"></i>
                            <div class="min-w-0 break-words">
                                <p class="text-xs text-gray-500">Email</p>
                                <a href="mailto:{{ $universite->email }}" class="text-blue-600 hover:text-blue-800 font-medium break-all">
                                    {{ $universite->email }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($universite->telephone)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-phone-alt text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-xs text-gray-500">Téléphone</p>
                                <a href="tel:{{ $universite->telephone }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $universite->telephone }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($universite->adresse)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-xs text-gray-500">Adresse</p>
                                <p class="text-gray-700 font-medium">{{ $universite->adresse }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Réseaux sociaux -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Suivez-nous</h3>
                    <div class="flex gap-3">
                        @if($universite->facebook)
                        <a href="{{ $universite->facebook }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        
                        @if($universite->twitter)
                        <a href="{{ $universite->twitter }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-blue-400 text-white rounded-full hover:bg-blue-500 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        
                        @if($universite->linkedin)
                        <a href="{{ $universite->linkedin }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-blue-700 text-white rounded-full hover:bg-blue-800 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection