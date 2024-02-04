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
        Schema::create('dispensas', function (Blueprint $table) {
            $table->id();
            $table->string('identity_id');
            $table->integer('id_user');
            $table->string('modalidade');
            $table->string('discriminacao');
            $table->string('sub_classe_cnae');
            $table->string('atividade');
            $table->string('grupo_despesa');
            $table->decimal('valor');
            $table->string('numero_dispensa');
            $table->string('numero_processo_licitatorio');
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
        Schema::dropIfExists('dispensas');
    }
};
