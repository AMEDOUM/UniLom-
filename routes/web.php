<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniversiteController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\TestOrientationController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActualiteController;
use App\Http\Middleware\AdminMiddleware;

/**
 * ========== ROUTES PUBLIQUES ==========
 */

/**
 * Page d'accueil
 */
Route::get('/', function () {
    return view('home');
})->name('home');

// Page politique de confidentialité
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

/**
 * Page de tableau de bord (redirige selon le rôle de l'utilisateur)
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * ========== ROUTES AUTHENTIFIÉES ==========
 * Routes nécessitant une connexion utilisateur
 */

Route::middleware('auth')->group(function () {
    /**
     * Routes de profil utilisateur
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Charger les routes d'authentification
require __DIR__.'/auth.php';

/**
 * ========== TABLEAUX DE BORD INTELLIGENTS ==========
 * Redirige vers le bon dashboard selon le rôle de l'utilisateur
 */

/**
 * Dashboard principal - Redirige selon le rôle
 */
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect('/login');
    }
    
    // Router selon le rôle de l'utilisateur
    switch ($user->role) {
        case 'etudiant':
            return view('dashboard.etudiant');
        case 'universite':
            return view('dashboard.universite');
        case 'admin':
            return view('admin.dashboard');
        default:
            return redirect('/');
    }
})->middleware(['auth'])->name('dashboard');

/**
 * Routes de test directes pour chaque rôle
 */
Route::get('/dashboard-etudiant', function () {
    return view('dashboard.etudiant');
})->middleware(['auth']);

Route::get('/dashboard-universite', function () {
    return view('dashboard.universite');
})->middleware(['auth']);

Route::get('/dashboard-admin', function () {
    return view('dashboard.admin');
})->middleware(['auth']);

/**
 * ========== ROUTES UNIVERSITÉS ==========
 * Routes publiques et authentifiées pour les universités
 */

/**
 * Liste de toutes les universités (publique)
 */
Route::get('/universites', [UniversiteController::class, 'index'])->name('universites');

/**
 * Détail d'une université spécifique (publique)
 */
Route::get('/universites/{universite}', [UniversiteController::class, 'show'])->name('universites.show');

/**
 * ========== ROUTES ACTUALITÉS ==========
 * Gestion des actualités publiées par les universités
 */

/**
 * Liste de toutes les actualités (publique)
 */
Route::get('/actualites', [ActualiteController::class, 'index'])->name('actualites.index');

/**
 * Détail d'une actualité spécifique (publique)
 */
Route::get('/actualites/{actualite}', [ActualiteController::class, 'show'])->name('actualites.show');

/**
 * Routes authentifiées pour créer/modifier/supprimer les actualités (réservé aux universités)
 */
Route::middleware(['auth'])->group(function () {
    /**
     * Formulaire de création d'une nouvelle actualité
     */
    Route::get('/actualites/create', [ActualiteController::class, 'create'])->name('actualites.create');
    
    /**
     * Enregistrer une nouvelle actualité
     */
    Route::post('/actualites', [ActualiteController::class, 'store'])->name('actualites.store');
    
    /**
     * Formulaire de modification d'une actualité
     */
    Route::get('/actualites/{actualite}/edit', [ActualiteController::class, 'edit'])->name('actualites.edit');
    
    /**
     * Mettre à jour une actualité
     */
    Route::patch('/actualites/{actualite}', [ActualiteController::class, 'update'])->name('actualites.update');
    Route::put('/actualites/{actualite}', [ActualiteController::class, 'update']);
    
    /**
     * Supprimer une actualité
     */
    Route::delete('/actualites/{actualite}', [ActualiteController::class, 'destroy'])->name('actualites.destroy');
});

/**
 * ========== ROUTES FAVORIS ==========
 * Gestion des universités favorites pour les étudiants
 */

Route::middleware(['auth'])->group(function () {
    /**
     * Ajouter/Retirer un favori (AJAX ou redirection)
     */
    Route::post('/favoris/toggle/{universite}', [FavoriController::class, 'toggle'])
         ->name('favoris.toggle');
    
    /**
     * Liste des universités favorites
     */
    Route::get('/mes-favoris', [FavoriController::class, 'index'])
         ->name('favoris.index');
});

/**
 * ========== ROUTES TEST D'ORIENTATION ==========
 * Routes pour le test d'orientation professionnelle
 */

/**
 * Page d'accueil du test (publique)
 */
Route::get('/test-orientation', [TestOrientationController::class, 'index'])
     ->name('test-orientation.index');

/**
 * Routes authentifiées pour le test
 */
Route::middleware(['auth'])->group(function () {
    /**
     * Affiche le formulaire du test
     */
    Route::get('/test-orientation/{test}', [TestOrientationController::class, 'show'])
         ->name('test-orientation.show');
    
    /**
     * Traite la soumission du test
     */
    Route::post('/test-orientation/{test}', [TestOrientationController::class, 'store'])
         ->name('test-orientation.store');
    
    /**
     * Affiche les résultats du test
     */
    Route::get('/test-orientation/resultat/{resultat}', [TestOrientationController::class, 'resultat'])
         ->name('test.resultat');
});

/**
 * ========== ROUTES FORMATIONS ==========
 * Gestion des formations pour les universités
 */

Route::middleware(['auth'])->group(function () {
    /**
     * Liste des formations de l'université connectée
     */
    Route::get('/universite/formations', [FormationController::class, 'index'])->name('formations.index');
    
    /**
     * Ressource formations (créer, modifier, supprimer)
     */
    Route::resource('formations', FormationController::class);
});

/**
 * ========== ROUTES ADMIN ==========
 * Toutes les routes d'administration avec vérification d'accès
 */

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    /**
     * Closure de vérification des droits admin
     * Vérifie que l'utilisateur a le rôle 'admin'
     */
    $adminCheck = function() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs');
        }
    };
    
    /**
     * Dashboard Admin
     * Affiche un aperçu des statistiques principales
     */
    Route::get('/dashboard', function() use ($adminCheck) {
        $adminCheck();
        $stats = [
            'users' => \App\Models\User::count(),
            'universites' => \App\Models\Universite::count(),
            'formations' => \App\Models\Formation::count(),
            'active_universites' => \App\Models\Universite::where('est_active', true)->count(),
        ];
        return view('admin.dashboard', $stats);
    })->name('dashboard');
    
    /**
     * ========== GESTION DES UNIVERSITÉS ==========
     */
    
    /**
     * Liste de toutes les universités (vue admin)
     */
    Route::get('/universites', function() use ($adminCheck) {
        $adminCheck();
        $universites = \App\Models\Universite::withCount('formations')->latest()->paginate(15); // 15 par page;
        return view('admin.universites.index', compact('universites'));
    })->name('universites.index');
    
    /**
     * Formulaire d'édition d'une université
     */
    Route::get('/universites/{id}/edit', function($id) use ($adminCheck) {
        $adminCheck();
        $universite = \App\Models\Universite::findOrFail($id);
        return view('admin.universites.edit', compact('universite'));
    })->name('universites.edit');
    
    /**
     * Mise à jour d'une université
     */
    Route::put('/universites/{id}', function(\Illuminate\Http\Request $request, $id) use ($adminCheck) {
        $adminCheck();
        // ... logique de mise à jour
    })->name('universites.update');
    
    /**
     * Basculer le statut d'une université (actif/inactif)
     */
    Route::put('/universites/{id}/toggle-status', function($id) use ($adminCheck) {
        $adminCheck();
        // ... logique toggle
    })->name('universites.toggle-status');
    
    /**
     * ========== GESTION DES FORMATIONS ==========
     */
    
    /**
     * Liste de toutes les formations (vue admin)
     */
    Route::get('/formations', function() use ($adminCheck) {
        $adminCheck();
        $formations = \App\Models\Formation::with('universite')->latest()->get();
        return view('admin.formations.index', compact('formations'));
    })->name('formations.index');
    
    /**
     * ========== GESTION DES UTILISATEURS ==========
     */
    
    /**
     * Liste de tous les utilisateurs
     */
    Route::get('/utilisateurs', function() use ($adminCheck) {
        $adminCheck();
        $users = \App\Models\User::latest()->get();
        return view('admin.utilisateurs.index', compact('users'));
    })->name('utilisateurs.index');
    
    /**
     * Afficher le formulaire d'édition d'un utilisateur
     */
    Route::get('/utilisateurs/{user}/edit', function(\App\Models\User $user) use ($adminCheck) {
        $adminCheck();
        return view('admin.utilisateurs.edit', compact('user'));
    })->name('utilisateurs.edit');
    
    /**
     * Mettre à jour un utilisateur
     */
    Route::patch('/utilisateurs/{user}', function(\Illuminate\Http\Request $request, \App\Models\User $user) use ($adminCheck) {
        $adminCheck();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:etudiant,universite,admin',
        ]);
        
        // Gérer la vérification email via checkbox
        if ($request->has('email_verified')) {
            $validated['email_verified_at'] = now();
        } else {
            $validated['email_verified_at'] = null;
        }
        
        // Gérer la validation du compte via checkbox
        $validated['est_valide'] = $request->has('est_valide') ? true : false;
        
        $user->update($validated);
        
        return back()->with('success', 'Utilisateur mis à jour avec succès !');
    })->name('utilisateurs.update');
    
    /**
     * Supprimer un utilisateur
     */
    Route::delete('/utilisateurs/{user}', function(\App\Models\User $user) use ($adminCheck) {
        $adminCheck();
        
        if ($user->role === 'admin' && auth()->user()->id === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte admin !');
        }
        
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès !');
    })->name('utilisateurs.destroy');
    
    /**
     * ========== STATISTIQUES ==========
     * Affiche les statistiques détaillées de la plateforme
     */
    
    Route::get('/statistiques', function() use ($adminCheck) {
        $adminCheck();

        // Calcul des indicateurs principaux
        $totalUsers = \App\Models\User::count();
        $totalUniversites = \App\Models\Universite::count();
        $totalFormations = \App\Models\Formation::count();

        // Répartition par rôle
        $etudiants = \App\Models\User::where('role', 'etudiant')->count();
        $universitesUsers = \App\Models\User::where('role', 'universite')->count();
        $admins = \App\Models\User::where('role', 'admin')->count();

        // Statut des universités
        $activeUniversites = \App\Models\Universite::where('est_active', true)->count();
        $publicUniversites = \App\Models\Universite::where('est_public', true)->count();

        // Formations par domaine
        $formationsParDomaine = \App\Models\Formation::select('domaine', \DB::raw('count(*) as total'))
            ->groupBy('domaine')
            ->get();

        return view('admin.statistique', compact(
            'totalUsers',
            'totalUniversites',
            'totalFormations',
            'etudiants',
            'universitesUsers',
            'admins',
            'activeUniversites',
            'publicUniversites',
            'formationsParDomaine'
        ));
    })->name('statistique');
    
    /**
     * ========== PARAMÈTRES SYSTÈME ==========
     * Configuration générale de la plateforme
     */
    
    Route::get('/parametres', function() use ($adminCheck) {
        $adminCheck();
        return view('admin.parametres');
    })->name('parametres');
    
    /**
     * ========== JOURNAUX D'ACTIVITÉ ==========
     * Consultation des logs et activités
     */
    
    Route::get('/logs', function() use ($adminCheck) {
        $adminCheck();
        return view('admin.logs');
    })->name('logs');
});

// Dans routes/web.php (dans le groupe admin)
// Validation des universités
Route::prefix('universites/{id}')->group(function () {
    // Approuver une université
    Route::post('/approuver', function($id) {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $universite = \App\Models\Universite::findOrFail($id);
        
        $universite->update([
            'statut_validation' => 'approuvee',
            'validee_le' => now(),
            'validee_par' => auth()->id(),
            'est_active' => true // Active automatiquement
        ]);
        
        // Aussi marquer l'utilisateur comme validé
        if ($universite->user) {
            $universite->user->update(['est_valide' => true]);
        }
        
        // TODO: Envoyer une notification à l'université
        
        return back()->with('success', 'Université approuvée avec succès !');
    })->name('admin.universites.approuver');
    
    // Rejeter une université (avec raison)
    Route::post('/rejeter', function(\Illuminate\Http\Request $request, $id) {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $request->validate([
            'raison_rejet' => 'required|string|min:10|max:500'
        ]);
        
        $universite = \App\Models\Universite::findOrFail($id);
        
        $universite->update([
            'statut_validation' => 'rejetee',
            'raison_rejet' => $request->raison_rejet,
            'date_limite_correction' => now()->addDays(7), // 7 jours pour corriger
            'est_active' => false // Désactive
        ]);
        
        // Aussi marquer l'utilisateur comme non validé
        if ($universite->user) {
            $universite->user->update(['est_valide' => false]);
        }
        
        // TODO: Envoyer une notification avec la raison
        
        return back()->with('success', 'Université rejetée. Notification envoyée.');
    })->name('admin.universites.rejeter');
    
    // Remettre en attente
    Route::post('/remettre-en-attente', function($id) {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $universite = \App\Models\Universite::findOrFail($id);
        
        $universite->update([
            'statut_validation' => 'en_attente',
            'raison_rejet' => null,
            'date_limite_correction' => null
        ]);
        
        return back()->with('success', 'Université remise en attente.');
    })->name('admin.universites.remettre-en-attente');
});