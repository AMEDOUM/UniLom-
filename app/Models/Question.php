<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle Question
 * 
 * Représente une question dans un test d'orientation.
 * Chaque question appartient à un test et peut avoir plusieurs réponses possibles.
 */
class Question extends Model
{
    protected $fillable = ['test_id', 'texte', 'categorie', 'ordre'];
    
    /**
     * Relation : Une question appartient à un test d'orientation.
     * Clé étrangère : 'test_id'
     * 
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(TestOrientation::class, 'test_id');
    }
    
    /**
     * Relation : Une question a plusieurs réponses possibles.
     * Clé étrangère : 'question_id' dans la table reponses
     * 
     * @return HasMany
     */
    public function reponses(): HasMany
    {
        return $this->hasMany(Reponse::class, 'question_id');
    }
}