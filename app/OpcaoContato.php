<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class OpcaoContato extends Model{

    protected $table = 'opcaocontato';
    // protected $fillable = ['CPF', 'ALUNO', 'EMAIL', 'TELEFONE', 'NASCIMENTO', 'RA', 'CURSO'];

    public function solicitacao()
    {
        return $this->belongsTo(OpcaoContato::class, 'ID', 'OPCAOCONTADO_ID');
    }
}
