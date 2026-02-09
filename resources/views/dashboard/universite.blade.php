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
                                Votre compte a été validé ! Vous pouvez maintenant publier des formations.
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
                                Votre compte est en attente de validation par l'administrateur.
                                Vous pourrez publier des formations une fois validé.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Cartes d'action -->
                <div class="grid md:grid-cols-4 gap-6 mb-10">
                    <a href="/universite/formations" class="bg-purple-50 p-6 rounded-xl hover:bg-purple-100 transition duration-200">
                        <div class="text-purple-600 text-2xl mb-3">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Gérer les formations</h3>
                        <p class="text-gray-600 text-sm">Ajoutez vos programmes</p>
                    </a>
                    
                    <a href="{{ route('actualites.create') }}" class="bg-orange-50 p-6 rounded-xl hover:bg-orange-100 transition duration-200">
                        <div class="text-orange-600 text-2xl mb-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Actualités</h3>
                        <p class="text-gray-600 text-sm">Publiez les dernières infos</p>
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
                <div class="bg-gray-50 p-6 rounded-xl mb-8">
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

                <!-- Actualités récentes -->
                @php
                    $universite = \App\Models\Universite::where('user_id', auth()->id())->first();
                    $actualites = $universite ? $universite->actualites()->latest('date_publication')->limit(5)->get() : collect();
                @endphp
                
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold"><i class="fas fa-newspaper text-orange-600 mr-2"></i>Vos actualités</h2>
                        <a href="{{ route('actualites.create') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm">
                            <i class="fas fa-plus mr-1"></i> Nouvelle
                        </a>
                    </div>

                    @if($actualites->count() > 0)
                        <div class="space-y-4">
                            @foreach($actualites as $actualite)
                                <div class="flex items-start justify-between border rounded-lg p-4 hover:bg-gray-50 transition">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">
                                            <a href="{{ route('actualites.show', $actualite) }}" class="hover:text-orange-600 transition">
                                                {{ $actualite->titre }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ Str::limit($actualite->description ?? $actualite->contenu, 100) }}
                                        </p>
                                        <div class="flex gap-4 mt-2 text-xs text-gray-500">
                                            <span><i class="fas fa-calendar mr-1"></i>{{ $actualite->date_publication->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <a href="{{ route('actualites.edit', $actualite) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition text-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('actualites.destroy', $actualite) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 transition text-sm" onclick="return confirm('Êtes-vous sûr?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-4">Vous n'avez pas encore publié d'actualités.</p>
                            <a href="{{ route('actualites.create') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                                Publiez votre première actualité <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection