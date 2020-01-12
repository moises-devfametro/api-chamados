<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Laravel\Lumen\Auth\Authorizable;

class Chamado extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'solicitacao';
    public $timestamps = false;

    protected $fillable = [
        'observacao', 'aluno_id', 'wifi_id', 'email_id', 'portal_id', 'status_id', 'contato', 'atribuicaochamado', 'encerramentochamado'
    ];

    // /**
    //  * The attributes excluded from the model's JSON form.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password',
    // ];
}
