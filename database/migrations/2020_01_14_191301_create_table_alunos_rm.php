<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAlunosRm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ALUNOS_RM', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('CPF');
            $table->string('NOME');
            $table->string('EMAIL');
            $table->string('TELEFONE');
            $table->dateTime('DTNASCIMENTO');
            $table->string('RA');
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
        Schema::dropIfExists('ALUNOS_RM');
    }
}
