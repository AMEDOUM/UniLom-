@extends('layouts.admin')

@section('title', 'Éditer ' . $user->name . ' - Admin UniLomé')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- En-tête --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.utilisateurs.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Éditer l'utilisateur</h1>
            <p class="text-gray-600 mt-2">Modifiez les informations de {{ $user->name }}</p>
        </div>
        <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-semibold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    </div>

    {{-- Messages de succès/erreur --}}
    @if ($errors->any())
        <div class="rounded-lg bg-red-50 p-4 border border-red-200 mb-8">
            <h3 class="text-sm font-medium text-red-800 mb-2">Erreurs de validation:</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Formulaire principal --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('admin.utilisateurs.update', $user) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Informations personnelles --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-3"></i>
                        Informations personnelles
                    </h2>

                    <div class="space-y-4">
                        {{-- Nom --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse e-mail</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                required>
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Téléphone (optionnel) --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $user->phone ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="+228 XX XX XX XX">
                        </div>
                    </div>
                </div>

                {{-- Rôle et Statut --}}
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-shield-alt text-purple-600 mr-3"></i>
                        Rôle et Statut
                    </h2>

                    <div class="space-y-4">
                        {{-- Rôle --}}
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                            <select 
                                id="role" 
                                name="role"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                <option value="etudiant" {{ $user->role === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                <option value="universite" {{ $user->role === 'universite' ? 'selected' : '' }}>Université</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                            @if(auth()->id() === $user->id)
                                <p class="text-xs text-gray-500 mt-2">Vous ne pouvez pas modifier votre propre rôle</p>
                            @endif
                        </div>

                        {{-- Vérification email --}}
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="email_verified" 
                                    {{ $user->email_verified_at ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Email vérifié</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-2">
                                @if($user->email_verified_at)
                                    Vérifié le {{ $user->email_verified_at->translatedFormat('d F Y à H:i') }}
                                @else
                                    Non vérifié
                                @endif
                            </p>
                        </div>

                        {{-- Statut actif --}}
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="est_valide" 
                                    {{ $user->est_valide ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Compte actif</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-medium transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                    <a 
                        href="{{ route('admin.utilisateurs.index') }}" 
                        class="flex-1 bg-gray-100 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-200 font-medium transition text-center">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Informations utilisateur --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Informations
                </h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">ID</p>
                        <p class="font-mono bg-gray-50 px-2 py-1 rounded">{{ $user->id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Rôle actuel</p>
                        <p class="font-medium text-gray-900">
                            @if($user->role === 'etudiant')
                                <i class="fas fa-graduation-cap text-green-600 mr-2"></i>Étudiant
                            @elseif($user->role === 'universite')
                                <i class="fas fa-university text-purple-600 mr-2"></i>Université
                            @else
                                <i class="fas fa-shield-alt text-orange-600 mr-2"></i>Administrateur
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600">Inscription</p>
                        <p class="font-medium text-gray-900">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Dernière mise à jour</p>
                        <p class="font-medium text-gray-900">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            {{-- Actions supplémentaires --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-tools text-gray-600 mr-2"></i>
                    Actions
                </h3>
                <div class="space-y-2">
                    <button 
                        onclick="resetPassword({{ $user->id }})"
                        class="w-full px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 font-medium transition text-sm">
                        <i class="fas fa-key mr-2"></i>Réinitialiser MDP
                    </button>
                    @if($user->id !== auth()->id())
                    <button 
                        onclick="confirmDelete({{ $user->id }})"
                        class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 font-medium transition text-sm">
                        <i class="fas fa-trash mr-2"></i>Supprimer le compte
                    </button>
                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.utilisateurs.destroy', $user) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
            </div>

            {{-- État de vérification --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                <h4 class="font-semibold text-gray-900 mb-3">État de vérification</h4>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        @if($user->email_verified_at)
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-sm text-gray-900">Email vérifié</span>
                        @else
                            <i class="fas fa-times-circle text-red-600"></i>
                            <span class="text-sm text-gray-900">Email non vérifié</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($user->est_valide)
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-sm text-gray-900">Compte actif</span>
                        @else
                            <i class="fas fa-times-circle text-red-600"></i>
                            <span class="text-sm text-gray-900">Compte inactif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}

function resetPassword(userId) {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser le mot de passe ? Un email sera envoyé à l\'utilisateur.')) {
        // Implémenter la logique de réinitialisation
        alert('Fonctionnalité à implémenter');
    }
}
</script>
@endsection
