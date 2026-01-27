<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les utilisateurs par défaut (admin, étudiant, université)
        $this->call(AdminSeeder::class);
        
        // Créer les données de test supplémentaires
        // $this->call(DemoDataSeeder::class);
    }
}
