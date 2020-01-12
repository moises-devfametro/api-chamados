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
            $table->bigIncrements('id');
            $table->string('observacao', 140);
            $table->unsignedBigInteger('aluno_id');
            $table->unsignedBigInteger('wifi_id')->nullable($value = true);;
            $table->unsignedBigInteger('email_id')->nullable($value = true);;
            $table->unsignedBigInteger('portal_id')->nullable($value = true);;
            $table->unsignedBigInteger('status_id')->default(1);
            $table->string('contato', 45);
            $table->timestamp('data')->useCurrent();
            $table->timestamp('atribuicaochamado')->nullable($value = true);
            $table->timestamp('encerramentochamado')->nullable($value = true);
            
            $table->foreign('aluno_id')->references('id')->on('ALUNO');
            $table->foreign('wifi_id')->references('id')->on('OPCAOPROBLEMA');
            $table->foreign('email_id')->references('id')->on('OPCAOPROBLEMA');
            $table->foreign('portal_id')->references('id')->on('OPCAOPROBLEMA');
            $table->foreign('status_id')->references('id')->on('STATUS');
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
