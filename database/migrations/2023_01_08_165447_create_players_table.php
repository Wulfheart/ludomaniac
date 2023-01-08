<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId("game_id")->constrained();
            $table->foreignId("power_id")->constrained();
            $table->foreignId("user_id")->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
};
