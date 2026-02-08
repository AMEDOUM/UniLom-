@extends('layouts.app')

@section('title', $actualite->titre . ' - UniLomé')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow p-8">
            <!-- Retour -->
            <div class="mb-6">
                <a href="{{ route('actualites.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour aux actualités
                </a>
            </div>

            <!-- Image de couverture -->
            @if($actualite->image)
                <div class="mb-8 rounded-lg overflow-hidden max-h-96">
                    <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- En-tête -->
            <div class="mb-8 pb-6 border-b">
                <!-- Université -->
                <div class="mb-4">
                    <a href="{{ route('universites.show', $actualite->universite) }}" class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                        {{ $actualite->universite->nom }}
                    </a>
                </div>

                <!-- Titre -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $actualite->titre }}</h1>

                <!-- Métadonnées -->
                <div class="flex flex-wrap gap-6 text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-blue-600 mr-2"></i>
                        <span>{{ $actualite->date_publication->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-building text-blue-600 mr-2"></i>
                        <a href="{{ route('universites.show', $actualite->universite) }}" class="hover:text-blue-600 transition">
                            {{ $actualite->universite->nom }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($actualite->description)
                <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <p class="text-lg text-gray-800 italic">{{ $actualite->description }}</p>
                </div>
            @endif

            <!-- Contenu -->
            <div class="prose prose-lg max-w-none mb-8">
                {!! nl2br(e($actualite->contenu)) !!}
            </div>

            <!-- Actions pour le propriétaire -->
            @auth
                @can('update', $actualite)
                    <div class="flex gap-4 pt-8 border-t">
                        <a href="{{ route('actualites.edit', $actualite) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-edit mr-2"></i> Modifier
                        </a>
                        <form action="{{ route('actualites.destroy', $actualite) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Êtes-vous sûr?')">
                                <i class="fas fa-trash mr-2"></i> Supprimer
                            </button>
                        </form>
                    </div>
                @endcan
            @endauth
        </div>

        <!-- Actualités connexes -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Autres actualités de {{ $actualite->universite->nom }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($actualite->universite->actualites()->where('id', '!=', $actualite->id)->latest('date_publication')->limit(3)->get() as $related)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('actualites.show', $related) }}" class="hover:text-blue-600 transition">
                                {{ $related->titre }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ $related->date_publication->format('d M Y') }}
                        </p>
                        <a href="{{ route('actualites.show', $related) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Lire <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-full">Pas d'autres actualités pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
