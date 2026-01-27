<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('universites', function (Blueprint $table) {
        // Statut de validation (en_attente, approuvee, rejetee)
        $table->enum('statut_validation', ['en_attente', 'approuvee', 'rejetee'])
              ->default('en_attente')
              ->after('est_active');
        
        // Date de validation
        $table->timestamp('validee_le')->nullable();
        
        // Admin qui a validé
        $table->foreignId('validee_par')->nullable()->constrained('users');
        
        // Raison du rejet (si rejetée)
        $table->text('raison_rejet')->nullable();
        
        // Date limite pour corriger (si rejetée)
        $table->date('date_limite_correction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universites', function (Blueprint $table) {
            // Supprimer la clé étrangère d'abord
            $table->dropForeign(['validee_par']);
            
            // Ensuite supprimer les colonnes
            $table->dropColumn([
                'statut_validation',
                'validee_le', 
                'validee_par',
                'raison_rejet',
                'date_limite_correction'
            ]);
        });
    }
};
