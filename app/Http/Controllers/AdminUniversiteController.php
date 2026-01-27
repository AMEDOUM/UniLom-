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
        
        // Filtres
        if ($request->filter == 'pending') {
            $query->where('est_valide', false);
        } elseif ($request->filter == 'validated') {
            $query->where('est_valide', true);
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
        $universite->update(['est_valide' => !$universite->est_valide]);
        
        $message = $universite->est_valide 
            ? 'Université validée avec succès' 
            : 'Université mise en attente';
            
        return back()->with('success', $message);
    }
}