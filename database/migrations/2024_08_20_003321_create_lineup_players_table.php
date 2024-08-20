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
        Schema::create('lineup_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lineup_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('position_id');
            $table->timestamps();

            $table->foreign('lineup_id')->references('id')->on('lineups')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('player')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('position_catalog')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineup_players');
    }
};
