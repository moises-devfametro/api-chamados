<?php

namespace App\Http\Controllers;

use App\Solicitacao;
use App\Alunos_rm;
use App\RespostaSolicitacao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ChamadoController extends Controller
{

    public function getAllAbertoHoje(){
        $chamado = DB::table('solicitacao AS SOLIC')
            ->join('OPCAOCONTATO AS OP', 'OP.ID', '=', 'SOLIC.OPCAOCONTATO_ID')
            ->join('ALUNOS_RM AS ALU', 'ALU.ID', '=', 'SOLIC.ALUNO_ID')
            ->join('STATUSSOLIC AS STATUS', 'STATUS.ID', '=', 'SOLIC.STATUSSOLIC_ID')
            ->whereDate('SOLIC.created_at', date('Y-m-d'))
            ->select('SOLIC.ID AS ID', 'SOLIC.created_at AS DATA_ABERTURA', 'ALU.CPF', 'SOLIC.OPCAO_WIFI', 'SOLIC.OPCAO_EMAIL', 'SOLIC.OPCAO_PORTAL', 'SOLIC.CONTATO', 'ALU.ALUNO', 'SOLIC.RESPONSAVEL_TECNICO', 'STATUS.DESCRICAO AS STATUS')
            ->get();
        return response()->json($chamado);
    }
    public function getChamadoStatus(Request $request){
        $chamado = DB::table('solicitacao AS SOLIC')
            ->join('OPCAOCONTATO AS OP', 'OP.ID', '=', 'SOLIC.OPCAOCONTATO_ID')
            ->join('ALUNOS_RM AS ALU', 'ALU.ID', '=', 'SOLIC.ALUNO_ID')
            ->join('STATUSSOLIC AS STATUS', 'STATUS.ID', '=', 'SOLIC.STATUSSOLIC_ID')
            ->where('STATUS.DESCRICAO', '=', $request->get('status'))
            ->select('SOLIC.ID AS ID', 'SOLIC.created_at AS DATA_ABERTURA', 'ALU.CPF', 'SOLIC.OPCAO_WIFI', 'SOLIC.OPCAO_EMAIL', 'SOLIC.OPCAO_PORTAL', 'SOLIC.CONTATO', 'ALU.ALUNO', 'SOLIC.RESPONSAVEL_TECNICO', 'STATUS.DESCRICAO')
            ->get();
        return response()->json($chamado);
    }

    public function get($id){
        $chamado = DB::table('solicitacao AS SOLIC')
            ->join('OPCAOCONTATO AS OP', 'OP.ID', '=', 'SOLIC.OPCAOCONTATO_ID')
            ->join('ALUNOS_RM AS ALU', 'ALU.ID', '=', 'SOLIC.ALUNO_ID')
            ->join('STATUSSOLIC AS STATUS', 'STATUS.ID', '=', 'SOLIC.STATUSSOLIC_ID')
            ->where('SOLIC.ID', '=', $id)
            ->select('SOLIC.ID AS ID', 'SOLIC.OBSERVACAO', 'SOLIC.created_at AS DATA_ABERTURA', 'SOLIC.ATRIBUIDOCHAMADO', 'ALU.CPF', 'SOLIC.OPCAO_WIFI', 'SOLIC.OPCAO_EMAIL', 'SOLIC.OPCAO_PORTAL', 'SOLIC.CONTATO', 'SOLIC.OPCAOCONTATO_ID' , 'ALU.ALUNO', 'SOLIC.RESPONSAVEL_TECNICO', 'ALU.CURSO', 'ALU.NASCIMENTO', 'STATUS.DESCRICAO AS STATUS')
            ->get();
            return response()->json($chamado);
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
        $chamadoUpdate = DB::table('solicitacao')
            ->where('id', $id)
            ->update($request->all());

        if($chamadoUpdate):
            return response()->json($chamadoUpdate, 200);
        endif;
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

    public function SendEmail(Request $request, $id){
        // Inseri na tabela resposta_solicitacao a resposta da solicitação com os necessários
        $DadosSolicitacao = new RespostaSolicitacao;
        $DadosSolicitacao->DESCRICAO = $request->msgEmail;
        $DadosSolicitacao->SOLICITACAO_ID = $id;
        $DadosSolicitacao->TECNICO_RESPONSAVEL = $request->nomeAluno;
        $DadosSolicitacao->save();

        // Depois de savo é enviado para o aluno a confirmação do chamado
        if($DadosSolicitacao->save()):
            $emailAluno = $request->emailAluno;
            $nomeAluno = $request->nomeAluno;

            $dadosMail = [
                'id' => $id,
                'NomeAluno' => $request->nomeAluno,
                'msg' => $request->msgEmail
            ];
            Mail::send('emails.respostaSolicitacao', $dadosMail, function ($message) use ($emailAluno, $nomeAluno) {
                $message->to($emailAluno, $nomeAluno);
                $message->from('sistemas@unifametro.edu.br','Unifametro');
                $message->subject('Resposta da sua solicitação.');
            });
        else:
            return response('Não foi possivel inserir');
        endif;

    }

}
