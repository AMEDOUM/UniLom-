@extends('layouts.admin')

@section('title', 'Gestion des Universités')
@section('page-title', 'Gestion des Universités')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Liste des universités</h2>
        <p class="text-gray-600">Gérez et validez les inscriptions des universités</p>
    </div>
    
    <div class="flex space-x-3">
        <div class="relative">
            <input type="text" 
                   placeholder="Rechercher une université..." 
                   class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>
</div>

{{-- Filtres --}}
<div class="bg-white rounded-xl shadow mb-6 p-4">
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.universites.index') }}" 
           class="px-4 py-2 rounded-lg {{ !request('filter') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
            Toutes ({{ \App\Models\Universite::count() }})
        </a>
        <a href="{{ route('admin.universites.index', ['filter' => 'validated']) }}" 
           class="px-4 py-2 rounded-lg {{ request('filter') == 'validated' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            Validées ({{ \App\Models\Universite::where('est_active', true)->count() }})
        </a>
        <a href="{{ route('admin.universites.index', ['filter' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg {{ request('filter') == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
            En attente ({{ \App\Models\Universite::where('est_active', false)->count() }})
        </a>
        <a href="{{ route('admin.universites.index', ['filter' => 'active']) }}" 
           class="px-4 py-2 rounded-lg {{ request('filter') == 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
            Actives ({{ \App\Models\Universite::where('est_active', true)->count() }})
        </a>
    </div>
</div>

{{-- Tableau --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Université
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Localisation
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Formations
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($universites as $universite)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($universite->logo)
                                <img class="h-10 w-10 rounded-full object-cover mr-3" 
                                     src="{{ asset('storage/' . $universite->logo) }}" 
                                     alt="{{ $universite->nom }}">
                            @else
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-university text-blue-600"></i>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-900">{{ $universite->nom }}</div>
                                <div class="text-sm text-gray-500">{{ $universite->sigle }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $universite->ville }}</div>
                        <div class="text-sm text-gray-500">{{ $universite->pays }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $universite->email }}</div>
                        <div class="text-sm text-gray-500">{{ $universite->telephone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="space-y-1">
                            @if($universite->est_active)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                    Validée
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                    En attente
                                </span>
                            @endif
                            
                            @if($universite->est_active)
                                <span class="block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                    Active
                                </span>
                            @else
                                <span class="block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium">{{ $universite->formations_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500">formations</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.universites.edit', $universite->id) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.universites.toggle-status', $universite->id) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" 
                                        class="text-{{ $universite->est_valide ? 'yellow' : 'green' }}-600 hover:text-{{ $universite->est_active ? 'yellow' : 'green' }}-900"
                                        title="{{ $universite->est_active ? 'Mettre en attente' : 'Valider' }}">
                                    <i class="fas fa-{{ $universite->est_active ? 'clock' : 'check-circle' }}"></i>
                                </button>
                            </form>
                            
                            <a href="{{ route('universites.show', $universite->id) }}" 
                               target="_blank"
                               class="text-gray-600 hover:text-gray-900" title="Voir public">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-university text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg">Aucune université trouvée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    @if($universites->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $universites->links() }}
    </div>
    @endif
</div>
@endsection