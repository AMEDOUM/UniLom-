{{-- Debug --}}
@php
    // Vérifie ce que contient $universite
    // dd($universite);
@endphp

@extends('layouts.app') {{-- Ou ton layout admin si tu en as un --}}

@section('title', 'Modifier une université - Admin')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        {{-- En-tête --}}
        <div class="mb-6">
            <a href="{{ route('admin.universites.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Retour à la liste
            </a>
            <h1 class="text-2xl font-bold mt-2">Modifier l'université</h1>
        </div>
        
        {{-- Formulaire --}}
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.universites.update', $universite->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nom --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nom de l'université *
                        </label>
                        <input type="text" 
                               name="nom" 
                               value="{{ old('nom', $universite->nom) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                    
                    {{-- Sigle --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sigle
                        </label>
                        <input type="text" 
                               name="sigle" 
                               value="{{ old('sigle', $universite->sigle) }}"
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    
                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email *
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $universite->email) }}"
                               class="w-full px-4 py-2 border rounded-lg"
                               required>
                    </div>
                    
                    {{-- Ville --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Ville *
                        </label>
                        <input type="text" 
                               name="ville" 
                               value="{{ old('ville', $universite->ville) }}"
                               class="w-full px-4 py-2 border rounded-lg"
                               required>
                    </div>
                    
                    {{-- Pays --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Pays *
                        </label>
                        <input type="text" 
                               name="pays" 
                               value="{{ old('pays', $universite->pays) }}"
                               class="w-full px-4 py-2 border rounded-lg"
                               required>
                    </div>
                    
                    {{-- Téléphone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Téléphone
                        </label>
                        <input type="text" 
                               name="telephone" 
                               value="{{ old('telephone', $universite->telephone) }}"
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    
                    {{-- Site web --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Site web
                        </label>
                        <input type="url" 
                               name="site_web" 
                               value="{{ old('site_web', $universite->site_web) }}"
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    
                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description" 
                                  rows="3"
                                  class="w-full px-4 py-2 border rounded-lg">{{ old('description', $universite->description) }}</textarea>
                    </div>
                    
                    {{-- Statuts --}}
                    <div class="md:col-span-2 space-y-4 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium">Statuts</h3>
                        
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="est_active" 
                                   name="est_active" 
                                   value="1"
                                   {{ old('est_active', $universite->est_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                            <label for="est_active" class="ml-2 text-sm">
                                Université active (visible sur le site)
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="est_public" 
                                   name="est_public" 
                                   value="1"
                                   {{ old('est_public', $universite->est_public) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                            <label for="est_public" class="ml-2 text-sm">
                                Université publique
                            </label>
                        </div>
                    </div>
                </div>
                
                {{-- Boutons --}}
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                    <a href="{{ route('admin.universites.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
        
        {{-- Danger zone --}}
        <div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-red-800 mb-4">Zone de danger</h3>
            
            <div class="space-y-4">
                {{-- Basculer statut --}}
                <form action="{{ route('admin.universites.toggle-status', $universite->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Êtes-vous sûr de vouloir changer le statut de cette université ?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" 
                            class="px-4 py-2 bg-{{ $universite->est_active ? 'yellow' : 'green' }}-600 text-white rounded-lg hover:bg-{{ $universite->est_active ? 'yellow' : 'green' }}-700">
                        {{ $universite->est_active ? 'Désactiver' : 'Activer' }} cette université
                    </button>
                </form>
                
                {{-- Supprimer (à implémenter plus tard) --}}
                {{--
                <form action="{{ route('admin.universites.destroy', $universite->id) }}" 
                      method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette université ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Supprimer définitivement
                    </button>
                </form>
                --}}
            </div>
        </div>

                        
                        {{-- Section Validation --}}
                @if(isset($universite->statut_validation))
                <div class="mt-8 bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        Validation de l'université
                    </h3>
                    
                    <div class="space-y-4">
                        {{-- Statut actuel --}}
                        <div class="p-4 rounded-lg 
                            @if($universite->statut_validation === 'approuvee') bg-green-50 border border-green-200
                            @elseif($universite->statut_validation === 'rejetee') bg-red-50 border border-red-200
                            @else bg-yellow-50 border border-yellow-200 @endif">
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium">Statut :</span>
                                    <span class="ml-2">
                                        @if($universite->statut_validation === 'approuvee')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i> Approuvée
                                            </span>
                                        @elseif($universite->statut_validation === 'rejetee')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i> Rejetée
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i> En attente
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                
                                @if($universite->validee_le)
                                    <div class="text-sm text-gray-600">
                                        Validée le {{ $universite->validee_le->format('d/m/Y') }}
                                        @if($universite->validateur)
                                            par {{ $universite->validateur->name }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Raison du rejet --}}
                            @if($universite->statut_validation === 'rejetee' && $universite->raison_rejet)
                                <div class="mt-3 p-3 bg-white rounded border">
                                    <p class="font-medium text-red-700">Raison du rejet :</p>
                                    <p class="mt-1 text-gray-700">{{ $universite->raison_rejet }}</p>
                                    
                                    @if($universite->date_limite_correction)
                                        <p class="mt-2 text-sm text-gray-600">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Date limite pour corriger : {{ \Carbon\Carbon::parse($universite->date_limite_correction)->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        {{-- Actions de validation --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Approuver --}}
                            <form action="{{ route('admin.universites.approuver', $universite->id) }}" 
                                method="POST"
                                onsubmit="return confirm('Approuver cette université ? Elle sera visible sur le site.')">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                        {{ $universite->statut_validation === 'approuvee' ? 'disabled' : '' }}>
                                    <i class="fas fa-check mr-2"></i>
                                    Approuver
                                </button>
                            </form>
                            
                            {{-- Rejeter --}}
                            <button type="button" 
                                    onclick="openRejectModal()"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                    {{ $universite->statut_validation === 'rejetee' ? 'disabled' : '' }}>
                                <i class="fas fa-times mr-2"></i>
                                Rejeter
                            </button>
                            
                            {{-- Remettre en attente --}}
                            @if($universite->statut_validation !== 'en_attente')
                            <form action="{{ route('admin.universites.remettre-en-attente', $universite->id) }}" 
                                method="POST"
                                onsubmit="return confirm('Remettre cette université en attente ?')">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center justify-center px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                    <i class="fas fa-history mr-2"></i>
                                    Remettre en attente
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Modal de rejet --}}
                <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
                    <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rejeter l'université</h3>
                            
                            <form id="rejectForm" action="{{ route('admin.universites.rejeter', $universite->id) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Raison du rejet *
                                    </label>
                                    <textarea name="raison_rejet" 
                                            rows="4"
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                            placeholder="Expliquez pourquoi cette université est rejetée..."
                                            required></textarea>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Cette raison sera communiquée à l'université.
                                    </p>
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button type="button" 
                                            onclick="closeRejectModal()"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                                        Annuler
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Confirmer le rejet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                function openRejectModal() {
                    document.getElementById('rejectModal').classList.remove('hidden');
                }

                function closeRejectModal() {
                    document.getElementById('rejectModal').classList.add('hidden');
                }

                // Fermer modal en cliquant à l'extérieur
                document.getElementById('rejectModal').addEventListener('click', function(e) {
                    if (e.target.id === 'rejectModal') {
                        closeRejectModal();
                    }
                });
                </script>
                @endif
    </div>
</div>
@endsection