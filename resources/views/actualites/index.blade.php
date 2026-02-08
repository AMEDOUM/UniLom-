@extends('layouts.app')

@section('title', 'Actualités - UniLomé')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Actualités</h1>
                    <p class="mt-2 text-gray-600">Découvrez les dernières actualités de nos universités</p>
                </div>
                @auth
                    @if(auth()->user()->role === 'universite' && auth()->user()->est_valide)
                        <a href="{{ route('actualites.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-plus mr-2"></i> Nouvelle actualité
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Grille des actualités -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($actualites as $actualite)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                    <!-- Image -->
                    @if($actualite->image)
                        <div class="h-48 overflow-hidden bg-gray-200">
                            <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}" class="w-full h-full object-cover hover:scale-105 transition">
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                        </div>
                    @endif

                    <!-- Contenu -->
                    <div class="p-6">
                        <!-- Université -->
                        <div class="flex items-center mb-3">
                            <a href="{{ route('universites.show', $actualite->universite) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                {{ $actualite->universite->nom }}
                            </a>
                        </div>

                        <!-- Titre -->
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('actualites.show', $actualite) }}" class="hover:text-blue-600 transition">
                                {{ $actualite->titre }}
                            </a>
                        </h3>

                        <!-- Description -->
                        @if($actualite->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $actualite->description }}
                            </p>
                        @endif

                        <!-- Date -->
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $actualite->date_publication->format('d M Y') }}
                            </span>
                        </div>

                        <!-- Lire la suite -->
                        <a href="{{ route('actualites.show', $actualite) }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-medium text-sm">
                            Lire la suite <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 mb-4">Aucune actualité pour le moment.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($actualites->hasPages())
            <div class="mt-8">
                {{ $actualites->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
