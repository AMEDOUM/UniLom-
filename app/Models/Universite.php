<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Universite
 * 
 * Représente une université de la plateforme.
 * Stocke les informations générales, les contacts, et les détails académiques.
 * Peut avoir plusieurs formations et utilisateurs associés.
 */
class Universite extends Model
{
    use HasFactory;
    
    /**
     * Les champs remplissables via mass assignment.
     * 
     * @var array
     */
    protected $fillable = [
        'nom',              // Nom complet de l'université
        'sigle',            // Sigle ou acronyme (ex: UFPL)
        'description',      // Description de l'université
        'logo',             // URL du logo
        'site_web',         // URL du site web
        'email',            // Email de contact
        'telephone',        // Téléphone de contact
        'adresse',          // Adresse physique
        'ville',            // Ville
        'pays',             // Pays
        'domaines',         // Domaines d'études (JSON)
        'nombre_etudiants', // Nombre d'étudiants estimé
        'taux_reussite',    // Taux de réussite aux examens
        'facebook',         // URL Facebook
        'twitter',          // URL Twitter
        'linkedin',         // URL LinkedIn
        'est_public',       // Universités publique ou privée
        'est_active',       // Université active ou inactive
        'user_id',          // ID de l'administrateur de l'université
        'statut_validation',
        'validee_par',
        'raison_rejet',
        'date_limite_correction'
    ];

    /**
     * Valeurs par défaut des attributs.
     * 
     * @var array
     */
    protected $attributes = [
        'est_public' => true,
        'est_active' => true,
        'pays' => 'Togo',      // Pays par défaut
        'statut_validation' => 'en_attente' // Statut par défaut
    ];

    /**
     * Relation : Une université a plusieurs formations.
     * Clé étrangère : 'universite_id' dans la table formations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formations()
    {
        return $this->hasMany(Formation::class, 'universite_id');
    }

    /**
     * Relation : Une université appartient à un utilisateur admin.
     * Clé étrangère : 'user_id'
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation : Validateur de l'université.
     * Clé étrangère : 'validee_par'
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validateur()
    {
        return $this->belongsTo(User::class, 'validee_par');
    }

    // ==================== SCOPES ====================

    /**
     * Scope : Universités en attente de validation
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut_validation', 'en_attente');
    }

    /**
     * Scope : Universités approuvées
     */
    public function scopeApprouvees($query)
    {
        return $query->where('statut_validation', 'approuvee');
    }

    /**
     * Scope : Universités rejetées
     */
    public function scopeRejetees($query)
    {
        return $query->where('statut_validation', 'rejetee');
    }

    /**
     * Scope : Universités actives
     */
    public function scopeActives($query)
    {
        return $query->where('est_active', true);
    }

    /**
     * Scope : Universités publiques
     */
    public function scopePubliques($query)
    {
        return $query->where('est_public', true);
    }

    // ==================== ACCESSORS ====================

    /**
     * Accesseur : Vérifie si l'université est validée
     */
    public function getEstValideeAttribute()
    {
        return $this->statut_validation === 'approuvee';
    }

    /**
     * Accesseur : Vérifie si l'université est en attente
     */
    public function getEstEnAttenteAttribute()
    {
        return $this->statut_validation === 'en_attente';
    }

    /**
     * Accesseur : Vérifie si l'université est rejetée
     */
    public function getEstRejeteeAttribute()
    {
        return $this->statut_validation === 'rejetee';
    }

    /**
     * Accesseur : Formate les domaines d'études
     */
    public function getDomainesListeAttribute()
    {
        if (!$this->domaines) {
            return [];
        }
        
        return is_array($this->domaines) 
            ? $this->domaines 
            : json_decode($this->domaines, true);
    }

    /**
     * Accesseur : Nom complet avec sigle
     */
    public function getNomCompletAttribute()
    {
        if ($this->sigle) {
            return $this->nom . ' (' . $this->sigle . ')';
        }
        
        return $this->nom;
    }

    // ==================== MUTATORS ====================

    /**
     * Mutateur : Assure que les domaines sont stockés en JSON
     */
    public function setDomainesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['domaines'] = json_encode($value);
        } else {
            $this->attributes['domaines'] = $value;
        }
    }

    // ==================== MÉTHODES UTILES ====================

    /**
     * Vérifie si l'université peut être affichée publiquement
     */
    public function estVisible()
    {
        return $this->est_active && $this->estValidee;
    }

    /**
     * Obtenir le nombre de formations actives
     */
    public function formationsActivesCount()
    {
        return $this->formations()->where('est_active', true)->count();
    }

    /**
     * Marquer l'université comme approuvée
     */
    public function approuver($validateurId = null)
    {
        $this->update([
            'statut_validation' => 'approuvee',
            'validee_le' => now(),
            'validee_par' => $validateurId ?? auth()->id(),
            'est_active' => true
        ]);
    }

    /**
     * Marquer l'université comme rejetée
     */
    public function rejeter($raison, $validateurId = null)
    {
        $this->update([
            'statut_validation' => 'rejetee',
            'raison_rejet' => $raison,
            'date_limite_correction' => now()->addDays(7),
            'est_active' => false
        ]);
    }

    /**
     * Remettre l'université en attente
     */
    public function remettreEnAttente()
    {
        $this->update([
            'statut_validation' => 'en_attente',
            'raison_rejet' => null,
            'date_limite_correction' => null
        ]);
    }
}