<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAluno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ALUNO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 100);
            $table->string('cpf', 11)->unique();
            $table->date('dtnascimento');
            $table->unsignedBigInteger('curso_id');

            $table->foreign('curso_id')->references('id')->on('CURSO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ALUNO');
    }
}
