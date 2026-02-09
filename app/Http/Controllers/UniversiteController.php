<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Universite;

/**
 * Contrôleur UniversiteController
 * 
 * Gère l'affichage des universités et leurs détails.
 * Permet aux visiteurs de consulter la liste des universités
 * et d'accéder aux informations détaillées de chacune.
 */
class UniversiteController extends Controller
{
    /**
     * Affiche la liste de toutes les universités.
     * 
     * Récupère et affiche toutes les universités disponibles sur la plateforme
     * avec leurs formations associées.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer les universités actives avec leurs formations
        $universites = Universite::where('est_active', true)
            ->whereHas('user') // Exclure les universités orphelines
            ->with('formations') // Charger les formations associées
            ->get();
        
        return view('universites.index', [
            'universites' => $universites
        ]);
    }
    
    /**
     * Affiche le détail d'une université spécifique.
     * 
     * Récupère et affiche toutes les informations sur une université
     * ainsi que ses formations associées.
     * 
     * @param Universite $universite L'université à afficher
     * @return \Illuminate\View\View
     */
    public function show(Universite $universite)
    {
        // Incrémenter le nombre de visites
        $universite->increment('visites');

        // Charger les formations associées
        $universite->load('formations');
        
        return view('universites.show', [
            'universite' => $universite
        ]);
    }

    /**
     * Affiche les statistiques de l'université connectée.
     */
    public function statistiques()
    {
        $universite = Universite::where('user_id', auth()->id())->firstOrFail();
        
        return view('dashboard.statistiques', [
            'universite' => $universite
        ]);
    }
}