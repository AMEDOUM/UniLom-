<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les utilisateurs :
        // 1. Tous ceux qui ne sont PAS 'universite'
        // 2. OU ceux qui sont 'universite' ET qui ont un profil (relation universite existe)
        $users = \App\Models\User::where('role', '!=', 'universite')
            ->orWhere(function($query) {
                $query->where('role', 'universite')
                      ->whereHas('universite');
            })
            ->latest()
            ->paginate(15);
            
        return view('admin.utilisateurs.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\User $user)
    {
        return view('admin.utilisateurs.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:etudiant,universite,admin',
        ]);
        
        // Gérer la vérification email via checkbox
        if ($request->has('email_verified')) {
            $user->email_verified_at = $user->email_verified_at ?? now();
        } else {
            $user->email_verified_at = null;
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.utilisateurs.index')
                         ->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\User $user)
    {
        if ($user->role === 'admin' && auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte admin !');
        }
        
        $user->delete();
        
        return back()->with('success', 'Utilisateur supprimé avec succès !');
    }
}
