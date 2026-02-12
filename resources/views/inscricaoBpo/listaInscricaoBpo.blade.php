@extends('layout')

@section('cabecalho')
Lista Candidatos BPO
@endsection

@section('conteudo')

@if(!empty($mensagem))
<div class="alert alert-success">
    {{$mensagem}}
</div>
@endif

<form id="tabelaPrincipal" action="{{url('/candidatos')}}" method="GET" role="search">
    <div class="row mb-3">
        <input type="hidden" id="paginaAtual" name="page" value="{{ $paginaAtual }}">
        <input type="hidden" id="totalPaginas" value="{{ $paginas }}">

        @if(isset($requestParams))
            @foreach($requestParams as $key => $value)
                @if($key !== 'page' && $key !== 'paginaAtual')
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
        @endif

        <div class="col-md-3 mb-3">
            <a href="{{url('/candidatos/criar')}}" class="btn btn-success">
                + Adicionar
            </a>
        </div>

        <div class="col-md-2">
            <select class="form-select" name="statusProjBpo" onchange="this.form.submit()">
                <option value="" selected>Todos os Status</option>
                @foreach($statusProjetoBpo as $s)
                <option value="{{ $s->statusBpo }}" {{ $statusFiltro == $s->statusBpo ? 'selected' : '' }}>
                    {{ $s->descricao }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input class="form-control" type="search" placeholder="Pesquisar..." name="pesquisa" id="pesquisa" value="{{$request->pesquisa}}" onkeyup="abrirModalPesquisa()">
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-light w-100">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <div class="col-md-1">
            <a onclick="comandoExportar()" class="btn btn-success text-white w-100">
                <i class="bi bi-file-earmark-arrow-down-fill"></i>
            </a>
        </div>

        <div class="col-md-1 d-flex align-items-center">
            <div class="form-check form-switch">
                <input class="form-check-input" name="status" type="checkbox" onchange="this.form.submit()" {{ (!isset($status) || $status != 0) ? 'checked' : '' }} style="width: 40px; height: 20px;">
            </div>
        </div>
    </div>
</form>

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th class="text-center">CPF</th>
            <th class="text-center">Nome</th>
            <th class="text-center">Curso</th>
            <th class="text-center">Parente?</th>
            <th class="text-center">Cidade</th>
            <th class="text-center">Nascimento</th>
            <th class="text-center">Recebimento</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($candidatos as $c)
        <tr>
            <td>{{ $c->cpf }}</td>
            <td><strong>{{ $c->nome }}</strong></td>
            <td class="text-center">{{ $c->curso ?? '-' }}</td>
            <td class="text-center">
                @if($c->temParente == 'S')
                    <span class="badge bg-warning text-dark" title="{{$c->grauParente}}: {{$c->parente}}">Sim</span>
                @else
                    <span class="badge bg-light text-dark border">Não</span>
                @endif
            </td>
            <td>{{ $c->cidade }}</td>
            <td class="text-center">{{ $c->dataNascimento ? date('d/m/Y', strtotime($c->dataNascimento)) : '-' }}</td>
            <td class="text-center small">{{ date('d/m/Y H:i', strtotime($c->dataHoraEnvio)) }}</td>
            <td>
                <div class="d-flex gap-2">
                    <a href="{{ url('/candidatos/visualizar/' . $c->idBpo) }}" class="btn btn-sm btn-warning text-white">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form action="{{ route('inscricao.destroy', $c->idBpo) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>Total: <strong>{{$maximo}}</strong> resultados</div>

    @if($paginas > 1)
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-secondary btn-sm me-1" onclick="navegarPagina('primeiro')" {{ $paginaAtual <= 1 ? 'disabled' : '' }}>&lt;&lt;</button>
        <button type="button" class="btn btn-secondary btn-sm me-1" onclick="navegarPagina('anterior')" {{ $paginaAtual <= 1 ? 'disabled' : '' }}>&lt;</button>

        <select class="form-select form-select-sm mx-2" style="width: 80px;" id="select_paginacao">
            @for ($i = 1; $i <= $paginas; $i++)
                <option value="{{ $i }}" {{ $i == $paginaAtual ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>

        <button type="button" class="btn btn-secondary btn-sm me-1" onclick="navegarPagina('proximo')" {{ $paginaAtual >= $paginas ? 'disabled' : '' }}>&gt;</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="navegarPagina('ultimo')" {{ $paginaAtual >= $paginas ? 'disabled' : '' }}>&gt;&gt;</button>
    </div>
    @endif
</div>

<div id="resultModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pesquisa Avançada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="nome" value="{{$request->nome}}">
                    </div>
                    <div class="col-md-6">
                        <label>CPF</label>
                        <input type="text" class="form-control" name="cpf">
                    </div>
                </div>
                <button class="btn btn-success" onclick="pesquisarAvancado()">Pesquisar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function irParaPagina(pagina) {
        document.getElementById('paginaAtual').value = pagina;
        document.getElementById('tabelaPrincipal').submit();
    }

    function navegarPagina(acao) {
        let atual = parseInt(document.getElementById('paginaAtual').value) || 1;
        let total = parseInt(document.getElementById('totalPaginas').value) || 1;
        let nova = atual;

        if (acao === 'primeiro') nova = 1;
        else if (acao === 'anterior') nova = Math.max(1, atual - 1);
        else if (acao === 'proximo') nova = Math.min(total, atual + 1);
        else if (acao === 'ultimo') nova = total;

        irParaPagina(nova);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sel = document.getElementById('select_paginacao');
        if (sel) sel.addEventListener('change', function() { irParaPagina(this.value); });
    });
</script>

<script src="{{url('html/js/questionarioBpo.js')}}"></script>
@endsection