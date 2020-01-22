<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StatusSolicitacao extends Model{
    // Definimos a conexão "api_chamados" para este model
    protected $table = 'statussolic';
    // protected $fillable = ['CPF', 'ALUNO', 'EMAIL', 'TELEFONE', 'NASCIMENTO', 'RA', 'CURSO'];

    public function solicitacao(){
        return $this->belongsTo(Solicitacao::class, 'ID', 'STATUSSOLIC_ID');
    }
}
