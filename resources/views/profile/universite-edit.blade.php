@extends('layouts.app')

@section('title', 'Modifier mon profil - Université')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                <h1 class="text-3xl font-bold">Gérer mon profil université</h1>
                <p class="text-indigo-100 mt-2">Mettez à jour les informations de votre établissement</p>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Informations Université -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-indigo-500">
                            <i class="fas fa-university mr-2 text-indigo-600"></i>
                            Informations de votre université
                        </h2>

                        <!-- Nom Université -->
                        <div class="mb-6">
                            <label for="nom_universite" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom de l'université *
                            </label>
                            <input type="text" id="nom_universite" name="nom_universite" 
                                value="{{ auth()->user()->nom_universite }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Ex: Université de Lomé">
                            @error('nom_universite')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email institutionnel *
                            </label>
                            <input type="email" id="email" name="email" 
                                value="{{ auth()->user()->email }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="contact@universite.tg">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Localisation & Téléphone -->
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="localisation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Localisation
                                </label>
                                <input type="text" id="localisation" name="localisation" 
                                    value="{{ auth()->user()->localisation }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Ex: Lomé, Togo">
                                @error('localisation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Téléphone
                                </label>
                                <input type="tel" id="telephone" name="telephone" 
                                    value="{{ auth()->user()->telephone }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="+228 XXXXXXXX">
                                @error('telephone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description/Vision -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description de l'université
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Présentez votre université...">{{ auth()->user()->description }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vision -->
                        <div class="mb-6">
                            <label for="vision" class="block text-sm font-semibold text-gray-700 mb-2">
                                Votre vision / Mission
                            </label>
                            <textarea id="vision" name="vision" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Quelle est votre mission éducative ?">{{ auth()->user()->vision }}</textarea>
                            @error('vision')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Statut de Validation -->
                    <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="font-semibold text-blue-900 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Statut de votre compte
                        </h3>
                        <p class="text-blue-800 text-sm mb-3">
                            @if(auth()->user()->est_valide)
                                <span class="text-green-600 font-semibold">Votre compte est validé</span> - Vous pouvez publier vos formations
                            @else
                                <span class="text-yellow-600 font-semibold">En attente de validation</span> - Un administrateur examinera votre profil sous peu
                            @endif
                        </p>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-between items-center pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-lg hover:bg-indigo-700 transition duration-200 font-semibold">
                            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                        </button>
                    </div>

                    <!-- Message de succès -->
                    @if (session('status') === 'profile-updated')
                        <div class="mt-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Profil mis à jour avec succès !
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Section Formations -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-purple-500">
                    <i class="fas fa-book-open mr-2 text-purple-600"></i>
                    Gérer vos formations
                </h2>

                <p class="text-gray-600 mb-4">
                    Publiez et gérez les programmes de formation de votre université.
                </p>
                
                <a href="{{ route('formations.index') }}" class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                    <i class="fas fa-arrow-right mr-2"></i>Voir mes formations
                </a>
            </div>
        </div>

        <!-- Section Sécurité -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-red-500">
                    <i class="fas fa-lock mr-2 text-red-600"></i>
                    Sécurité du compte
                </h2>

                <div class="space-y-4">
                    <p class="text-gray-600">
                        Renforcez la sécurité de votre compte UniLomé.
                    </p>
                    
                    <a href="{{ route('password.request') }}" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                        <i class="fas fa-key mr-2"></i>Changer mon mot de passe
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Suppression de Compte -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-red-700">
                    <i class="fas fa-trash mr-2 text-red-700"></i>
                    Zone de danger
                </h2>

                <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-4">
                    <p class="text-red-800 font-semibold mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Supprimer définitivement mon compte
                    </p>
                    <p class="text-red-700 text-sm mb-4">
                        Cette action est irréversible. Toutes les données de votre université seront supprimées.
                    </p>
                    
                    <form action="{{ route('profile.destroy') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-200"
                            onclick="return confirm('Êtes-vous sûr ? Cette action ne peut pas être annulée.')">
                            <i class="fas fa-times-circle mr-2"></i>Supprimer mon compte
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
