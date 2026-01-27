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
        Schema::create('test_orientations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->integer('duree_minutes')->default(10);
            $table->integer('nombre_questions');
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_orientations');
    }
};
