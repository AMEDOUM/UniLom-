<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder pour créer un utilisateur admin par défaut
 */
class AdminSeeder extends Seeder
{
    /**
     * Crée un utilisateur administrateur pour tester
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@unilome.tg'],
            [
                'name' => 'Administrateur',
                'nom' => 'Administrateur UniLomé',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'est_valide' => true,
            ]
        );

        // Créer aussi un utilisateur étudiant de test
        User::firstOrCreate(
            ['email' => 'etudiant@example.com'],
            [
                'name' => 'Étudiant Test',
                'nom' => 'Étudiant Test',
                'password' => Hash::make('password123'),
                'role' => 'etudiant',
                'date_naissance' => '2004-03-21',
                'sexe' => 'M',
                'email_verified_at' => now(),
                'est_valide' => true,
            ]
        );

        // Créer aussi une université de test
        User::firstOrCreate(
            ['email' => 'universite@unilome.tg'],
            [
                'name' => 'Université Test',
                'nom_universite' => 'Université de Lomé',
                'password' => Hash::make('password123'),
                'role' => 'universite',
                'telephone' => '+228 XXXXXXXX',
                'localisation' => 'Lomé',
                'email_verified_at' => now(),
                'est_valide' => true,
            ]
        );
    }
}
