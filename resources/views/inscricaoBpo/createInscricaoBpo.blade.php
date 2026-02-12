@extends('layouts.app')
    
@section('title', 'Inscrição BPO - Projeto ' . $projeto)
 
@push('styles')
    <link rel="stylesheet" href="{{ asset('html/css/inscricaoBpo.css') }}">
    
@endpush



@section('conteudo')
<div x-data="{ 
    passo: {{ $errors->any() ? 1 : 1 }},
    tentouAvancar: false, 
    
    // Dados do formulário
    nome: '{{ old('nome', '') }}',
    dataNascimento: '{{ old('dataNascimento', '') }}',
    cpf: '{{ old('cpf', '') }}',
    sexo: '{{ old('sexo', '') }}',
    celular: '{{ old('celular', '') }}',
    telefone: '{{ old('telefone', '') }}',
    cidade: '{{ old('cidade', '') }}',
    escolaridade: '{{ old('escolaridade', '') }}',
    faculdade: '{{ old('faculdade', '') }}',
    curso: '{{ old('curso', '') }}',
    cnh: '{{ old('cnh', '') }}',
    habilidades: {!! json_encode(old('habilidades', [])) !!},
    nenhuma: {{ old('habilidades_nenhuma') ? 'true' : 'false' }},
    funcionario: '{{ old('funcionario', '') }}',
    ano: '{{ old('ano', '') }}',
    funcao: '{{ old('funcao', '') }}', 
    empregado: '{{ old('empregado', '') }}',
    empresaAtual: '{{ old('empresaAtual', '') }}', 
    temParente: '{{ old('temParente', '') }}',
    grauParente: '{{ old('grauParente', '') }}',
    parente: '{{ old('parente', '') }}',

    init() {
        // Limpa campos dependentes automaticamente ao mudar rádio para 'Não'
        this.$watch('funcionario', v => { if(v==='N'){ this.ano=''; this.funcao=''; }});
        this.$watch('empregado', v => { if(v==='N'){ this.empresaAtual=''; }});
        this.$watch('temParente', v => { if(v==='N'){ this.grauParente=''; this.parente=''; }});
        this.$watch('escolaridade', v => { if(v!=='Ensino Superior'){ this.faculdade=''; }});
    },

    validarCPF(cpf) {
        if (!cpf) return false;
        const n = cpf.replace(/\D/g, '');
        if (n.length !== 11 || !!n.match(/(\d)\1{10}/)) return false;
        let soma = 0, resto;
        for (let i = 1; i <= 9; i++) soma += parseInt(n.substring(i-1, i)) * (11 - i);
        resto = (soma * 10) % 11;
        const d1 = (resto === 10 || resto === 11) ? 0 : resto;
        if (d1 !== parseInt(n.substring(9, 10))) return false;
        soma = 0;
        for (let i = 1; i <= 10; i++) soma += parseInt(n.substring(i-1, i)) * (12 - i);
        resto = (soma * 10) % 11;
        const d2 = (resto === 10 || resto === 11) ? 0 : resto;
        return d2 === parseInt(n.substring(10, 11));
    },

    validaPasso1() {
        return this.nome && this.dataNascimento.length === 10 && 
               this.validarCPF(this.cpf) && this.sexo && 
               this.celular.length >= 15 && this.cidade;
    },

    validaPasso2() {
        const faculdadeOk = (this.escolaridade === 'Ensino Superior') ? this.faculdade : true;
        const habilidadesOk = this.habilidades.length > 0 || this.nenhuma;
        return this.escolaridade && this.cnh && faculdadeOk && habilidadesOk;
    },

    validaPasso3() {
        const coxOk = (this.funcionario === 'S') ? (this.ano && this.funcao) : (this.funcionario === 'N');
        const empregadoOk = (this.empregado === 'S') ? this.empresaAtual : (this.empregado === 'N');
        const parenteOk = (this.temParente === 'S') ? (this.grauParente && this.parente) : (this.temParente === 'N');
        return coxOk && empregadoOk && parenteOk;
    },

    podeAvancar() {
        const funcs = { 1: 'validaPasso1', 2: 'validaPasso2', 3: 'validaPasso3' };
        return this[funcs[this.passo]]();
    },

    irParaProximo() {
        this.tentouAvancar = true; 
        if (this.podeAvancar()) {
            this.passo++;
            this.tentouAvancar = false; 
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}">



    <div class="wrapper-principal">
        
        <div class="top-section-wrapper">
            <header class="header-bpo-personalizado">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="titulo">BPO – Boas Práticas Operacionais</h1>
                        <p class="subtitulo">Inscrição – Projeto {{ $projeto }}</p>
                    </div>
                    <!-- Logo COX -->
                    <!-- <div class="header-logo">
                        <img src="{{ asset('img/logotipo-cox.png') }}" alt="Logo Cox">
                    </div> -->
                </div>
            </header>

            <nav class="stepper-wrapper">
                <div class="stepper-container">
                    <div class="stepper-line"></div>
                    
                    
                    <div class="stepper-item">
                        <div :class="passo >= 1 ? 'stepper-icon-active' : 'stepper-icon-inactive'" class="stepper-icon-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span :class="passo >= 1 ? 'stepper-text-active' : 'stepper-text-inactive'">Pessoal</span>
                    </div>

                    <div class="stepper-item">
                        <div :class="passo >= 2 ? 'stepper-icon-active' : 'stepper-icon-inactive'" class="stepper-icon-circle">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <span :class="passo >= 2 ? 'stepper-text-active' : 'stepper-text-inactive'">Formação</span>
                    </div>

                    <div class="stepper-item">
                        <div :class="passo >= 3 ? 'stepper-icon-active' : 'stepper-icon-inactive'" class="stepper-icon-circle">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <span :class="passo >= 3 ? 'stepper-text-active' : 'stepper-text-inactive'">Profissional</span>
                    </div>
                </div>
            </nav>
        </div> 
        <main class="main-container">
            <section class="form-card">
                <form id="meuFormulario" action="{{ route('inscricao.store') }}" method="POST">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger" style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="hidden" name="projeto" value="{{ $projeto }}">

                    <div x-show="passo === 1" x-transition>
                        <div class="form-header-step">
                            <h2 class="titulo-form">Identificação e Contato</h2>
                            <p class="subtitulo-form">Inicie sua inscrição para o programa de capacitação. Verifique se seus dados estão corretos para as próximas etapas do processo seletivo.</p>
                        </div>

                        <div class="grid-form">
                            <div class="bpo-col-8" style="position: relative">
                                <input
                                type="text" 
                                name="nome" 
                                id="id_nome"
                                class="input-bpo input-floating"
                                :class="{ 'campo-obrigatorio': tentouAvancar && nome === '' }"
                                placeholder="Nome completo"
                                x-model="nome"  
                                required>
                                <label for="id_nome" class="label-floating">Nome</label>
                                <template x-if="tentouAvancar && nome === ''">
                                    <span class="error-message">Por favor, preencha seu nome.</span>
                                </template>
                            </div>
                            <div class="bpo-col-4" style="position: relative">
                                <input type="text" 
                                name="dataNascimento" 
                                id="id_nascimento"
                                class="input-bpo input-floating"
                                :class="{ 'campo-obrigatorio': tentouAvancar && dataNascimento === '' }"
                                x-mask="99/99/9999"
                                placeholder="00/00/0000"
                                x-model="dataNascimento"
                                required>
                                <label for="id_nascimento" class="label-floating">Data de nascimento</label>
                                <template x-if="tentouAvancar && dataNascimento === ''">
                                    <span class="error-message">Campo obrigatório.</span>
                                </template>
                            </div>
                            <div class="bpo-col-4 input-container" style="position: relative">
                                <input 
                                type="text" 
                                name="cpf"  
                                id="id_cpf" 
                                class="input-bpo input-floating"
                                :class="{ 'campo-obrigatorio': tentouAvancar && !validarCPF(cpf) }"
                                x-mask="999.999.999-99" 
                                placeholder="000.000.000-00"
                                x-model="cpf" 
                                required>
                                <label for="id_cpf" class="label-floating">CPF</label>
                                <template x-if="tentouAvancar && cpf === ''">
                                    <span class="error-message">Campo obrigatório.</span>
                                </template>
                                <template x-if="tentouAvancar && !validarCPF(cpf) && cpf !== ''" >
                                    <span class="error-message">CPF inválido</span>
                                </template>
                                
                            </div>
                            <div class="bpo-col-6 radio-group-container" :class="{ 'campo-obrigatorio': tentouAvancar && sexo === '' }">
                                <span class="label-inline">Gênero:</span>
                                <label class="radio-item">
                                    <input type="radio" name="sexo"
                                    x-model="sexo" value="F"> Feminino</label>
                                <label class="radio-item">
                                    <input type="radio" name="sexo" value="M"
                                    x-model="sexo"> Masculino</label>
                                <template x-if="tentouAvancar && sexo === ''">
                                    <span class="error-message">Selecione seu sexo.</span>
                                </template>
                            </div>
                            <div class="bpo-col-6" style="position: relative">                                
                                <input 
                                type="text" 
                                name="celular"
                                id="id_celular" 
                                class="input-bpo input-floating" 
                                :class="{ 'campo-obrigatorio': tentouAvancar && celular === '' }"
                                x-mask="(99) 99999-9999" 
                                placeholder="(00) 00000-0000"
                                x-model="celular"
                                required>
                                <label for="id_celular" class="label-floating">Celular (WhatsApp)</label>
                                <template x-if="tentouAvancar && celular === ''">
                                    <span class="error-message">Campo obrigatório.</span>
                                </template>
                            </div>
                            <div class="bpo-col-6" style="position: relative">
                                <input 
                                type="text" 
                                name="telefone" 
                                id="id_telefone"
                                class="input-bpo input-floating" 
                                x-mask="(99) 9999-9999" 
                                placeholder="(00) 0000-0000"
                                x-model="telefone" >
                                <label for="id_telefone" class="label-floating">Telefone</label>
                            </div> 

                            <div class="bpo-col-8" style="position: relative">
                                <select name="cidade"
                                id="id_cidade"
                                x-model="cidade"class="select-bpo select-floating" 
                                :class="{ 'campo-obrigatorio': tentouAvancar && cidade === '' }"
                                required>
                                    <option value="" disabled selected class="label-floating"></option>
                                    @foreach($cidades as $cidadeOpcao)
                                        <option value="{{ $cidadeOpcao }}" 
                                            {{ old('cidade', $candidatos->cidade ?? '') == $cidadeOpcao ? 'selected' : '' }}>
                                            {{ $cidadeOpcao }}
                                        </option>
                                    @endforeach

                                    
                                </select>
                                <label for="id_cidade" class="label-floating">
                                    Cidade onde mora
                                </label>
                                <template x-if="tentouAvancar && cidade === ''">
                                    <span class="error-message">Selecione a cidade onde mora.</span>
                                </template>
                            </div>

                        </div>


                        <div class="form-footer">
                            <button type="button" onclick="history.back()" class="btn-back">Sair</button>
                            
                            <button type="button" @click="irParaProximo()" class="btn-primary">
                                Próximo
                            </button>
                        </div>
                    </div>

                    <div x-show="passo === 2" x-cloak x-transition>
                        <div class="form-header-step">
                            <h2 class="titulo-form">Qualificações e Pré-requisitos</h2>
                            <p class="subtitulo-form">Informe sua escolaridade e categoria de CNH (mínimo B).</p>
                        </div>

                        <div class="grid-form">
                            <div class="bpo-col-4" style="position:relative">
                                <select name="escolaridade"
                                id="id_escolaridade"
                                x-model="escolaridade" 
                                class="select-bpo select-floating" 
                                :class="{ 'campo-obrigatorio': tentouAvancar && escolaridade === '' }"
                                required>
                                    <option value="" disabled selected></option>
                                    @foreach($escolaridades as $escolaridadeOpcao)
                                        <option value="{{ $escolaridadeOpcao }}" 
                                            {{ old('escolaridade', $candidatos->escolaridade ?? '') == $escolaridadeOpcao ? 'selected' : ''}}>
                                            {{ $escolaridadeOpcao }}
                                        </option>
                                    @endforeach
                                </select>
                            <label for="id_escolaridade" class="label-floating">Selecione sua escolaridade</label>
                            <template x-if="tentouAvancar && escolaridade === ''">
                                    <span class="error-message">Campo obrigatório.</span>
                            </template>
                            </div>

                            <div class="bpo-col-8" style="position:relative">
                                <input
                                type="text" 
                                name="faculdade"
                                id="id_faculdade"
                                x-model="faculdade"
                                class="input-bpo input-floating"
                                :class="{ 'campo-obrigatorio': tentouAvancar && escolaridade === 'Ensino Superior' && faculdade === '' }"
                                placeholder=" "
                                :disabled="escolaridade !== 'Ensino Superior'">
                                <label for="id_faculdade" class="label-floating">Graduação</label>
                                <template x-if="escolaridade === 'Ensino Superior' && tentouAvancar && faculdade === ''">
                                    <span class="error-message">Campo obrigatório.</span>
                                </template>
                            </div>

                            <div class="bpo-col-8" style="position: relative">
                                <input 
                                type="text" 
                                name="curso"
                                id="id_curso"
                                class="input-bpo input-floating"
                                x-model="curso" 
                                placeholder="Curso técnico ou especialização">
                                <label for="id_curso" class="label-floating">
                                Outro curso
                                </label>
                            </div>

                            <div class="bpo-col-4" style="position:relative">
                                <select 
                                name="cnh"
                                id="id_cnh"
                                x-model="cnh"
                                class="select-bpo select-floating"
                                :class="{ 'campo-obrigatorio': tentouAvancar && cnh === '' }"
                                required>
                                    <option value="" disabled selected></option> 
                                    @foreach($categoriaCnh as $cnhOpcao)
                                        <option value="{{$cnhOpcao}}"
                                            {{old('cnh', $candidatos->cnh ?? '') == $cnhOpcao ? 'selected' : ''}}>
                                            {{$cnhOpcao}}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_cnh" class="label-floating">Categoria da CNH</label>
                                <template x-if="tentouAvancar && cnh === ''">
                                    <span class="error-message">Campo obrigatório.</span>
                                </template>
                            </div>


                            <div class="habilidades-section bpo-col-12"
                            :class="{ 'campo-obrigatorio': tentouAvancar && habilidades.length === 0 && !nenhuma }">
                                <label class="label-muted">Habilidades e Experiências:</label>
                                
                                <div class="grid-form habilidades-grid">
                                    
                                    @foreach($listaHabilidades as $valor => $texto)
                                        <div class="bpo-col-6">
                                            <label class="checkbox-item">
                                                <input
                                                    type="checkbox"
                                                    name="habilidades[]"
                                                    value="{{$valor}}"
                                                    x-model="habilidades"
                                                    :disabled="nenhuma"
                                                    @checked(in_array($valor, old('habilidades', $candidatos->habilidades ?? [])))
                                                >
                                                <span>{{$texto}}</span>
                                            </label>
                                        </div>
                                    @endforeach

                                    <div class="bpo-col-6">
                                        <label class="checkbox-item item-destaque">
                                            <input type="checkbox" name="habilidades_nenhuma" value="sim" 
                                                x-model="nenhuma" @change="if(nenhuma) habilidades = []">
                                            <span>Nenhuma das anteriores</span>
                                        </label>
                                    </div>
                                    
                                    <template x-if="tentouAvancar &&   habilidades.length === 0 && !nenhuma">
                                        <span class="error-message">Campo obrigatório.</span>
                                    </template>
                                    
                                </div>
                            </div>

                        </div>

                        <div class="form-footer">
                            <button type="button" 
                                    @click="passo = 1; window.scrollTo({ top: 0, behavior: 'smooth' })" 
                                    class="btn-back">
                                Voltar
                            </button>

                            <button type="button" 
                                    @click="irParaProximo()" 
                                    class="btn-primary">
                                Próximo
                            </button>
                        </div>
                    </div>

                    <div x-show="passo === 3" x-cloak x-transition>
                        <div class="form-header-step">
                            <h2 class="titulo-form">Histórico Profissional</h2>
                            <p class="subtitulo-form">Registre suas experiências anteriores e finalize sua inscrição.</p>
                        </div>

                        <div class="row-item" :class="{ 'campo-obrigatorio': tentouAvancar && (funcionario === '' || (funcionario === 'S' && (ano === '' || funcao === ''))) }">
                            <div class="pergunta-linha">
                                <div class="pergunta-coluna">
                                    <span class="pergunta-texto">Já trabalhou na Cox?</span>
                                    <div class="opcoes-radio">
                                        <label class="radio-item"><input type="radio" x-model="funcionario" name="funcionario" value="S"> Sim</label>
                                        <label class="radio-item"><input type="radio" x-model="funcionario" name="funcionario" value="N"> Não</label>
                                    </div>

                                </div>
                                <input type="text" 
                                name="ano"
                                id="id_ano"
                                x-model="ano" 
                                placeholder="Em qual ano?" 
                                class="input-bpo input-ano" 
                                :disabled="funcionario !== 'S'">
                                
                                <input type="text" 
                                name="funcao"
                                id="id_funcao"
                                x-model="funcao" 
                                placeholder="Qual cargo?" 
                                class="input-bpo input-cargo" 
                                :disabled="funcionario !== 'S'">
                            </div>
                        </div>

                        <div class="row-item" :class="{ 'campo-obrigatorio': tentouAvancar && (empregado === '' || (empregado === 'S' && empresaAtual === '')) }">
                            <div class="pergunta-linha">
                                <div class="pergunta-coluna">
                                    <span class="pergunta-texto">Trabalha atualmente?</span>
                                    <div class="opcoes-radio">
                                        <label class="radio-item"><input type="radio" x-model="empregado" name="empregado" value="S"> Sim</label>
                                        <label class="radio-item"><input type="radio" x-model="empregado" name="empregado" value="N"> Não</label>
                                    </div>
                                </div>
                                <input type="text" 
                                name="empresaAtual" 
                                id="id_empresa"
                                x-model="empresaAtual"
                                placeholder="Nome da empresa atual" 
                                class="input-bpo input-empresa" 
                                :disabled="empregado !== 'S'">
                            </div>
                        </div>

                        <div class="row-item" :class="{ 'campo-obrigatorio': tentouAvancar && (temParente === '' || (temParente === 'S' && (grauParente === '' || parente === ''))) }">
                            <div class="pergunta-linha">
                                <div class="pergunta-coluna">
                                    <span class="pergunta-texto">Tem parente na Cox?</span>
                                    <div class="opcoes-radio">
                                        <label class="radio-item">
                                            <input type="radio" x-model="temParente" name="temParente" value="S">
                                             Sim
                                            </label>
                                        <label class="radio-item">
                                            <input type="radio" x-model="temParente"  name="temParente" value="N"> 
                                            Não
                                        </label>
                                    </div>
                                </div>
                                
                                
                                <select 
                                name="grauParente"
                                id="id_grauParente"
                                x-model="grauParente"
                                class=" select-bpo input-grau" 
                                :class="{ 'campo-obrigatorio': tentouAvancar && grauParente === '' && temParente === 'S' }" 
                                :disabled="temParente !== 'S'"
                                required>
                                    
                                    <option value="" disabled selected>Parentesco</option>

                                    @foreach($parentes as $parenteOpcao)
                                        <option value="{{ $parenteOpcao }}" 
                                            {{ old('grauParente', $candidatos->grauParente ?? '') == $parenteOpcao ? 'selected' : '' }}>
                                            {{ $parenteOpcao }}
                                        </option>
                                    @endforeach
                                </select>
                                   
                                
                                <input type="text" 
                                    name="parente"
                                    id="id_parente"
                                    x-model="parente" 
                                    placeholder="Nome completo do familiar"
                                    class="input-bpo input-familiar" 
                                    :class="{ 'campo-obrigatorio': tentouAvancar && parente === '' && temParente === 'S' }"
                                    :disabled="temParente !== 'S'"
                                    value="{{ old('parente', $candidatos->parente ?? '') }}">

                                    
                                
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="button" @click="passo = 2; window.scrollTo({ top: 0, behavior: 'smooth' })" class="btn-back">
                                Voltar
                            </button>

                            <button type="submit" 
                                    class="btn-submit"
                                    :class="{ 'btn-disabled': !validaPasso3() }"
                                    :disabled="!validaPasso3()">
                                    Finalizar Inscrição
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>


    
   
</div>
@endsection