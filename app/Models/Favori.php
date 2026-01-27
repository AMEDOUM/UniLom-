<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Favori
 * 
 * Représente la relation entre un utilisateur et une université ajoutée aux favoris.
 * Cette table pivot stocke les associations favori entre users et universites.
 */
class Favori extends Model
{
    protected $fillable = ['user_id', 'universite_id'];
    
    /**
     * Relation : Un favori appartient à un utilisateur.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relation : Un favori appartient à une université.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function universite()
    {
        return $this->belongsTo(Universite::class);
    }
}
