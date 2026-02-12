@extends('layouts.app')

@section('title', 'COX - Projetos')

@push('styles')

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Biblioteca de icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../../../html/css/blog.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" atualiza="false">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" atualiza="false">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js" atualiza="false"></script>

@endpush

@push('scripts-head')
    <!-- CSS only -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous" atualiza="false"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" atualiza="false"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" atualiza="false"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

@endpush



@section('conteudo')

        <div class="container py-4">
            <div class="projeto-banner-container">
                @if(!empty($p->link_dinamico))
                    <img src="{{ $p->link_dinamico }}" class="img-banner" alt="{{ $p->nomeBpo }}">
                @else
                    <img src="{{ asset('html\img\capa.png') }}" class="img-banner" alt="Imagem Padrão">
                @endif
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
                    @endforeach
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
                    <button class="btnVaga" onclick="window.location.href='/projetos/{{$p->FormId}}/questionario'">
                        <a href="/projetos/{{ $p->idProjeto }}/questionario" class="nav-link textVaga">Cadastrar</a>
                    </button>
                </div>
            </div>
            @endif
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


