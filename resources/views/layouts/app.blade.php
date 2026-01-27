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
            
                <!-- Navigation simplifiée -->
                <nav class="bg-white shadow py-4">
                    <div class="container mx-auto px-4 flex justify-between items-center">
                        <a href="/" class="text-xl font-bold text-blue-700">
                            <i class="fas fa-graduation-cap mr-2"></i>UniLomé
                        </a>
                        <div class="space-x-4">
                            <a href="/" class="text-gray-700 hover:text-blue-600">Accueil</a>
                            <a href="/universites" class="text-gray-700 hover:text-blue-600">Universités</a>
                            
                            @auth
                                <!-- ⭐⭐ AJOUTEZ ICI ⭐⭐ -->
                                @if(auth()->user()->role === 'etudiant')
                                <a href="{{ route('favoris.index') }}" class="text-gray-700 hover:text-blue-600 relative">
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
                                <!-- ⭐⭐ FIN DE L'AJOUT ⭐⭐ -->

                                @auth
                                    @if(auth()->user()->role === 'etudiant')
                                    <a href="{{ route('test-orientation.index') }}" class="text-gray-700 hover:text-blue-600">
                                        <i class="fas fa-clipboard-check mr-1"></i>Test d'orientation
                                    </a>
                                    @endif
                                @endauth
                                
                                <a href="/dashboard" class="text-blue-600 font-medium">Mon compte</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-700 hover:text-red-600">Déconnexion</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Connexion</a>
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Inscription</a>
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
