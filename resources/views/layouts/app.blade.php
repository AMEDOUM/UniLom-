<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Dans la section <head> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- Dans la section <head> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
                <!-- Navigation Responsive -->
                <nav x-data="{ open: false }" class="bg-white shadow relative z-50">
                    <div class="container mx-auto px-4">
                        <div class="flex justify-between items-center py-4">
                            <!-- Logo -->
                            <a href="/" class="text-xl font-bold text-blue-700 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>UniLomé
                            </a>

                            <!-- Desktop Menu -->
                            <div class="hidden md:flex space-x-4 items-center">
                                <a href="/" class="{{ request()->routeIs('home') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }} px-3 py-2 transition duration-150">Accueil</a>
                                <a href="/universites" class="{{ request()->is('universites*') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }} px-3 py-2 transition duration-150">Universités</a>
                                <a href="{{ route('actualites.index') }}" class="{{ request()->routeIs('actualites.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }} px-3 py-2 transition duration-150">Actualités</a>
                                
                                @auth
                                    @if(auth()->user()->role === 'etudiant')
                                    <a href="{{ route('favoris.index') }}" class="{{ request()->routeIs('favoris.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }} relative px-3 py-2 transition duration-150">
                                        <i class="far fa-star mr-1"></i>Favoris
                                        @php
                                            $countFavoris = auth()->user()->favoris()->count();
                                        @endphp
                                        @if($countFavoris > 0)
                                        <span class="absolute -top-2 -right-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            {{ $countFavoris }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif

                                    @if(auth()->user()->role === 'etudiant')
                                    <a href="{{ route('test-orientation.index') }}" class="{{ request()->routeIs('test-orientation.*') ? 'text-blue-600 font-bold border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600' }} px-3 py-2 transition duration-150">
                                        <i class="fas fa-clipboard-check mr-1"></i>Test
                                    </a>
                                    @endif
                                    
                                    <div class="relative ml-3" x-data="{ dropdownOpen: false }">
                                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-blue-600 font-medium focus:outline-none">
                                            <span>Mon compte</span>
                                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                        </button>
                                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5" style="display: none;">
                                            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tableau de bord</a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 transition duration-150">Connexion</a>
                                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded ml-2 hover:bg-blue-700 transition duration-150">Inscription</a>
                                @endauth
                            </div>

                            <!-- Mobile Menu Button -->
                            <div class="md:hidden flex items-center">
                                <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                                    <i class="fas fa-bars text-2xl" x-show="!open"></i>
                                    <i class="fas fa-times text-2xl" x-show="open" style="display: none;"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div x-show="open" class="md:hidden border-t border-gray-200" style="display: none;">
                        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white">
                            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">Accueil</a>
                            <a href="/universites" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('universites*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">Universités</a>
                            <a href="{{ route('actualites.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('actualites.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">Actualités</a>
                            
                            @auth
                                @if(auth()->user()->role === 'etudiant')
                                <a href="{{ route('favoris.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('favoris.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                                    <i class="far fa-star mr-2"></i>Favoris
                                </a>
                                <a href="{{ route('test-orientation.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('test-orientation.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                                    <i class="fas fa-clipboard-check mr-2"></i>Test d'orientation
                                </a>
                                @endif
                                
                                <div class="border-t border-gray-200 mt-2 pt-2">
                                    <a href="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Mon compte</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Déconnexion</button>
                                    </form>
                                </div>
                            @else
                                <div class="border-t border-gray-200 mt-2 pt-2 flex flex-col space-y-2 px-3">
                                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-blue-600 text-blue-600 rounded-md font-medium hover:bg-blue-50">Connexion</a>
                                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">Inscription</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
