<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('formations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('universite_id')->constrained()->onDelete('cascade');
        $table->string('nom'); // ex: "Licence en Informatique"
        $table->enum('niveau', ['licence', 'master', 'doctorat', 'bts', 'autre']);
        $table->string('domaine'); // ex: "Informatique", "Droit", "Médecine"
        $table->integer('duree_mois')->default(36); // 3 ans = 36 mois
        $table->decimal('frais_inscription', 10, 2)->nullable();
        $table->decimal('frais_scolarite_annuel', 10, 2)->nullable();
        $table->text('description');
        $table->text('prerequis')->nullable(); // Conditions d'admission
        $table->text('debouches')->nullable(); // Débouchés professionnels
        $table->json('langues')->nullable(); // ["Français", "Anglais"]
        $table->boolean('est_active')->default(true);
        $table->integer('places_disponibles')->nullable();
        $table->date('date_limite_inscription')->nullable();
        $table->timestamps();
        
        // Index pour les recherches
        $table->index(['domaine', 'niveau']);
    });
}
};
