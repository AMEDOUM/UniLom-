<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('universite_id')->constrained('universites')->onDelete('cascade');
            $table->timestamps();
            
            // Une combinaison unique user+universite
            $table->unique(['user_id', 'universite_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};