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
        return response()->json(Chamado::all());
    }
    public function getAllAbertoHoje(){
        // $chamado = Chamado::whereDate('data', date('Y-m-d'))
        //         ->get();
        // return response()->json($chamado);
    }
    public function getAllPendente(){
        // $chamado = DB::table('solicitacao AS SOLIC')
        //     ->join('status', 'SOLIC.status_id', '=', 'status.id')
        //     ->join('aluno AS ALU', 'SOLIC.aluno_id', '=', 'ALU.id')
        //     ->join('curso', 'curso.id', '=', 'ALU.curso_id')
        //     ->where('status.descricao', '=', 'Pendente')
        //     ->select('SOLIC.id', 'ALU.nome', 'ALU.cpf', 'curso.nome AS curso', 'SOLIC.contato', 'SOLIC.wifi_id', 'SOLIC.portal_id', 'SOLIC.email_id', 'SOLIC.observacao', 'status.descricao AS status', 'SOLIC.data AS created_at')
        //     ->get();
        // return response()->json($chamado);
    }
    public function getAllConcluidoHoje(){
        // $chamado = DB::table('solicitacao AS SOLIC')
        //     ->join('status', 'SOLIC.status_id', '=', 'status.id')
        //     ->join('aluno AS ALU', 'SOLIC.aluno_id', '=', 'ALU.id')
        //     ->join('curso', 'curso.id', '=', 'ALU.curso_id')
        //     ->whereDate('encerramentochamado', date('Y-m-d'))
        //     ->select('SOLIC.id', 'ALU.nome', 'ALU.cpf', 'curso.nome AS curso', 'SOLIC.contato', 'SOLIC.wifi_id', 'SOLIC.portal_id', 'SOLIC.email_id', 'SOLIC.observacao', 'status.descricao AS status')
        //     ->get();
        // return response()->json($chamado);
    }
    public function get($id){
        // $chamado = DB::table('solicitacao AS SOLIC')
        //     ->join('status', 'SOLIC.status_id', '=', 'status.id')
        //     ->join('aluno AS ALU', 'SOLIC.aluno_id', '=', 'ALU.id')
        //     ->join('curso', 'curso.id', '=', 'ALU.curso_id')
        //     ->where('SOLIC.ID', '=', $id)
        //     ->select('SOLIC.id', 'ALU.nome', 'ALU.cpf', 'curso.nome AS curso', 'SOLIC.contato', 'SOLIC.wifi_id', 'SOLIC.portal_id', 'SOLIC.email_id', 'SOLIC.observacao', 'status.descricao AS status', 'SOLIC.data AS created_at')
        //     ->get();
        //     return response()->json($chamado);
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
    public function getCursosGraduacao(){
        $curso = DB::connection('RM')->select("SELECT * FROM VW_LISTA_CURSO_GRAD");
        return response()->json($curso);
    }
    public function getCursosPosGraduacao(){
        $curso = DB::connection('RM')->select("SELECT * FROM VW_LISTA_CURSO_POS");
        return response()->json($curso);
    }
    public function getAluno(Request $request){
        $cpfAluno = $request->cpf;
        $dadosAluno = DB::connection('RM')->select("SELECT * FROM ALUNOS_SIST_SOLICITACOES WHERE CPF = '{$cpfAluno}'");
        return $dadosAluno;
    }
}
