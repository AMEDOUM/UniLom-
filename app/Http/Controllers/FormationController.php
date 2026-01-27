<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur FormationController
 * 
 * Gère la gestion des formations pour les universités.
 * Permet aux universités de créer, afficher et modifier leurs formations.
 * Les étudiants peuvent consulter les formations disponibles.
 */
class FormationController extends Controller
{
    /**
     * Liste les formations de l'université connectée.
     * 
     * Récupère toutes les formations associées à l'université
     * de l'utilisateur actuellement connecté.
     * 
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Vérifier que l'utilisateur est une université
        $user = Auth::user();
        
        if ($user->role !== 'universite') {
            abort(403, 'Accès réservé aux universités');
        }
        
        // Récupérer l'université associée à cet utilisateur
        // Chercher dans la table universites où user_id = $user->id
        $universite = Universite::where('user_id', $user->id)->first();
        
        // Si l'université n'existe pas encore, la créer
        if (!$universite) {
            $universite = Universite::create([
                'user_id' => $user->id,
                'nom' => $user->nom_universite ?? $user->nom,
                'email' => $user->email,
                'description' => $user->description ?? 'Description à compléter',
                'ville' => $user->localisation ?? 'Lomé',
                'adresse' => 'Adresse à compléter',
            ]);
        }
        
        // Récupérer les formations de l'université
        $formations = Formation::where('universite_id', $universite->id)
                              ->latest()
                              ->get();
        
        return view('formations.index', compact('formations', 'universite'));
    }
    
    /**
     * Affiche le formulaire de création d'une formation.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Charger toutes les universités actives pour le select
        $universites = Universite::where('est_active', true)
                                 ->orderBy('nom')
                                 ->get();
        
        return view('formations.create', compact('universites'));
    }

    /**
     * Sauvegarde une nouvelle formation dans la base de données.
     * 
     * Valide les données, crée une nouvelle formation
     * et redirige vers la liste avec un message de succès.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'domaine' => 'required|string|max:100',
            'niveau' => 'required|string|max:50',
            'universite_id' => 'required|exists:universites,id',
            'duree_mois' => 'nullable|integer|min:1',
            'frais_inscription' => 'nullable|numeric|min:0',
            'frais_scolarite_annuel' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'prerequis' => 'nullable|string',
            'debouches' => 'nullable|string',
            'langues' => 'nullable|string|max:100',
            'places_disponibles' => 'nullable|integer|min:0',
            'date_limite_inscription' => 'nullable|date',
            'est_active' => 'nullable|boolean'
        ]);
        
        // Créer la formation
        Formation::create($validated);
        
        // Redirection avec message de succès
        return redirect()->route('formations.index')
                         ->with('success', 'Formation créée avec succès !');
    }

    /**
     * Affiche le détail d'une formation.
     * 
     * @param int $id ID de la formation
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Récupérer la formation avec l'université associée
        $formation = Formation::with('universite')->findOrFail($id);
        
        return view('formations.show', compact('formation'));
    }
}