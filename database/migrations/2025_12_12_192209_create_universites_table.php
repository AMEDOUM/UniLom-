<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('universites', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('sigle')->nullable();
        $table->text('description');
        $table->string('logo')->nullable();
        $table->string('site_web')->nullable();
        $table->string('email');
        $table->string('telephone')->nullable();
        $table->string('adresse');
        $table->string('ville')->default('Lomé');
        $table->string('pays')->default('Togo');
        $table->json('domaines')->nullable();
        $table->integer('nombre_etudiants')->nullable();
        $table->decimal('taux_reussite', 5, 2)->nullable();
        $table->string('facebook')->nullable();
        $table->string('twitter')->nullable();
        $table->string('linkedin')->nullable();
        $table->boolean('est_public')->default(true);
        $table->boolean('est_active')->default(true);
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
    });
}
};
