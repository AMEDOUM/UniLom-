<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation de base
    $request->validate([
        'nom' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:etudiant,universite'],
    ]);
    
    // Validation conditionnelle selon le rôle
    if ($request->role === 'etudiant') {
        $request->validate([
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'sexe' => ['nullable', 'in:M,F'],
        ]);
    } else {
        $request->validate([
            'nom_universite' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'localisation' => ['nullable', 'string', 'max:255'],
        ]);
    }

    // Création de l'utilisateur
    $user = User::create([
        'name' => $request->nom,          // Pour Laravel Breeze
        'nom' => $request->nom,           // Votre champ personnalisé
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'date_naissance' => $request->date_naissance,
        'sexe' => $request->sexe,
        'nom_universite' => $request->nom_universite,
        'telephone' => $request->telephone,
        'localisation' => $request->localisation,
        'est_valide' => $request->role === 'etudiant', // Étudiants validés direct
        'email_verified_at' => $request->role === 'etudiant' ? now() : null, // Étudiants vérifiés automatiquement
    ]);

    event(new Registered($user));
    Auth::login($user);

    // Redirection selon le rôle
    if ($user->role === 'etudiant') {
        return redirect()->route('dashboard')->with('success', 'Bienvenue étudiant !');
    } else {
        return redirect()->route('dashboard')->with('info', 'Votre compte université est en attente de validation.');
    }
}
}
