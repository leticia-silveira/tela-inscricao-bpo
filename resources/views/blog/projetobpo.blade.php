@extends('layouts.app')

@section('title', 'COX - Projetos')

@push('styles')
@endpush

@push('scripts-head')   
@endpush



@section('conteudo')

        <div class="container py-4">
            <div class="container-bpo-img">
                <div class="projeto-banner-container">
                    @if(!empty($p->link_dinamico))
                        <img src="{{ $p->link_dinamico }}" class="img-banner" alt="{{ $p->nomeBpo }}">
                    @else
                        <img src="{{ asset('html\img\capa.png') }}" class="img-banner" alt="Imagem Padrão">
                    @endif
                </div>
            </div>

            <div>
                <section>
                    @foreach ($projetos as $p)
                    <div>
                        <h5 class="txtContato">{{$p->nomeBpo}}</h5>
                        <p class="txtCidade">CIDADE: {{$p->cidade}} </p>
                    </div>

                    <div style="margin-bottom: 3%;">
                        {!! $p->explicacaoProjeto !!}
                    </div>

                    <!-- <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">PRÉ-REQUISITOS</p>
                        {!! $p->requisitos !!}
                    </div> -->

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">PRÉ-REQUISITOS</p>
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            @php
                                // 1. Limpa qualquer tag HTML residual e resolve o "mínimo" (entidades)
                                $textoBase = html_entity_decode(strip_tags($p->requisitos));
                                
                                // 2. Quebra o texto pelo ponto final
                                $requisitos = explode('.', $textoBase);
                            @endphp

                            @foreach($requisitos as $requisito)
                                @php $item = trim($requisito); @endphp
                                
                                @if(!empty($item))
                                    <li style="margin-bottom: 6px;">{{ $item }}.</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">PERÍODO DAS INSCRIÇÕES</p>
                        <p>As inscrições ocorrerão no período de <span style="font-weight: bold;">{{ date('d/m/Y', strtotime($p->dataInicio)) }} a {{ date('d/m/Y', strtotime($p->dataFim)) }}.</span></p>
                    </div>

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">CRITÉRIOS PARA CLASSIFICAÇÃO</p>
                        <p>{!! $p->criterios !!}</p>
                    </div>

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">APROVAÇÃO NO CURSO BPO</p>
                        <p>{!! $p->aprovacao !!}</p>
                    </div>

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">CERTIFICAÇÃO</p>
                        <p>{!! $p->certificacao !!}</p>
                    </div>

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">OPORTUNIDADE</p>
                        <p>{!! $p->oportunidade !!}</p>
                    </div>

                    <div style="margin-bottom: 3%;">
                        <p class="txtReqSub">DISPOSIÇÕES GERAIS</p>
                        <p>{!! $p->disposicoesGerais !!}</p>
                    </div>
                    
                </section>

            </div>
        </div>


        <!--   Botão para teste -->
        <!-- <div class="containerCandidatar">
            <div class="btnCadastrar">
                <button class="btnVaga">
                    <a href="/projetos/{{ $tipo }}/questionario" class="nav-link textVaga">
                        CADASTRAR
                    </a>
                </button>
            </div>
        </div> -->

        <!-- Só aparece o botão para se candidatar no projeto se as inscrições estiverem abertas -->
        <section>
            @if($p->status !== 'Finalizado')
            <div class="containerCandidatar">
                <div class="btnCadastrar">
                    <button class="btnVaga cad" onclick="window.location.href='/projetos/{{$p->FormId}}/questionario'">
                        <a href="/projetos/{{ $p->idProjeto }}/questionario" class="nav-link textVaga">Cadastrar</a>
                    </button>
                </div>
            </div>
            @endif

            @endforeach
        </section>
@endsection



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        const closeButton = document.querySelector('.close-menu');

        navbarToggler.addEventListener('click', function() {
            navbarCollapse.classList.add('show');
            document.body.style.overflow = 'hidden'; // Impede scroll quando menu aberto
        });

        closeButton.addEventListener('click', function() {
            navbarCollapse.classList.remove('show');
            document.body.style.overflow = ''; // Restaura scroll
        });

        // Fecha o menu quando um link é clicado
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    navbarCollapse.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    });
</script>
@endpush


