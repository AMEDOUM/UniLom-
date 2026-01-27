@extends('layouts.app')

@section('title', 'Modifier mon profil - Étudiant')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                <h1 class="text-3xl font-bold">Modifier mon profil</h1>
                <p class="text-blue-100 mt-2">Mettez à jour vos informations personnelles</p>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Informations Personnelles -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-blue-500">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Informations Personnelles
                        </h2>

                        <!-- Nom -->
                        <div class="mb-6">
                            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom complet *
                            </label>
                            <input type="text" id="nom" name="name" value="{{ auth()->user()->nom }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Votre nom complet">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse email *
                            </label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="votre@email.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date de Naissance -->
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="date_naissance" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Date de naissance
                                </label>
                                <input type="date" id="date_naissance" name="date_naissance" 
                                    value="{{ auth()->user()->date_naissance }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('date_naissance')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sexe -->
                            <div>
                                <label for="sexe" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Sexe
                                </label>
                                <select id="sexe" name="sexe"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="M" {{ auth()->user()->sexe === 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ auth()->user()->sexe === 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('sexe')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Localisation & Téléphone -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="localisation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Localisation
                                </label>
                                <input type="text" id="localisation" name="localisation" 
                                    value="{{ auth()->user()->localisation }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Votre ville">
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="+228 XXXXXXXX">
                                @error('telephone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-between items-center pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Retour
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
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
                        Cette action est irréversible. Toutes vos données seront supprimées.
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
