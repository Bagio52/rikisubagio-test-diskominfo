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
        Schema::create('pokemon_abilties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pokemon_id')
                ->constrained('pokemons')
                ->cascadeOnDelete('cascade');
            $table->foreignId('ability_id')
                ->constrained('abilities')
                ->cascadeOnDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_abilties');
    }
};
