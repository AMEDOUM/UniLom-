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
            $table->integer('visites')->default(0)->after('est_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universites', function (Blueprint $table) {
            $table->dropColumn('visites');
        });
    }
};
