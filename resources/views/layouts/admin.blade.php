<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - UniLomé')</title>
    
    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .sidebar {
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            .sidebar.active {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    {{-- Sidebar --}}
    <div class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white">
        {{-- Logo --}}
        <div class="p-6 border-b border-gray-800">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-cog text-white"></i>
                </div>
                <h1 class="text-xl font-bold">UniLomé Admin</h1>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">
                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.universites.index') }}" 
               class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.universites.*') ? 'bg-gray-800' : '' }}">
                <i class="fas fa-university w-5 mr-3"></i>
                <span>Universités</span>
                @if($pendingUniversites = \App\Models\Universite::where('est_active', false)->count())
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">
                        {{ $pendingUniversites }}
                    </span>
                @endif
            </a>
            
            <a href="{{ route('admin.formations.index') }}" 
               class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.formations.*') ? 'bg-gray-800' : '' }}">
                <i class="fas fa-graduation-cap w-5 mr-3"></i>
                <span>Formations</span>
            </a>
            
            <a href="{{ route('admin.utilisateurs.index') }}" 
               class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.utilisateurs.*') ? 'bg-gray-800' : '' }}">
                <i class="fas fa-users w-5 mr-3"></i>
                <span>Utilisateurs</span>
            </a>
            
            <a href="{{ route('admin.statistique') }}" 
               class="flex items-center p-3 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.statistiques') ? 'bg-gray-800' : '' }}">
                <i class="fas fa-chart-bar w-5 mr-3"></i>
                <span>Statistiques</span>
            </a>
            
            <div class="pt-6 border-t border-gray-800">
                <a href="{{ route('home') }}" 
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-home w-5 mr-3"></i>
                    <span>Accueil</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-3 rounded-lg hover:bg-gray-800 text-red-400">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    {{-- Contenu principal --}}
    <div class="ml-64 min-h-screen">
        {{-- Top bar --}}
        <header class="bg-white shadow-sm border-b">
            <div class="flex justify-between items-center px-6 py-4">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="lg:hidden mr-4 text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            3
                        </span>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="ml-3 text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- Contenu de la page --}}
        <main class="p-6">
            {{-- Messages flash --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Scripts --}}
    <script>
        // Toggle sidebar mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
        
        // Fermer sidebar en cliquant à l'extérieur (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>