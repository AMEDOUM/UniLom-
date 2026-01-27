<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitesFormationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer plusieurs universités
    $universites = [
        [
            'nom' => 'Université de Lomé',
            'description' => 'Université publique de référence',
            'email' => 'contact@ul.tg',
            'adresse' => 'Campus Nord, BP 1515',
            'sigle' => 'UL',
            'ville' => 'Lomé',
            'pays' => 'Togo'
        ],
        [
            'nom' => 'Université de Kara',
            'description' => 'Université publique du nord du Togo',
            'email' => 'contact@uk.tg',
            'adresse' => 'BP 43, Kara',
            'sigle' => 'UK',
            'ville' => 'Kara',
            'pays' => 'Togo'
        ],
    ];
    
    foreach ($universites as $data) {
        $universite = Universite::create($data);
        
        // Créer des formations pour chaque université
        Formation::create([
            'universite_id' => $universite->id,
            'nom' => 'Licence en Informatique',
            'domaine' => 'Informatique',
            'niveau' => 'Licence',
            'description' => 'Formation en développement informatique'
        ]);
        
        Formation::create([
            'universite_id' => $universite->id,
            'nom' => 'Master en Génie Civil',
            'domaine' => 'Génie Civil',
            'niveau' => 'Master',
            'description' => 'Formation en génie civil et construction'
        ]);
    }
    
    echo "✅ Données de test créées avec succès!\n";
    }
}
