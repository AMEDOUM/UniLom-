@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs - Admin UniLomé')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- En-tête --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Utilisateurs</h1>
                <p class="text-gray-600 mt-2">Gérez tous les utilisateurs de la plateforme</p>
            </div>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total utilisateurs</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $users->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Étudiants</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $users->where('role', 'etudiant')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Universités</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ $users->where('role', 'universite')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-university text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Administrateurs</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                <input type="text" id="searchInput" placeholder="Nom, email..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                <select id="roleFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les rôles</option>
                    <option value="etudiant">Étudiants</option>
                    <option value="universite">Universités</option>
                    <option value="admin">Administrateurs</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="verified">Vérifié</option>
                    <option value="unverified">Non vérifié</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table des utilisateurs --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Utilisateur</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Rôle</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Vérification</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Inscription</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    @if($user->role === 'universite')
                                        <p class="text-xs text-gray-500">Université</p>
                                    @elseif($user->role === 'etudiant')
                                        <p class="text-xs text-gray-500">Étudiant</p>
                                    @else
                                        <p class="text-xs text-gray-500">Administrateur</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-800">
                                {{ $user->email }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role === 'etudiant')
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-graduation-cap mr-1"></i>Étudiant
                                </span>
                            @elseif($user->role === 'universite')
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-university mr-1"></i>Université
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-shield-alt mr-1"></i>Admin
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($user->email_verified_at)
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Vérifié
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-times-circle mr-1"></i>Non vérifié
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="#" class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded hover:bg-blue-200 transition" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm rounded hover:bg-yellow-200 transition" title="Éditer">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                <button onclick="confirmDelete({{ $user->id }})" class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200 transition" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="#" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun utilisateur</h3>
            <p class="text-gray-600">Il n'y a aucun utilisateur enregistré</p>
        </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}

// Filtrage client-side (optionnel)
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
