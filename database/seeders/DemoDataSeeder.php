<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Créer des universités de démonstration
    $universites = [
        [
            'nom' => 'Université de Lomé',
            'sigle' => 'UL',
            'description' => 'La principale université publique du Togo, offrant une large gamme de formations dans divers domaines académiques et professionnels.',
            'ville' => 'Lomé',
            'pays' => 'Togo',
            'adresse' => 'Boulevard du 13 Janvier',
            'email' => 'contact@ul.tg',
            'telephone' => '+228 22 21 20 19',
            'site_web' => 'https://www.ul.tg',
            'est_public' => true,
            'nombre_etudiants' => 18500,
            'taux_reussite' => 78.5,
        ],
        [
            'nom' => 'Université de Kara',
            'sigle' => 'UK',
            'description' => 'Deuxième université publique du Togo, spécialisée dans les sciences, technologies et formations professionnelles.',
            'ville' => 'Kara',
            'pays' => 'Togo',
            'adresse' => 'Route de Kpalimé',
            'email' => 'info@uk.tg',
            'telephone' => '+228 27 70 10 00',
            'site_web' => 'https://www.uk.tg',
            'est_public' => true,
            'nombre_etudiants' => 9200,
            'taux_reussite' => 82.3,
        ],
        [
            'nom' => 'Université Africaine de Technologie et de Management',
            'sigle' => 'UATM',
            'description' => 'Établissement privé d\'excellence spécialisé dans les formations technologiques et managériales.',
            'ville' => 'Lomé',
            'pays' => 'Togo',
            'adresse' => 'Rue des Écoles',
            'email' => 'admissions@uatm.tg',
            'telephone' => '+228 22 21 45 67',
            'site_web' => 'https://www.uatm.tg',
            'est_public' => false,
            'nombre_etudiants' => 3500,
            'taux_reussite' => 89.2,
        ],
    ];
    
    foreach ($universites as $data) {
        \App\Models\Universite::create($data);
    }
    
    // Créer quelques utilisateurs de démonstration
    // ⭐⭐ CORRECTION : Ajouter 'name' en plus de 'nom' ⭐⭐
    $users = [
        [
            'name' => 'Étudiant Test',  // ⬅️ AJOUTEZ CETTE LIGNE
            'nom' => 'Étudiant Test', 
            'email' => 'etudiant@test.tg', 
            'role' => 'etudiant', 
            'password' => bcrypt('password')
        ],
        [
            'name' => 'Université Test',  // ⬅️ AJOUTEZ CETTE LIGNE
            'nom' => 'Université Test', 
            'email' => 'universite@test.tg', 
            'role' => 'universite', 
            'password' => bcrypt('password'), 
            'nom_universite' => 'Uni Test',
            'est_valide' => true  // Université validée
        ],
    ];
    
    foreach ($users as $data) {
        \App\Models\User::create($data);
    }
    
    // Créer quelques favoris
    \App\Models\Favori::create(['user_id' => 1, 'universite_id' => 1]);
    \App\Models\Favori::create(['user_id' => 1, 'universite_id' => 2]);
    
    $this->command->info('✅ Données de démonstration créées !');
    $this->command->info('👤 Connectez-vous avec: etudiant@test.tg / password');
    $this->command->info('🏛️ Université: universite@test.tg / password');
}
}

