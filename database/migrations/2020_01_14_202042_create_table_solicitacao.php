<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSolicitacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITACAO', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('OBSERVACAO', 140);
            $table->unsignedBigInteger('ALUNO_ID');
            $table->string('CONTATO', 45);
            $table->integer('OPCAO_WIFI')->nullable($value = true);
            $table->integer('OPCAO_EMAIL')->nullable($value = true);
            $table->integer('OPCAO_PORTAL')->nullable($value = true);
            $table->unsignedBigInteger('OPCAOCONTATO_ID');
            $table->unsignedBigInteger('STATUSSOLIC_ID')->default($value = 1);
            $table->string('RESPONSAVEL_TECNICO')->nullable($value = true);
            $table->date('ATRIBUIDOCHAMADO')->nullable($value = true);
            $table->date('ENCERRAMENTOCHAMADO')->nullable($value = true);
            $table->timestampsTz(0);


            $table->foreign('ALUNO_ID')->references('id')->on('ALUNOS_RM');
            $table->foreign('OPCAOCONTATO_ID')->references('id')->on('OPCAOCONTATO');
            $table->foreign('STATUSSOLIC_ID')->references('id')->on('STATUSSOLIC');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SOLICITACAO');
    }
}
