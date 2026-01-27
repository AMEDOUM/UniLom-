<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle Reponse
 * 
 * Représente une réponse possible à une question du test d'orientation.
 * Stocke le texte de la réponse, les points associés par domaine,
 * et l'ordre d'affichage.
 */
class Reponse extends Model
{
    protected $fillable = ['question_id', 'texte', 'points', 'ordre'];
    
    /** Les points sont stockés comme JSON et castés en array */
    protected $casts = ['points' => 'array'];
    
    /**
     * Relation : Une réponse appartient à une question.
     * Clé étrangère : 'question_id'
     * 
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Boot du modèle - Validation au moment de la création.
     * Vérifie que question_id est fourni lors de la création.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Vérifie que la question_id est obligatoire
        static::creating(function ($reponse) {
            if (!$reponse->question_id) {
                throw new \Exception('question_id est requis pour créer une réponse');
            }
        });
    }
}