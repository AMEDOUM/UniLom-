@extends('layouts.app')

@section('title', 'Modifier une actualité - UniLomé')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow p-8">
            <!-- En-tête -->
            <div class="mb-8 pb-6 border-b">
                <h1 class="text-3xl font-bold text-gray-900">Modifier l'actualité</h1>
                <p class="mt-2 text-gray-600">Mettez à jour les informations de votre actualité</p>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('actualites.update', $actualite) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Titre -->
                <div class="mb-6">
                    <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2 text-blue-600"></i> Titre
                    </label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre', $actualite->titre) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('titre') border-red-500 @enderror"
                        placeholder="Titre de l'actualité">
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (résumé) -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-quote-left mr-2 text-blue-600"></i> Description courte
                    </label>
                    <textarea id="description" name="description" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Résumé de l'actualité (max 500 caractères)">{{ old('description', $actualite->description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Max 500 caractères</p>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="mb-6">
                    <label for="contenu" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-2 text-blue-600"></i> Contenu détaillé
                    </label>
                    <textarea id="contenu" name="contenu" rows="10" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono @error('contenu') border-red-500 @enderror"
                        placeholder="Contenu complet de l'actualité...">{{ old('contenu', $actualite->contenu) }}</textarea>
                    @error('contenu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-blue-600"></i> Image de couverture
                    </label>
                    
                    @if($actualite->image)
                        <div class="mb-4 rounded-lg overflow-hidden max-h-48">
                            <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <div class="flex items-center">
                        <input type="file" id="image" name="image" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPEG, PNG, GIF (Max 2 Mo)</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de publication -->
                <div class="mb-6">
                    <label for="date_publication" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-blue-600"></i> Date de publication
                    </label>
                    <input type="datetime-local" id="date_publication" name="date_publication" 
                        value="{{ old('date_publication', $actualite->date_publication->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('date_publication') border-red-500 @enderror">
                    @error('date_publication')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('actualites.show', $actualite) }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
