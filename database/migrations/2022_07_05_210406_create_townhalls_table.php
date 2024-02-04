<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('townhalls', function (Blueprint $table) {
            $table->id();
            $table->string('identity_id')->unique();
            $table->string('cidade');
            $table->string('fone');
            $table->string('responsavel');
            $table->string('matricula');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('townhalls');
    }
};
