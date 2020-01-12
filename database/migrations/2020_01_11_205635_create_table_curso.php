<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCurso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CURSO', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 100);
            $table->unsignedBigInteger('tipocurso_id');

            $table->foreign('tipocurso_id')->references('id')->on('TIPOCURSO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CURSO');
    }
}
