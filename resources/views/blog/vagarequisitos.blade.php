@extends('layouts.app')

@section('title', 'Nossas Vagas')

@push('styles')
@endpush

@push('scripts-head')
@endpush



@section('conteudo')
    
    <div class="requisitos">
        <!-- Parte inicial da página, input pesquisar vagas -->
        <section style="margin-top: 5%;">
            @foreach($vagas as $c)
            <div>
                <h4 class="txtTituloRequisitos">VAGA: {{$c->descricaoVaga}}</h4>
                <p class="txtCidade">CIDADE: Vargem Grande do Sul</p>


                <div class="mb-5">
                    <p class="txtReqSub">REQUISITOS</p>
                    <p>{!! $c->requisitos !!}</p>
                </div>

                <div class="mb-5">
                    <p class="txtReqSub">ATIVIDADES</p>
                    <p>{!! $c->atividades !!}</p>
                </div>

                <div class="mb-5">
                    <p class="txtReqSub">CONDIÇÕES</p>
                    <p>{!! $c->condicoes !!}</p>
                </div>

                <div class="mb-5">
                    <p class="txtReqSub" style="padding-top: 35px; text-align: center; margin-bottom: 30px;">BENEFÍCIOS</p>
                </div>

                <div class="iconesBeneficios">
                    @foreach ($beneficios as $index => $beneficio)
                    <div class="beneficio-item">

                        @if($beneficio->imagem)
                        <img src="{{ $beneficio->imagem }}" alt="Benefício">
                        @endif

                        @if($beneficio->descricao != "TODOS")
                        <p class="txt-beneficio">
                            {{$beneficio->descricao}}
                        </p>
                        @endif
                    </div>
                    @endforeach
                </div>

                @endforeach
        </section>




        <!-- Container envio de curriculo  -->
        <section>

            <div>
                <div class="containerCandidatar">
                    <div class="btnCadastrar">
                        <button class="btnVaga cad">
                            <a href="/curriculo/criar?funcao={{ urlencode($c->descricaoVaga) }}&local={{ urlencode($c->descricaoLocal) }}&vaga_especifica=1" class="nav-link textVaga">
                                CANDIDATAR
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    
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