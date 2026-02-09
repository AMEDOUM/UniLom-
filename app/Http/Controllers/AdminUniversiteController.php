<?php

// app/Http/Controllers/AdminUniversiteController.php
namespace App\Http\Controllers;

use App\Models\Universite;
use Illuminate\Http\Request;

class AdminUniversiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Universite::withCount('formations');
        $query->whereHas('user'); // Exclure les universités orphelines (utilisateur supprimé)
        
        // Filtres
        if ($request->filter == 'pending') {
            $query->where('statut_validation', 'en_attente');
        } elseif ($request->filter == 'validated') {
            $query->where('statut_validation', 'approuvee');
        } elseif ($request->filter == 'active') {
            $query->where('est_active', true);
        }
        
        // Recherche
        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('ville', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $universites = $query->latest()->paginate(10);
        
        return view('admin.universites.index', compact('universites'));
    }
    
    public function edit($id)
    {
        $universite = Universite::findOrFail($id);
        return view('admin.universites.edit', compact('universite'));
    }
    
    public function update(Request $request, $id)
    {
        $universite = Universite::findOrFail($id);
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'email' => 'required|email',
            'est_valide' => 'boolean',
            'est_active' => 'boolean'
        ]);
        
        $universite->update($validated);
        
        return redirect()->route('admin.universites.index')
                         ->with('success', 'Université mise à jour avec succès');
    }
    
    public function toggleStatus($id)
    {
        $universite = Universite::findOrFail($id);
        
        if ($universite->statut_validation === 'approuvee') {
            $universite->update(['statut_validation' => 'en_attente', 'est_active' => false]);
            $message = 'Université mise en attente';
        } else {
            $universite->update(['statut_validation' => 'approuvee', 'est_active' => true]);
            $message = 'Université validée avec succès';
        }
            
        return back()->with('success', $message);
    }
}