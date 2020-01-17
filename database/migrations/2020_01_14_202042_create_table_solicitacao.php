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
            $table->date('DATAABERTURA')->useCurrent();
            $table->unsignedBigInteger('OPCAOPROBLEMA_ID');
            $table->unsignedBigInteger('OPCAOCONTATO_ID');
            $table->unsignedBigInteger('STATUSSOLIC_ID');
            $table->integer('TECNICO_RM_ID');
            $table->date('ATRIBUIDOCHAMADO')->nullable($value = true);
            $table->date('ENCERRAMENTOCHAMADO')->nullable($value = true);

            $table->foreign('ALUNO_ID')->references('id')->on('ALUNOS_RM');
            $table->foreign('OPCAOPROBLEMA_ID')->references('id')->on('OPCAOPROBLEMA');
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
