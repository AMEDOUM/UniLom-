<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nom')->nullable();  // Votre champ supplémentaire
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // VOS CHAMPS POUR UNILOMÉ
            $table->enum('role', ['etudiant', 'universite', 'admin'])->default('etudiant');
            $table->string('photo')->nullable();
            $table->date('date_naissance')->nullable();
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->string('nom_universite')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('localisation')->nullable();
            $table->text('vision')->nullable();
            $table->string('telephone')->nullable();
            $table->boolean('est_valide')->default(false);
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};