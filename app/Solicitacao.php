<?php

namespace App;

use Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Laravel\Lumen\Auth\Authorizable;

class Solicitacao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'solicitacao';
    public $timestamps = true;

    protected $fillable = [
        'OBSERVACAO', 'ALUNO_ID', 'CONTATO', 'OPCAO_WIFI', 'OPCAO_EMAIL', 'OPCAO_PORTAL', 'OPCAOCONTATO_ID', 'STATUSSOLIC_ID', 'RESPONSAVEL_TECNICO', 'ATRIBUIDOCHAMADO', 'ENCERRAMENTOCHAMADO'
    ];

    public function status(){
        return $this->hasOne(StatusSolicitacao::class, 'ID', 'STATUSSOLIC_ID');
    }

    public function contato(){
        return $this->hasOne(OpcaoContato::class, 'ID', 'OPCAOCONTATO_ID');
    }

    public function aluno_rm(){
        return $this->hasOne(Alunos_rm::class, 'ID', 'ALUNO_ID');
    }
    // /**
    //  * The attributes excluded from the model's JSON form.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password',
    // ];
}
