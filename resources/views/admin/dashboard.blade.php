@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Utilisateurs --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Utilisateurs total</p>
                <h3 class="text-2xl font-bold">{{ \App\Models\User::where('role', '!=', 'universite')->orWhere(function($q) { $q->where('role', 'universite')->whereHas('universite'); })->count() }}</h3>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <div class="grid grid-cols-3 gap-2 text-xs">
                <div class="text-center">
                    <div class="font-semibold text-green-600">{{ \App\Models\User::where('role', 'etudiant')->count() }}</div>
                    <div class="text-gray-500">Étudiants</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold text-blue-600">{{ \App\Models\User::where('role', 'universite')->whereHas('universite')->count() }}</div>
                    <div class="text-gray-500">Universités (actives)</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold text-red-600">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                    <div class="text-gray-500">Admins</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Universités --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                <i class="fas fa-university text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Universités</p>
                <h3 class="text-2xl font-bold">{{ \App\Models\Universite::whereHas('user')->count() }}</h3>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <div class="grid grid-cols-3 gap-2 text-xs">
                <div class="text-center">
                    <div class="font-semibold text-green-600">{{ \App\Models\Universite::whereHas('user')->where('statut_validation', 'approuvee')->count() }}</div>
                    <div class="text-gray-500">Approuvées</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold text-yellow-600">{{ \App\Models\Universite::whereHas('user')->where('statut_validation', 'en_attente')->count() }}</div>
                    <div class="text-gray-500">En attente</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold text-red-600">{{ \App\Models\Universite::whereHas('user')->where('statut_validation', 'rejetee')->count() }}</div>
                    <div class="text-gray-500">Rejetées</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formations --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Formations</p>
                <h3 class="text-2xl font-bold">{{ \App\Models\Formation::count() }}</h3>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="text-center">
                    <div class="font-semibold text-green-600">{{ \App\Models\Formation::where('est_active', true)->count() }}</div>
                    <div class="text-gray-500">Actives</div>
                </div>
                <div class="text-center">
                    <div class="font-semibold text-gray-600">{{ \App\Models\Formation::where('est_active', false)->count() }}</div>
                    <div class="text-gray-500">Inactives</div>
                </div>
            </div>
        </div>
    </div>

    {{-- À valider --}}
    @php
        $enAttenteCount = \App\Models\Universite::whereHas('user')->where('statut_validation', 'en_attente')->count();
    @endphp
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-lg {{ $enAttenteCount > 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} mr-4">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">À valider</p>
                <h3 class="text-2xl font-bold">{{ $enAttenteCount }}</h3>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            @if($enAttenteCount > 0)
                <a href="{{ route('admin.universites.index', ['statut' => 'en_attente']) }}" 
                   class="text-sm text-red-600 hover:text-red-800 block text-center">
                    <i class="fas fa-arrow-right mr-1"></i> Valider maintenant
                </a>
            @else
                <span class="text-sm text-green-600 block text-center">
                    <i class="fas fa-check mr-1"></i> Tout est validé
                </span>
            @endif
        </div>
    </div>
</div>

{{-- Universités en attente (UNIQUEMENT s'il y en a) --}}
@php
    $dernieresEnAttente = \App\Models\Universite::whereHas('user')->where('statut_validation', 'en_attente')
        ->latest()
        ->take(5)
        ->get();
@endphp

@if($dernieresEnAttente->count() > 0)
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-clock text-yellow-500 mr-2"></i>
            Universités en attente de validation
        </h2>
        <a href="{{ route('admin.universites.index', ['statut' => 'en_attente']) }}" 
           class="text-sm text-blue-600 hover:text-blue-800">
            Voir toutes ({{ $enAttenteCount }})
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Université</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Localisation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date d'inscription</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($dernieresEnAttente as $universite)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $universite->nom }}</div>
                            <div class="text-sm text-gray-500">{{ $universite->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ $universite->ville }}</div>
                            <div class="text-sm text-gray-500">{{ $universite->pays }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">{{ $universite->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $universite->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.universites.edit', $universite->id) }}" 
                                   class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded hover:bg-blue-200">
                                    <i class="fas fa-eye mr-1"></i> Examiner
                                </a>
                                <form action="{{ route('admin.universites.approuver', $universite->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Approuver cette université ?')">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded hover:bg-green-200">
                                        <i class="fas fa-check mr-1"></i> Approuver
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- Dernières activités --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-university mr-2 text-blue-600"></i>
                Dernières universités approuvées
            </h3>
        </div>
        <div class="divide-y">
            @forelse(\App\Models\Universite::whereHas('user')->where('statut_validation', 'approuvee')->latest()->take(5)->get() as $universite)
            <div class="p-4 hover:bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium">{{ $universite->nom }}</h4>
                        <p class="text-sm text-gray-500">{{ $universite->ville }}, {{ $universite->pays }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                            Approuvée
                        </span>
                        <a href="{{ route('admin.universites.edit', $universite->id) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    Approuvée le {{ $universite->validee_le ? $universite->validee_le->format('d/m/Y') : $universite->created_at->format('d/m/Y') }}
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Aucune université approuvée
            </div>
            @endforelse
        </div>
        <div class="p-4 border-t text-center">
            <a href="{{ route('admin.universites.index', ['statut' => 'approuvee']) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Voir toutes les universités approuvées →
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
                Dernières formations ajoutées
            </h3>
        </div>
        <div class="divide-y">
            @forelse(\App\Models\Formation::with('universite')->latest()->take(5)->get() as $formation)
            <div class="p-4 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium">{{ $formation->nom }}</h4>
                        <p class="text-sm text-gray-500">
                            {{ $formation->domaine }} • {{ $formation->niveau }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $formation->universite->nom ?? 'Université inconnue' }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($formation->est_active)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                Active
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Aucune formation ajoutée
            </div>
            @endforelse
        </div>
        <div class="p-4 border-t text-center">
            <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Voir toutes les formations →
            </a>
        </div>
    </div>
</div>

{{-- Actions rapides --}}
<div class="mt-8 bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.universites.index', ['statut' => 'en_attente']) }}" 
           class="p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-300 transition">
            <div class="flex items-center">
                <div class="p-2 {{ $enAttenteCount > 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-lg mr-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h4 class="font-medium">Valider universités</h4>
                    <p class="text-sm {{ $enAttenteCount > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $enAttenteCount }} en attente
                    </p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.utilisateurs.index') }}" class="p-4 border rounded-lg hover:bg-green-50 hover:border-green-300 transition">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <i class="fas fa-user-shield text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-medium">Gérer utilisateurs</h4>
                    <p class="text-sm text-gray-500">{{ \App\Models\User::count() }} utilisateurs</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.statistique') }}" class="p-4 border rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-purple-600"></i>
                </div>
                <div>
                    <h4 class="font-medium">Voir statistiques</h4>
                    <p class="text-sm text-gray-500">Analyses détaillées</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection