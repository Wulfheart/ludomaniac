<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("variant_id")->constrained();
            $table->longText("description");
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
