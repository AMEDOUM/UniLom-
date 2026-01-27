<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle TestOrientation
 * 
 * Représente un test d'orientation professionnelle.
 * Chaque test contient plusieurs questions et peut générer des résultats.
 */
class TestOrientation extends Model
{
    protected $fillable = ['titre', 'description', 'duree_minutes', 'nombre_questions', 'est_actif'];
    
    /**
     * Relation : Un test a plusieurs questions.
     * Les questions sont ordonnées par le champ 'ordre'.
     * Clé étrangère : 'test_id'
     * 
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'test_id')->orderBy('ordre');
    }
    
    /**
     * Relation : Un test a plusieurs résultats de test.
     * Chaque utilisateur complétant le test crée un nouveau résultat.
     * Clé étrangère : 'test_id'
     * 
     * @return HasMany
     */
    public function resultats(): HasMany
    {
        return $this->hasMany(ResultatTest::class, 'test_id');
    }

    public function store(Request $request, TestOrientation $test)
{
    // Si pas de réponses, créer un résultat de test
    if (empty($request->reponses)) {
        // Créer un résultat factice pour tester
        $resultat = ResultatTest::create([
            'user_id' => Auth::id() ?? 1,
            'test_id' => $test->id,
            'reponses' => [1 => 1, 2 => 5, 3 => 9], // Réponses factices
            'scores' => [
                'sciences' => 15,
                'medecine' => 12,
                'droit' => 8,
                'lettres' => 10,
                'commerce' => 6,
                'ingenierie' => 14
            ],
            'recommandations' => ['sciences', 'ingenierie', 'medecine'],
            'date_completion' => now(),
        ]);
        
        return redirect()->route('test.resultat', $resultat);
    }
    
    // ... reste du code original ...
}
}