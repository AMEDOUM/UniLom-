<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Formation
 * 
 * Représente une formation proposée par une université.
 * Stocke les informations sur la formation, son coût, sa durée, 
 * les prérequis et les débouchés professionnels.
 */
class Formation extends Model
{
    use HasFactory;
    
    /**
     * Les champs remplissables via mass assignment.
     * 
     * @var array
     */
    protected $fillable = [
        'universite_id',      // ID de l'université proposant la formation
        'nom',                // Nom de la formation (ex: Licence Informatique)
        'niveau',             // Niveau d'études (Licence, Master, etc.)
        'domaine',            // Domaine d'études (Sciences, Droit, Commerce, etc.)
        'duree_mois',         // Durée en mois
        'frais_inscription',  // Frais d'inscription unique
        'frais_scolarite_annuel', // Frais de scolarité annuels
        'description',        // Description détaillée de la formation
        'prerequis',          // Prérequis nécessaires
        'debouches',          // Débouchés professionnels
        'langues',            // Langues enseignées
        'est_active',         // Formation disponible ou non
        'places_disponibles', // Nombre de places disponibles
        'date_limite_inscription' // Date limite pour s'inscrire
    ];
    
    /**
     * Valeurs par défaut des attributs.
     * 
     * @var array
     */
    protected $attributes = [
        'est_active' => true,
        'duree_mois' => 36,          // 3 ans par défaut
        'places_disponibles' => 50,  // 50 places par défaut
    ];
    
    /**
     * Relation : Une formation appartient à une université.
     * Clé étrangère : 'universite_id'
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function universite()
    {
        return $this->belongsTo(Universite::class, 'universite_id');
    }

    /**
     * Accesseur pour la durée formatée.
     * Convertit le nombre de mois en années si multiple de 12.
     */
    public function getDureeFormateeAttribute()
    {
        if (!$this->duree_mois) {
            return 'Non défini';
        }

        if ($this->duree_mois % 12 === 0) {
            $annees = $this->duree_mois / 12;
            return $annees . ' an' . ($annees > 1 ? 's' : '');
        }

        return $this->duree_mois . ' mois';
    }
}