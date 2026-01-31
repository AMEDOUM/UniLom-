<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Universite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notification;
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
        // Déterminer le rôle
        $role = $request->input('role', 'etudiant');
        
        // Validation de base - toujours requise
        $baseRules = [
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:etudiant,universite'],
            'privacy' => ['accepted'],
        ];
        
        // Ajouter les règles conditionnelles selon le rôle
        if ($role === 'etudiant') {
            $baseRules['date_naissance'] = ['nullable', 'date', 'before:today'];
            $baseRules['sexe'] = ['nullable', 'in:M,F'];
        } elseif ($role === 'universite') {
            $baseRules['nom_universite'] = ['required', 'string', 'max:255'];
            $baseRules['telephone'] = ['nullable', 'string', 'max:20'];
            $baseRules['localisation'] = ['nullable', 'string', 'max:255'];
        }
        
        // Valider tout en une seule fois
        $validated = $request->validate($baseRules);

        // Créer les données utilisateur
        $userData = [
            'name' => $request->nom,
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'est_valide' => $role === 'etudiant',
            'email_verified_at' => $role === 'etudiant' ? now() : null,
        ];

        // Ajouter les champs conditionnels
        if ($role === 'etudiant') {
            $userData['date_naissance'] = $request->date_naissance ?? null;
            $userData['sexe'] = $request->sexe ?? null;
        } else {
            $userData['nom_universite'] = $request->nom_universite ?? null;
            $userData['telephone'] = $request->telephone ?? null;
            $userData['localisation'] = $request->localisation ?? null;
        }

        // Créer l'utilisateur
        $user = User::create($userData);

        event(new Registered($user));
        
        // Si c'est une université, créer un enregistrement dans la table universites
        if ($role === 'universite') {
            Universite::create([
                'user_id' => $user->id,
                'nom' => $request->nom_universite,
                'sigle' => strtoupper(substr($request->nom_universite, 0, 3)),
                'description' => null,
                'ville' => $request->localisation ?? null,
                'pays' => 'Togo',
                'telephone' => $request->telephone ?? null,
                'email' => $user->email,
                'site_web' => null,
                'adresse' => null,
                'est_public' => false,
                'est_active' => false,  // En attente de validation
                'statut_validation' => 'en_attente',
            ]);
            
            // Envoyer une notification aux admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\UniversiteCreated($user));
            }
        }

        // Rediriger vers la page de connexion
        return redirect('/login')->with('success', 'Inscription réussie ! Veuillez vous connecter.');
}
}
