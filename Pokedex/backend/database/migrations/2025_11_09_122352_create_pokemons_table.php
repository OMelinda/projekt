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
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('pokedex_number')->unique();
            $table->string('type1');
            $table->string('type2')->nullable();
            $table->json('abilities');
            $table->string('image_url');
            $table->string('shiny_image_url');
            $table->json('base_stats');
            $table->json('evolution_chain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};
