@extends('layouts.app')

@section('title', 'Nossas Vagas')

@push('styles')
@endpush


@push('scripts-head')
@endpush

   



    
@section('conteudo')
    <div class="vagas">
        <!-- Parte inicial da página, input pesquisar vagas -->
        <section class="viewVagas">
            <div class="pesquisa">
                <div>
                    <h5 class="txtTitulo">NOSSAS VAGAS</h5>
                    <p class="txt">Venha fazer parte da nossa equipe! </p>
                </div>

                @if (count($vagas) > 0)
                <div class="search-container inputPesquisar">
                    <input class="input-vaga" type="text" id="vagaPesquisar" placeholder="Pesquisar vaga">
                    <button type="button" onclick="pesquisar()" class="btn btn-light"
                        style="position: absolute; right: 0; top: 0px; height: 50%; border: none; background: transparent;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </section>

        <!-- Container das vagas -->
        <section class="listaVagas">
            @if (count($vagas) > 0)
            @foreach($vagas as $c)
            <div class="containerVaga">
                <div class="p-2 g-col-6 align-items: center; justify-content: center;">
                    <p class="txtTituloVaga">{{$c->descricaoVaga}}</p>
                    <p style="font-size: 15px;">Quantidade de vaga(s): {{$c->quantidadeVagas}} </p>

                    <div class="icones">

                        <div class="vagaIcones">
                            <img class="imgIcone" src="/html/img/salario.png" alt="">
                            <p style="font-size: 14px;">A combinar</p>
                        </div>

                        <div class="vagaIcones">
                            <img class="imgIcone" src="/html/img/funcao.png" alt="">
                            <p style="font-size: 14px;">{{$c->tipo}}</p>
                        </div>

                        <!-- <div class="vagaIcones">
                            <img class="imgIcone" src="/html/img/local.png" alt="">
                            <p style="font-size: 14px;">{{$c->area}}</p>
                        </div> -->

                        <div class="vagaIcones">
                            @php
                                // Usamos mb_strtolower para garantir que o 'Í' maiúsculo vire 'í' minúsculo
                                $area = mb_strtolower($c->area, 'UTF-8'); 
                            @endphp

                            @if(str_contains($area, 'industria') || str_contains($area, 'indústria'))
                                <img class="imgIcone" src="/html/img/industria.png" alt="Indústria">
                            @elseif(str_contains($area, 'agricola') || str_contains($area, 'agrícola'))
                                <img class="imgIcone" src="/html/img/agricola.png" alt="Agrícola">
                            @elseif(str_contains($area, 'administrativo'))
                                <img class="imgIcone" src="/html/img/adm.png" alt="Administrativo">
                            @else
                                <img class="imgIcone" src="/html/img/local.png" alt="Local">
                            @endif

                            <p style="font-size: 14px;">{{$c->area}}</p>
                        </div>
                    </div>
                    <div class="containerParteBaixo">
                        <div style="width: 90%; margin: auto; padding: 20px ">
                            <button class="btnVaga">
                                <a href="/vaga/requisitos/{{$c->idVaga}}" class="nav-link textVaga">DESCRIÇÃO DA VAGA</a>
                            </button>
                        </div>

                    </div>
                    <div class="divVaga">
                        <i class="fa-regular fa-calendar"></i>
                        @if ($c->quantidadeDias == 1 )
                        <p style="font-size: 14px;">Falta {{$c->quantidadeDias}} dia para encerrar a candidatura </p>
                        @else
                        <p style="font-size: 14px;">Faltam {{$c->quantidadeDias}} dias para encerrar a candidatura </p>
                        @endif
                    </div>
                </div>

            </div>

            @endforeach
            @else
            <div>
                <div class="g-col-6 align-items: center; justify-content: center;">
                    <p style="font-size: 14px;">Nenhuma vaga disponível no momento.</p>
                </div>
            </div>
            @endif

        </section>

        <!-- Container envio de curriculo  -->
        <section>
            <div>
                <div>
                    <p class="txtTitulo">CADASTRE SEU CURRÍCULO</p>
                    <p class="txt">Caso não encontrou a vaga que esteja procurando, cadastre seu currículo no nosso banco de talentos.</p>

                    <div class="containerParteBaixoCurriculo">
                        <div class="btnCadastrar">
                            <button  class="btnVaga cad">
                                <a href="/curriculo/criar" class="nav-link textVaga">CADASTRAR</a>
                            </button>
                        </div>
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

    function pesquisar() {
        const termo = document.getElementById('vagaPesquisar').value.toLowerCase().trim();
        const vagas = document.querySelectorAll('.containerVaga');
        let encontrouAlgo = false;

        // Remove a mensagem anterior (se existir)
        const mensagemExistente = document.getElementById('mensagemNenhumaVaga');
        if (mensagemExistente) {
            mensagemExistente.remove();
        }

        // Se o campo estiver vazio, mostra todas as vagas e sai
        if (termo === '') {
            vagas.forEach(vaga => {
                vaga.style.display = 'block';
            });
            return;
        }

        // Filtra as vagas (busca a partir de 1 caractere)
        vagas.forEach(vaga => {
            const textoVaga = vaga.textContent.toLowerCase();
            if (textoVaga.includes(termo)) {
                vaga.style.display = 'block';
                encontrouAlgo = true;
            } else {
                vaga.style.display = 'none';
            }
        });

        // Mostra mensagem "Nenhuma vaga encontrada" apenas se não houver resultados
        if (!encontrouAlgo) {
            const listaVagas = document.querySelector('.listaVagas');
            const novaMensagem = document.createElement('div');
            novaMensagem.id = 'mensagemNenhumaVaga';
            novaMensagem.className = 'containerVaga';
            novaMensagem.innerHTML = `
            <div class="p-2 g-col-6">
                <p class="txt">Nenhuma vaga encontrada com o termo "${termo}"</p>
            </div>
        `;
            listaVagas.appendChild(novaMensagem);
        }
    }

    // Configura os eventos
    document.getElementById('vagaPesquisar').addEventListener('input', pesquisar);
    document.querySelector('.search-container button').addEventListener('click', pesquisar);
    document.getElementById('vagaPesquisar').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            pesquisar();
        }
    });


    document.querySelectorAll('.vagaIcones p').forEach(elemento => {
        // Aplica a formatação ao texto do elemento
        elemento.textContent = formatarTexto(elemento.textContent);
    });

    function formatarTexto(texto) {
        texto = texto.toLowerCase();
        return texto.replace(/\b\w/g, letra => letra.toUpperCase());
    }
</script>

@endpush