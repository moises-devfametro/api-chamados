<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmailsResposta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RESPOSTA_SOLICITACAO', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('DESCRICAO');
            $table->unsignedBigInteger('SOLICITACAO_ID');
            $table->string('TECNICO_RESPONSAVEL');
            $table->timestamps();

            $table->foreign('SOLICITACAO_ID')->references('ID')->on('SOLICITACAO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RESPOSTA_SOLICITACAO');
    }
}
