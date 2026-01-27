<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur FavoriController
 * 
 * Gère les favoris des utilisateurs (étudiants).
 * Permet d'ajouter/retirer une université des favoris
 * et de consulter la liste des universités favorites.
 */
class FavoriController extends Controller
{
    /**
     * Ajoute ou retire une université des favoris de l'utilisateur.
     * 
     * Bascule l'état d'une université en favori.
     * Si elle est déjà en favori, elle est retirée. Sinon, elle est ajoutée.
     * Supporte les requêtes AJAX et les redirections classiques.
     * 
     * @param int $universiteId ID de l'université
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function toggle($universiteId)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Vérifier que l'université existe
        $universite = Universite::findOrFail($universiteId);
        
        // Chercher si l'université est déjà en favoris
        $favori = Favori::where('user_id', $user->id)
                        ->where('universite_id', $universiteId)
                        ->first();
        
        if ($favori) {
            // Retirer des favoris
            $favori->delete();
            $message = "{$universite->nom} retirée de vos favoris";
            $action = 'retire';
        } else {
            // Ajouter aux favoris
            Favori::create([
                'user_id' => $user->id,
                'universite_id' => $universiteId
            ]);
            $message = "{$universite->nom} ajoutée à vos favoris";
            $action = 'ajoute';
        }
        
        // Répondre différemment selon si c'est une requête AJAX ou non
        if (request()->ajax()) {
            // Réponse JSON pour les requêtes AJAX
            return response()->json([
                'action' => $action,
                'message' => $message,
                'count' => $user->favoris()->count()
            ]);
        }
        
        // Redirection classique avec message flash
        return back()->with('success', $message);
    }
    
    /**
     * Affiche la liste de toutes les universités favorites de l'utilisateur.
     * 
     * Récupère et affiche les universités que l'utilisateur a ajoutées à ses favoris,
     * avec pagination (10 par page).
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        
        // Récupérer ses universités favorites avec pagination
        $favoris = $user->universitesFavorites()->paginate(10);
        
        return view('favoris.index', compact('favoris'));
    }
}