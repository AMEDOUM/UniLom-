<?php

namespace App\Http\Controllers;

use App\Models\TestOrientation;
use App\Models\ResultatTest;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur TestOrientationController
 * 
 * Gère le test d'orientation professionnelle.
 * Permet aux utilisateurs de passer le test et de recevoir
 * des recommandations de formations basées sur leurs réponses.
 */
class TestOrientationController extends Controller
{
    /**
     * Affiche la page d'accueil du test d'orientation.
     * 
     * Récupère le test actif et vérifie si l'utilisateur l'a déjà passé.
     * Si aucun test n'existe, en crée un par défaut.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer le test actif
        $test = TestOrientation::where('est_actif', true)->first();
        
        if (!$test) {
            // Créer un test par défaut si aucun n'existe
            $test = $this->creerTestParDefaut();
        }
        
        // Vérifier si l'utilisateur connecté a déjà passé le test
        $dejaPasse = Auth::check() 
            ? ResultatTest::where('user_id', Auth::id())
                         ->where('test_id', $test->id)
                         ->exists()
            : false;
        
        return view('test-orientation.index', compact('test', 'dejaPasse'));
    }
    
    /**
     * Affiche le formulaire de test avec toutes les questions.
     * 
     * Vérifie d'abord si l'utilisateur a déjà complété ce test.
     * Si oui, redirige vers son résultat précédent.
     * 
     * @param \App\Models\TestOrientation $test
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(TestOrientation $test)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return back()->with('error', 'Vous devez être connecté pour passer le test.');
        }
        
        // Vérifier si l'utilisateur a déjà passé le test
        $resultat = ResultatTest::where('user_id', Auth::id())
                               ->where('test_id', $test->id)
                               ->first();
        
        // Si le test a été passé, rediriger vers le résultat
        if ($resultat) {
            return redirect()->route('test.resultat', $resultat)
                           ->with('info', 'Vous avez déjà complété ce test. Voici vos résultats.');
        }
        
        // Récupérer toutes les questions avec leurs réponses, ordonnées par ordre
        $questions = $test->questions()->with('reponses')->orderBy('ordre')->get();
        
        return view('test-orientation.show', compact('test', 'questions'));
    }
    
    /**
     * Traite la soumission du test et génère les résultats.
     * 
     * Valide les réponses, calcule les scores par domaine,
     * génère les recommandations et sauvegarde le résultat.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TestOrientation $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, TestOrientation $test)
    {
        // Récupérer toutes les questions du test
        $questions = $test->questions()->get();
        
        // Valider que toutes les réponses existent et que toutes les questions ont une réponse
        $rules = [
            'reponses' => 'required|array|size:' . $questions->count(),
            'reponses.*' => 'required|exists:reponses,id'
        ];
        
        $request->validate($rules, [
            'reponses.required' => 'Veuillez répondre à toutes les questions',
            'reponses.size' => 'Vous devez répondre à toutes les ' . $questions->count() . ' questions',
            'reponses.*.required' => 'Cette question ne doit pas être vide',
            'reponses.*.exists' => 'Réponse invalide',
        ]);
        
        // Calculer les scores pour chaque domaine
        $scores = $this->calculerScores($request->reponses);
        
        // Générer les formations recommandées basées sur les scores
        $recommandations = $this->genererRecommandations($scores);
        
        // Sauvegarder le résultat du test
        $resultat = ResultatTest::create([
            'user_id' => Auth::id(),
            'test_id' => $test->id,
            'reponses' => $request->reponses,
            'scores' => $scores,
            'recommandations' => $recommandations,
            'date_completion' => now(),
        ]);
        
        return redirect()->route('test.resultat', $resultat);
    }
    
    /**
     * Affiche le résultat du test d'orientation.
     * 
     * Vérifie que l'utilisateur est autorisé à voir ce résultat.
     * 
     * @param \App\Models\ResultatTest $resultat
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function resultat(ResultatTest $resultat)
    {
        // Vérifier que l'utilisateur ne voit que ses propres résultats
        if (Auth::id() !== $resultat->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à voir ce résultat');
        }
        
        return view('test-orientation.resultat', compact('resultat'));
    }
    
    /**
     * Calcule les scores pour chaque domaine basé sur les réponses sélectionnées.
     * 
     * Accumule les points associés à chaque domaine
     * à travers toutes les réponses choisies.
     * 
     * @param array $reponsesIds IDs des réponses sélectionnées
     * @return array Scores par domaine
     */
    private function calculerScores($reponsesIds)
    {
        // Initialiser les scores à zéro pour chaque domaine
        $scores = [
            'sciences' => 0,
            'droit' => 0,
            'commerce' => 0,
            'lettres' => 0,
            'medecine' => 0,
            'ingenierie' => 0,
        ];
        
        // Récupérer toutes les réponses sélectionnées
        $reponses = Reponse::whereIn('id', $reponsesIds)->get();
        
        // Ajouter les points de chaque réponse aux domaines concernés
        foreach ($reponses as $reponse) {
            $points = json_decode($reponse->points, true);
            foreach ($points as $domaine => $valeur) {
                if (isset($scores[$domaine])) {
                    $scores[$domaine] += $valeur;
                }
            }
        }
        
        return $scores;
    }
    
    /**
     * Génère les formations recommandées basées sur les scores.
     * 
     * Sélectionne les 3 domaines avec les meilleurs scores
     * et retourne les domaines recommandés.
     * 
     * @param array $scores Scores par domaine
     * @return array Top 3 domaines recommandés
     */
    private function genererRecommandations($scores)
    {
        // Trier les scores en ordre décroissant
        arsort($scores);
        
        // Prendre les 3 domaines avec les meilleurs scores
        $topDomaines = array_slice(array_keys($scores), 0, 3, true);
        
        // Retourner les domaines recommandés
        return $topDomaines;
    }
    
    /**
     * Crée un test d'orientation par défaut avec questions et réponses.
     * 
     * Utilisé lors de la première création si aucun test n'existe.
     * 
     * @return \App\Models\TestOrientation Le test créé
     */
    private function creerTestParDefaut()
    {
        // Créer le test
        $test = TestOrientation::create([
            'titre' => 'Test d\'orientation universitaire',
            'description' => 'Découvrez les formations qui vous correspondent le mieux',
            'duree_minutes' => 10,
            'nombre_questions' => 10,
            'est_actif' => true,
        ]);
        
        // Définir les questions et réponses par défaut
        $questions = [
            [
                'texte' => 'Quelles activités préférez-vous ?',
                'categorie' => 'interets',
                'reponses' => [
                    ['texte' => 'Lire et écrire', 'points' => ['lettres' => 3, 'droit' => 2]],
                    ['texte' => 'Résoudre des problèmes mathématiques', 'points' => ['sciences' => 3, 'ingenierie' => 2]],
                    ['texte' => 'Aider les autres', 'points' => ['medecine' => 3, 'lettres' => 1]],
                    ['texte' => 'Organiser et gérer', 'points' => ['commerce' => 3, 'droit' => 1]],
                ]
            ],
            // Ajouter plus de questions...
        ];
        
        // Créer les questions et leurs réponses
        foreach ($questions as $index => $questionData) {
            $question = Question::create([
                'test_id' => $test->id,
                'texte' => $questionData['texte'],
                'categorie' => $questionData['categorie'],
                'ordre' => $index + 1,
            ]);
            
            // Créer chaque réponse possible
            foreach ($questionData['reponses'] as $ordre => $reponseData) {
                Reponse::create([
                    'question_id' => $question->id,
                    'texte' => $reponseData['texte'],
                    'points' => json_encode($reponseData['points']),
                    'ordre' => $ordre + 1,
                ]);
            }
        }
        
        return $test;
    }
}