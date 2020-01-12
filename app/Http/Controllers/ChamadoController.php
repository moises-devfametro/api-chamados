<?php

namespace App\Http\Controllers;

use App\Chamado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChamadoController extends Controller
{

    public function __construct()
    {
        //
    }
    public function getAllAberto(){
        $chamado = DB::table('solicitacao')
            ->join('aluno', 'solicitacao.aluno_id', '=', 'aluno.id')
            ->join('status', 'solicitacao.status_id', '=', 'status.id')
            ->join('curso', 'aluno.curso_id', '=', 'curso.id')
            ->join('tipocurso', 'curso.tipocurso_id', '=', 'tipocurso.id')
            ->select('solicitacao.id', 'solicitacao.data', 'aluno.nome', 'aluno.cpf', 'status.descricao')
            ->get();
        // $chamado = Chamado::where('status_id', 1)
        //        ->orderBy('data', 'desc')
        //        ->get();
        return response()->json($chamado);
    }
    public function getAllAbertoHoje(){
        $users = Chamado::whereDate('data', date('Y-m-d'))
                ->get();
        return response()->json($users);
    }
    public function getAllPendente(){
        $chamado = Chamado::where('status_id', 2)
                ->orderBy('data', 'desc')
                ->get();
        return response()->json($chamado);
    }
    public function getAllConcluidoHoje(){
        $users = Chamado::whereDate('encerramentochamado', date('Y-m-d'))
                ->get();
    return response()->json($users);
    }
    public function get($id){
        return response()->json(Chamado::find($id));
    }
    public function store(Request $request){
        $chamado = Chamado::create($request->all()); 
        return response()->json($chamado, 201);
    }
    public function update($id, Request $request){
        $chamado = Chamado::findOrFail($id);
        $chamado->update($request->all());

        return response()->json($chamado, 200);
    }
}
