<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Alunos_rm extends Model{
    // Definimos a conexão "api_chamados" para este model
    protected $table = 'alunos_rm';
    protected $fillable = ['CPF', 'ALUNO', 'EMAIL', 'TELEFONE', 'NASCIMENTO', 'RA', 'CURSO'];
}
