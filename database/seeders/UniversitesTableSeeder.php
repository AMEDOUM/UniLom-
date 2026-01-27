<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universites = [
        [
            'nom' => 'Université de Lomé',
            'sigle' => 'UL',
            'description' => 'Principale université publique du Togo, offrant des formations diversifiées.',
            'ville' => 'Lomé',
            'adresse' => 'Boulevard du 13 Janvier',
            'email' => 'contact@ul.tg',
            'telephone' => '+228 22 21 20 19',
            'site_web' => 'https://www.ul.tg',
            'est_public' => true,
            'nombre_etudiants' => 15000,
            'taux_reussite' => 85.5,
        ],
        [
            'nom' => 'Université de Kara',
            'sigle' => 'UK',
            'description' => 'Deuxième université publique du Togo, spécialisée en sciences et techniques.',
            'ville' => 'Kara',
            'adresse' => 'Route de Kpalimé',
            'email' => 'info@uk.tg',
            'telephone' => '+228 27 70 10 00',
            'site_web' => 'https://www.uk.tg',
            'est_public' => true,
            'nombre_etudiants' => 8000,
            'taux_reussite' => 82.0,
        ],
        // Ajoutez d'autres universités...
    ];
    
    foreach ($universites as $universite) {
        \App\Models\Universite::create($universite);
    }
    }
}
