<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modèle User
 * 
 * Représente un utilisateur de la plateforme UniLomé.
 * Les utilisateurs peuvent avoir différents rôles :
 * - 'etudiant' : étudiants cherchant des formations
 * - 'universite' : universités proposant des formations
 * - 'admin' : administrateurs gérant la plateforme
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
         'name',
    'nom',
    'email',
    'password',
    'role',
    'photo',
    'date_naissance',
    'sexe',
    'nom_universite',
    'logo',
    'description',
    'localisation',
    'vision',
    'telephone',
    'est_valide',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accesseur pour 'name' qui retourne 'nom' si 'name' est vide.
     * Assure la compatibilité entre les attributs 'name' et 'nom'.
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->nom ?? 'Utilisateur';
    }

    /**
     * Mutateur pour 'name' qui synchronise avec 'nom'.
     * Quand on définit le nom, on met à jour les deux attributs.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['nom'] = $value;
    }

    /**
     * Relation : Un utilisateur peut avoir plusieurs favoris.
     * Retourne tous les favoris (relationship avec Favori).
     */
    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    /**
     * Relation Many-to-Many : Récupère les universités favorites de l'utilisateur.
     * Utilise la table de pivot 'favoris'.
     */
    public function universitesFavorites()
    {
        return $this->belongsToMany(Universite::class, 'favoris')
                    ->withTimestamps();
    }

    /**
     * Vérifie si l'utilisateur a ajouté une université à ses favoris.
     * 
     * @param int $universiteId ID de l'université
     * @return bool True si l'université est en favoris, false sinon
     */
    public function aFavori($universiteId)
    {
        return $this->favoris()->where('universite_id', $universiteId)->exists();
    }

    /**
     * Vérifie si l'utilisateur est administrateur.
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur représente une université.
     * 
     * @return bool
     */
    public function isUniversite()
    {
        return $this->role === 'universite';
    }

    /**
     * Vérifie si l'utilisateur est un étudiant.
     * 
     * @return bool
     */
    public function isEtudiant()
    {
        return $this->role === 'etudiant';
    }
}