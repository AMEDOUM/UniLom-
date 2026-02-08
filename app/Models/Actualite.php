<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    protected $fillable = [
        'universite_id',
        'titre',
        'contenu',
        'description',
        'image',
        'date_publication',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    /**
     * Relation: Actualite appartient à une Universite
     */
    public function universite()
    {
        return $this->belongsTo(Universite::class);
    }
}

