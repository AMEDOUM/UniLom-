<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Affiche une vue différente selon le rôle
        if ($user->role === 'etudiant') {
            return view('profile.etudiant-edit', [
                'user' => $user,
            ]);
        } elseif ($user->role === 'universite') {
            return view('profile.universite-edit', [
                'user' => $user,
            ]);
        }
        
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        
        // Sync avec le modèle Universite si c'est une université
        if ($user->role === 'universite') {
            $universite = \App\Models\Universite::where('user_id', $user->id)->first();
            
            if ($universite) {
                \Illuminate\Support\Facades\Log::info('Profile Update: Syncing Universite ID ' . $universite->id);
                $universite->update([
                    'nom' => $request->nom_universite ?? $user->nom_universite,
                    'email' => $request->email ?? $user->email,
                    'telephone' => $request->telephone ?? $user->telephone,
                    'ville' => $request->localisation ?? $user->localisation, 
                    'adresse' => $request->localisation ?? $user->localisation,
                    'description' => $request->description ?? $user->description,
                    'vision' => $request->vision ?? $user->vision,
                    'site_web' => $request->site_web ?? $user->site_web,
                ]);
                \Illuminate\Support\Facades\Log::info('Profile Update: Universite updated!');
            } else {
                \Illuminate\Support\Facades\Log::warning('Profile Update: No Universite found for user ' . $user->id);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
