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
        Schema::create(
            'cnaes',
            function (Blueprint $table) {
            $table->id();
            $table->integer('versao')
                ->comment('Versão da base cnae');

            $table->string('subclasse', 255)
                ->nullable(false)
                ->comment('Id da subclasse');

            $table->string('atividade', 500)
                ->nullable(false)
                ->comment('Atividade da subclasse');

            $table->string('compreende', 5000)
                ->nullable(false)
                ->comment('Observacoes da subclasse');
            $table->string('compreende_ainda', 5000)
                ->nullable(false)
                ->comment('Observacoes da subclasse');

            $table->string('nao_compreende', 5000)
                ->nullable(false)
                ->comment('Observacoes da subclasse');
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cnaes');
    }
};
