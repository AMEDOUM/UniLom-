<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Universite;
use Illuminate\Http\Request;

class ActualiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actualites = Actualite::with('universite')
            ->orderBy('date_publication', 'desc')
            ->paginate(15);

        return view('actualites.index', compact('actualites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Actualite::class);

        $universite = Universite::where('user_id', auth()->id())->first();
        if (!$universite || !$universite->est_validee) {
            return redirect()->route('dashboard.universite')->with('error', 'Votre compte doit être validé pour créer des actualités.');
        }

        return view('actualites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Actualite::class);
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_publication' => 'nullable|date',
        ]);

        $universite = Universite::where('user_id', auth()->id())->first();
        if (!$universite || !$universite->est_validee) {
            return redirect()->route('dashboard.universite')->with('error', 'Votre compte doit être validé pour publier des actualités.');
        }

        $validated['universite_id'] = $universite->id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('actualites', 'public');
        }

        if (!$validated['date_publication']) {
            $validated['date_publication'] = now();
        }

        Actualite::create($validated);

        return redirect()->route('dashboard.universite')->with('success', 'Actualité créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Actualite $actualite)
    {
        return view('actualites.show', compact('actualite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actualite $actualite)
    {
        $this->authorize('update', $actualite);

        $universite = Universite::where('user_id', auth()->id())->first();
        if (!$universite || !$universite->est_validee) {
            return redirect()->route('dashboard.universite')->with('error', 'Votre compte doit être validé pour modifier des actualités.');
        }

        return view('actualites.edit', compact('actualite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actualite $actualite)
    {
        $this->authorize('update', $actualite);

        $universite = Universite::where('user_id', auth()->id())->first();
        if (!$universite || !$universite->est_validee) {
            return redirect()->route('dashboard.universite')->with('error', 'Votre compte doit être validé pour modifier des actualités.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_publication' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($actualite->image) {
                \Storage::disk('public')->delete($actualite->image);
            }
            $validated['image'] = $request->file('image')->store('actualites', 'public');
        }

        $actualite->update($validated);

        return redirect()->route('dashboard.universite')->with('success', 'Actualité mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actualite $actualite)
    {
        $this->authorize('delete', $actualite);

        $universite = Universite::where('user_id', auth()->id())->first();
        if (!$universite || !$universite->est_validee) {
            return redirect()->route('dashboard.universite')->with('error', 'Votre compte doit être validé pour supprimer des actualités.');
        }

        if ($actualite->image) {
            \Storage::disk('public')->delete($actualite->image);
        }

        $actualite->delete();

        return redirect()->route('dashboard.universite')->with('success', 'Actualité supprimée avec succès.');
    }
}
