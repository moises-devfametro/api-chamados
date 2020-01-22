<?php

namespace App\Http\Controllers;

use App\Solicitacao;
use App\Alunos_rm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $chamado = Solicitacao::create($request->all());

        $emailAluno = ($request->OPCAOCONTATO_ID == 2) ? $request->CONTATO : $request->EMAIL;
        $nomeAluno = $request->ALUNO;
        $dadosMail = [
            'id' => $chamado['id'],
            'NomeAluno' => $nomeAluno
        ];
        if($chamado):
            Mail::send('emails.mail', $dadosMail, function ($message) use ($emailAluno, $nomeAluno) {
                $message->to($emailAluno, $nomeAluno);
                $message->from('sistemas@unifametro.edu.br','Unifametro');
                $message->subject('Recebemos sua solicitação.');
            });
            return response()->json($chamado, 201);
        else:
            return false;
        endif;
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
        $users = DB::table('ALUNOS_RM')
                    ->select(DB::raw('ID, CPF, ALUNO, EMAIL, TELEFONE, NASCIMENTO, RA, CURSO'))
                    ->where('CPF', '=', $cpfAluno)
                    ->get();
        if(is_null($users) || $users->count() == 0):
            $dadosAluno = DB::connection('RM')->select("SELECT * FROM ALUNOS_SIST_SOLICITACOES WHERE CPF = '{$cpfAluno}'");
            if(empty($dadosAluno)):
                $obj = [];
                return response()->json($obj);
            else:
                $aluno_rm = new Alunos_rm;
                foreach ($dadosAluno as $dados) {
                    $aluno_rm->CPF = $dados->CPF;
                    $aluno_rm->ALUNO =  $dados->ALUNO;
                    $aluno_rm->EMAIL = $dados->EMAIL;
                    $aluno_rm->TELEFONE = $dados->TELEFONE;
                    $aluno_rm->NASCIMENTO = $dados->NASCIMENTO;
                    $aluno_rm->RA = $dados->RA;
                    $aluno_rm->CURSO = $dados->CURSO;
                }
                $aluno_rm->save();
                $DadosDeAluno = DB::table('ALUNOS_RM')
                     ->select(DB::raw('ID, CPF, ALUNO, EMAIL, TELEFONE, NASCIMENTO, RA, CURSO'))
                     ->where('CPF', '=', $cpfAluno)
                     ->get();
                return response()->json($DadosDeAluno);
            endif;
        else:
            return response()->json($users, 200);
        endif;


    }
}
