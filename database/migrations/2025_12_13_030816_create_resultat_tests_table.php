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
        Schema::create('resultat_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_id')->constrained('test_orientations')->onDelete('cascade');
            $table->json('reponses'); // {"question_id": "reponse_id", ...}
            $table->json('scores'); // {"sciences": 15, "droit": 8, "commerce": 12}
            $table->json('recommandations'); // IDs des formations recommandées
            $table->timestamp('date_completion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultat_tests');
    }
};
