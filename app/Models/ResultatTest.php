<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle ResultatTest
 * 
 * Représente le résultat d'un utilisateur après avoir complété un test d'orientation.
 * Stocke les réponses choisies, les scores par domaine, et les recommandations.
 */
class ResultatTest extends Model
{
    protected $fillable = ['user_id', 'test_id', 'reponses', 'scores', 'recommandations', 'date_completion'];
    
    /**
     * Casting des attributs :
     * - reponses : array JSON des réponses sélectionnées
     * - scores : array JSON des scores par domaine
     * - recommandations : array JSON des formations recommandées
     * - date_completion : datetime de fin du test
     */
    protected $casts = [
        'reponses' => 'array',
        'scores' => 'array',
        'recommandations' => 'array',
        'date_completion' => 'datetime'
    ];
    
    /**
     * Relation : Un résultat appartient à un utilisateur.
     * Clé étrangère : 'user_id'
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relation : Un résultat appartient à un test d'orientation.
     * Clé étrangère : 'test_id'
     * 
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(TestOrientation::class, 'test_id');
    }
}