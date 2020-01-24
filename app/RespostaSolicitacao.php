<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class RespostaSolicitacao extends Model{
    // Definimos a conexão "api_chamados" para este model
    protected $table = 'resposta_solicitacao';
    protected $fillable = ['DESCRICAO', 'SOLICITACAO_ID', 'TECNICO_RESPONSAVEL'];

}
