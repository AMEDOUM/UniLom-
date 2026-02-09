<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Enregistrer un nouvel avis.
     */
    public function store(Request $request, Universite $universite)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Vérifier si l'utilisateur a déjà donné un avis pour cette université
        $existingAvis = Avis::where('user_id', Auth::id())
                            ->where('universite_id', $universite->id)
                            ->first();

        if ($existingAvis) {
            return back()->with('error', 'Vous avez déjà donné votre avis sur cette université.');
        }

        Avis::create([
            'user_id' => Auth::id(),
            'universite_id' => $universite->id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Votre avis a été publié avec succès !');
    }

    /**
     * Supprimer un avis.
     */
    public function destroy(Avis $avis)
    {
        // Vérifier si l'utilisateur est l'auteur ou un admin
        if (Auth::id() !== $avis->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $avis->delete();

        return back()->with('success', 'Avis supprimé.');
    }
}
