<?php

namespace App\Http\Controllers;

use App\Models\InscricaoBpo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Rules\CpfValido;

class InscricaoController extends Controller
{
    public function create($id) 
    {
        $p = DB::table('projetoBpo')->where('idProjeto', $id)->first();

        if (!$p) {
            dd("Projeto com ID {$id} não foi encontrado no banco."); 
        }

        $projeto = strtoupper($p->nomeBpo);
        $candidatos = new \App\Models\InscricaoBpo();
        $bpo = DB::table('projetoBpo')->select('idProjeto', 'nomeBpo')->get();

        $cidades = [
            'Aguaí', 'Águas da Prata', 'Casa Branca', 'Itobi', 'São João da Boa Vista', 'São José do Rio Pardo', 'São Sebastião da Grama', 'Vargem Grande do Sul'
        ];

        $escolaridades = [
            'Ensino Fundamental', 'Ensino Médio', 'Ensino Superior'
        ];

        $categoriaCnh = [
            'Categoria B', 'Categoria C', 'Categoria D', 'Categoria E'
        ];

        $listaHabilidades = [
            'trator' => 'Tenho experiência com trator',
            'carro' => 'Tenho experiência com carro',
            'caminhao' => 'Tenho experiência com caminhão'
        ];

        $parentes = [
            'Pai', 'Mãe', 'Irmão', 'Irmã', 'Tio(a)', 'Avô(ó)', 'Primo(a)', 'Cunhado(a)'
        ];

        
        return view('inscricaoBpo.createInscricaoBpo', compact('projeto', 'candidatos', 'bpo', 'p', 'cidades', 'parentes', 'escolaridades', 'categoriaCnh', 'listaHabilidades'));
    }

    public function lista(Request $request)
    {
        $query = InscricaoBpo::query();

        if ($request->filled('pesquisa')) {
            $query->where(function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->pesquisa . '%')
                ->orWhere('cpf', 'like', '%' . $request->pesquisa . '%');
            });
        }

        if ($request->filled('nome')) $query->where('nome', 'like', '%' . $request->nome . '%');
        if ($request->filled('cpf')) $query->where('cpf', preg_replace('/[^0-9]/', '', $request->cpf));
        if ($request->filled('cidade')) $query->where('cidade', 'like', '%' . $request->cidade . '%');
        if ($request->filled('escolaridade')) $query->where('escolaridade', $request->escolaridade);
        if ($request->filled('cnh')) $query->where('cnh', $request->cnh);
        if ($request->filled('estadoCivil')) $query->where('estadoCivil', $request->estadoCivil);

        if ($request->filled('idadeMinima')) {
            $dataLimite = Carbon::now()->subYears($request->idadeMinima)->format('Y-m-d');
            $query->where('dataNascimento', '<=', $dataLimite);
        }

        if ($request->filled('idadeMaxima')) {
            $dataLimite = Carbon::now()->subYears($request->idadeMaxima + 1)->format('Y-m-d');
            $query->where('dataNascimento', '>', $dataLimite);
        }

        if ($request->filled('statusProjBpo')) $query->where('projeto', $request->statusProjBpo);

        if ($request->filled('exportar') && $request->exportar == 'S') {
            return $this->exportarCsv($query->get());
        }

        // AJUSTE: appends($request->all()) para manter os filtros na paginação
        $candidatosPaginados = $query->orderBy('idBpo', 'desc')->paginate(10)->appends($request->all());
        
        $candidatos = $candidatosPaginados->items(); 
        $paginaAtual = $candidatosPaginados->currentPage();
        $paginas = $candidatosPaginados->lastPage();
        $maximo = $candidatosPaginados->total();

        $statusProjetoBpo = InscricaoBpo::select('projeto as statusBpo', 'projeto as descricao')->distinct()->get();
        $bpo = InscricaoBpo::select('projeto as idProjeto', 'projeto as nomeBpo')->distinct()->get();
        $statusFiltro = $request->statusProjBpo;

        return view('inscricaoBpo.listaInscricaoBpo', compact(
            'candidatos', 'paginaAtual', 'paginas', 'maximo', 
            'statusProjetoBpo', 'statusFiltro', 'bpo', 'request'
        ));
    }

    private function exportarCsv($dados)
    {
        $fileName = 'candidatos_bpo_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function() use($dados) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nome', 'CPF', 'Projeto', 'Cidade', 'Escolaridade']);
            foreach ($dados as $item) {
                fputcsv($file, [$item->idBpo, $item->nome, $item->cpf, $item->projeto, $item->cidade, $item->escolaridade]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'celular' => preg_replace('/[^0-9]/', '', $request->celular),
            'telefone' => preg_replace('/[^0-9]/', '', $request->telefone),
        ]);

        $projetoObjeto = DB::table('projetobpo')->where('nomeBpo', $request->projeto)->first();

        if (!$projetoObjeto) {
            return back()->withErrors(['projeto' => 'Curso não encontrado.']);
        }

        $request->validate([
            'nome' => 'required',
            'dataNascimento' => 'required',
            'cpf' => [
                'required',
                new CpfValido,
                Rule::unique('docprojetobpo')->where(fn ($q) => 
                    $q->where('cpf', $request->cpf)
                    ->where('Projeto_id', $projetoObjeto->idProjeto)
                ),
            ],
            'sexo' => 'required',
            'celular' => 'required',
            'cidade' => 'required',
            'temParente' => 'required', 
            'grauParente' => 'required_if:temParente,S',
        ], ['cpf.unique' => 'Você já está inscrito neste curso!']);

        // AJUSTE: Tratamento Unificado de Data e Idade
        $dataNascimentoBanco = null;
        $idadeCandidato = 0;
        if ($request->dataNascimento) {
            try {
                $dt = Carbon::hasFormat($request->dataNascimento, 'd/m/Y') 
                      ? Carbon::createFromFormat('d/m/Y', $request->dataNascimento)
                      : Carbon::parse($request->dataNascimento);
                $dataNascimentoBanco = $dt->format('Y-m-d');
                $idadeCandidato = $dt->age;
            } catch (\Exception $e) { $idadeCandidato = 0; }
        }

        // AJUSTE: Limpeza Radical de Habilidades
        $habRaw = $request->input('habilidades', '');
        $habTexto = is_array($habRaw) ? implode(', ', $habRaw) : (string)$habRaw;
        $habilidadesLimpas = preg_replace('/[^a-zA-Z0-9áéíóúâêîôûãõçÁÉÍÓÚÂÊÎÔÛÃÕÇ\s,]/u', '', $habTexto);
        

        $dadosParaSalvar = [
            'Projeto_id' => $projetoObjeto->idProjeto,
            'projeto' => $projetoObjeto->nomeBpo,
            'StatusBpo' => 1,
            'idade' => $idadeCandidato,
            'dataNascimento' => $dataNascimentoBanco,
            'dataEnvio' => now()->format('Y-m-d'),
            'dataHoraEnvio' => now(),
            'dataCriacao' => now(),
            'termos' => 'Sim',
            'habilidades' => trim($habilidadesLimpas),
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'sexo' => $request->sexo,
            'celular' => $request->celular,
            'telefone' => $request->telefone ?? '',
            'cidade' => $request->cidade,
            'escolaridade' => $request->escolaridade,
            'faculdade' => $request->faculdade ?? '',
            'cnh' => $request->cnh,
            'funcionario' => $request->funcionario,
            'ano' => $request->ano ?? '',
            'funcao' => $request->funcao ?? '',
            'empresaAtual' => $request->empresaAtual ?? '', 
            'curso' => $request->curso ?? '',
            'temParente' => $request->temParente ?? 'N',
            'grauParente' => $request->grauParente ?? '',
            'parente' => $request->parente ?? '',
            'empregado' => $request->empregado ?? 'N',
            'estadoCivil' => $request->estadoCivil ?? 'Não Informado',
            'horarioTreinamento' => $request->horarioTreinamento ?? 'Não Informado',
        ];

        try {
            InscricaoBpo::create($dadosParaSalvar);
            return redirect()->route('inscricao.sucesso', ['tipo' => $projetoObjeto->tipo]);
        } catch (\Exception $e) {
            Log::error("Erro Store: " . $e->getMessage());
            return back()->withErrors(['banco' => 'Erro ao salvar.']);
        }
    }

    public function edit($id)
    {
        $candidatos = InscricaoBpo::findOrFail($id);
        $projeto = strtoupper($candidatos->projeto);
        $bpo = InscricaoBpo::select('projeto as idProjeto', 'projeto as nomeBpo')->distinct()->get();
        return view('inscricaoBpo.createInscricaoBpo', compact('candidatos', 'projeto', 'bpo'));
    }

    public function update(Request $request, $id)
    {
        $candidato = InscricaoBpo::findOrFail($id);
        $dados = $request->all();
        if ($request->has('habilidades') && is_array($request->habilidades)) {
            $dados['habilidades'] = implode(', ', $request->habilidades);
        }
        $candidato->update($dados);
        return redirect()->route('inscricao.lista')->with('success', 'Atualizado!');
    }

    public function destroy($id)
    {
        $candidato = InscricaoBpo::findOrFail($id); 
    
        $candidato->delete();
        
        return redirect()->back()->with('mensagem', 'Candidato removido com sucesso!');
    }

    public function projeto($tipo)
    {
        $p = DB::table('projetoBpo')->where('tipo', $tipo)->first();
        if (!$p) abort(404);

        $hoje = date('Y-m-d');
        $p->status = ($hoje > $p->dataFim) ? 'Finalizado' : 'Aberto';

        $caminhoNoS3 = parse_url($p->imagem, PHP_URL_PATH);
        $caminhoNoS3 = ltrim($caminhoNoS3, '/'); 

        try {
            $p->link_dinamico = Storage::disk('s3')->temporaryUrl($caminhoNoS3, now()->addMinutes(30));
        } catch (\Exception $e) {
            $p->link_dinamico = $p->imagem; 
        }

        $projetos = [$p]; 
        return view('blog.projetobpo', compact('projetos', 'p', 'tipo'));
    }


    public function home()
    {
        // 1. Busca os dados com o CASE para criar a coluna 'status'
        $projetos = DB::select("SELECT idProjeto, nomeBpo, tituloBpo, dataInicio, dataFim, imagem, tipo, statusProjeto,
            CASE 
                WHEN CURDATE() > dataFim THEN 'Inscrições finalizadas'
                ELSE 'Inscrições abertas'
            END AS status
            FROM projetoBpo");

        // 2. Processa as URLs das imagens (essencial para o S3)
        foreach ($projetos as $projeto) {
            if (!empty($projeto->imagem)) {
                try {
                    if (preg_match('/https:\/\/bucket-coxabengoa\.s3\.amazonaws\.com\/imagens\/([^"]+)/', $projeto->imagem)) {
                        $projeto->imagem = preg_replace_callback(
                            '/https:\/\/bucket-coxabengoa\.s3\.amazonaws\.com\/imagens\/([^"]+)/',
                            function ($matches) {
                                $filePath = 'imagens/' . $matches[1];
                                return Storage::disk('s3')->temporaryUrl($filePath, now()->addMinutes(10));
                            },
                            $projeto->imagem
                        );
                    } else {
                        $filePath = 'imagens/' . $projeto->imagem;
                        $projeto->imagem = Storage::disk('s3')->temporaryUrl($filePath, now()->addMinutes(10));
                    }
                } catch (\Exception $e) {
                    $projeto->imagem = null; // Evita quebra se o S3 falhar no teste
                }
            }
        }

        // 3. RETORNO PARA O NOVO CAMINHO
        return view('blog.inicio', compact('projetos'));

        
    }



    public function vagas()
    {
        $vagas = DB::select('SELECT *, v.descricaoFuncao AS descricaoVaga, 
            CASE 
                /* Se a data for menor ou igual a hoje, vamos devolver 0 
                (o HTML original escreverá "Faltam 0 dias") */
                WHEN v.dataLimite <= CURRENT_DATE() THEN "0"
                ELSE DATEDIFF(v.dataLimite, CURRENT_DATE()) 
            END AS quantidadeDias,
            (SELECT COUNT(*) FROM docPessoal 
                WHERE descricaoFuncao = f.descricaoFuncao 
                AND v.descricaoLocal = f.descricaoLocal) AS inscritos
            FROM docvagas AS v 
            INNER JOIN docFuncao AS f ON v.Funcao_id = f.idFuncao
            WHERE v.statusVaga != 0'); 

        return view('blog.vagas', compact('vagas'));
    }

    // public function requisitos($id)
    // {
    //     // 1. Ajuste na Query principal para aceitar as datas de 2025 e manter o padrão de dias
    //     $vagas = DB::select('SELECT *, v.descricaoFuncao AS descricaoVaga, v.descricaoLocal, 
    //         CASE 
    //             WHEN v.dataLimite < CURRENT_DATE() THEN "Finalizado"
    //             WHEN v.dataLimite = CURRENT_DATE() THEN "Último dia"
    //             ELSE DATEDIFF(v.dataLimite, CURRENT_DATE()) 
    //         END AS quantidadeDias,
    //         (SELECT COUNT(*) FROM docPessoal 
    //             WHERE descricaoFuncao = f.descricaoFuncao 
    //             AND v.descricaoLocal = f.descricaoLocal) AS inscritos
    //         FROM docvagas AS v 
    //         INNER JOIN docFuncao AS f ON v.Funcao_id = f.idFuncao
    //         /* Removemos o "dataLimite > now()" para a vaga não dar erro 404 por estar vencida */
    //         WHERE v.statusVaga != 0 AND v.idVaga = ?', [$id]);

    //     if (empty($vagas)) {
    //         abort(404);
    //     }

    //     // 2. Tratamento de Benefícios (Mantendo sua lógica original)
    //     $benef = str_replace(['[', ']'], '', $vagas[0]->beneficios);
        
    //     $beneficios = [];
    //     if (!empty($benef)) {
    //         // Proteção simples contra SQL Injection se $benef vier vazio ou malformado
    //         $beneficios = DB::select("SELECT * FROM docbeneficios WHERE idBeneficio IN ($benef)");
    //     }

    //     // 3. URLs Temporárias do S3
    //     $filePath = 'imagens/';
    //     foreach ($beneficios as $beneficio) {
    //         if (!empty($beneficio->imagem)) {
    //             $beneficio->imagem = Storage::disk('s3')->temporaryUrl(
    //                 $filePath . $beneficio->imagem,
    //                 now()->addMinutes(5)
    //             );
    //         }
    //     }

    //     if (!empty($vagas[0]->imagem)) {
    //         $vagas[0]->imagem = Storage::disk('s3')->temporaryUrl(
    //             $filePath . $vagas[0]->imagem,
    //             now()->addMinutes(5)
    //         );
    //     }

    //     return view('blog.vagarequisitos', compact('vagas', 'beneficios'));
    // }

    public function requisitos($id)
    {
        // ... query das vagas permanece a mesma ...
        $vagas = DB::select('SELECT *, v.descricaoFuncao AS descricaoVaga, v.descricaoLocal, 
             CASE 
                 WHEN v.dataLimite < CURRENT_DATE() THEN "Finalizado"
                 WHEN v.dataLimite = CURRENT_DATE() THEN "Último dia"
                 ELSE DATEDIFF(v.dataLimite, CURRENT_DATE()) 
             END AS quantidadeDias,
             (SELECT COUNT(*) FROM docPessoal 
                 WHERE descricaoFuncao = f.descricaoFuncao 
                 AND v.descricaoLocal = f.descricaoLocal) AS inscritos
             FROM docvagas AS v 
             INNER JOIN docFuncao AS f ON v.Funcao_id = f.idFuncao
             /* Removemos o "dataLimite > now()" para a vaga não dar erro 404 por estar vencida */
             WHERE v.statusVaga != 0 AND v.idVaga = ?', [$id]);

        if (empty($vagas)) {
            abort(404);
        }

        // 1. Busca os benefícios
        $benef = str_replace(['[', ']'], '', $vagas[0]->beneficios);
        $beneficios = [];
        if (!empty($benef)) {
            $beneficios = DB::select("SELECT * FROM docbeneficios WHERE idBeneficio IN ($benef)");
        }

        // 2. Gerar o caminho para a pasta local de imagens do projeto
        foreach ($beneficios as $beneficio) {
            if (!empty($beneficio->imagem)) {
                // Se as imagens estiverem em public/html/img/beneficios/
                $beneficio->imagem = asset('html/img/' . $beneficio->imagem);
            }
        }

        // Se a vaga também tiver imagem local
        if (!empty($vagas[0]->imagem)) {
            $vagas[0]->imagem = asset('html/img/' . $vagas[0]->imagem);
        }

        return view('blog.vagarequisitos', compact('vagas', 'beneficios'));
    }

}