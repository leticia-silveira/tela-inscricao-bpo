@extends('layouts.app')
@section('title', 'COX')

@push('styles')
@endpush

@push('head_scripts')
@endpush




    

@section('conteudo')
    <!-- <main style="margin-bottom: 5%;"> -->
        <!-- Parte inicial: Imagem -->
        <!-- <section id="imagemPrincipal" class="d-flex align-items-center justify-content-center">
            <h1 class="text-white display-4 textImagem-custom">SOMOS COX</h1>
        </section> -->


        <!-- Trabalhe Conosco -->
        <!-- <section id="imagemCarreiras" style="display: flex; align-items: center; justify-items: start;">

            <div class="texto" data-aos="fade-up">
                <h3 class="txtTitulo-custom" style="line-height: 2.0; padding-top: 8%;">TRABALHE CONOSCO</h3>
                <p style="color: white;" style="line-height: 2.0;">VENHA FAZER PARTE DA NOSSA EQUIPE! </p>
                <div style="margin-top: 20px;">
                    <a href="/vaga" class="nav-link btnPequenoVaga">NOSSAS VAGAS</a>
                </div>
            </div>

        </section> -->

        <section id=imagemCarreiras class="secao-trrabalhe-conosco">
            <div class="container">
                <div class="conteudo-carreiras">
                    <div class="texto-carreiras" data-aos="fade-right">
                        <h3 class="txtTitulo-custom">TRABALHE CONOSCO</h3>
                        <p class="txtSubtitulo-carreiras">VENHA FAZER PARTE DA NOSSA EQUIPE!</p>
                        <div class="acao-carreiras">
                            <a href="/vaga" class="btnPequenoVaga">NOSSAS VAGAS</a>
                        </div>
                    </div>

                    <div class="banner-carreiras" data-aos="fade-left">
                        <img src="{{ asset('html/img/trabalheConosco.png') }}" alt="Trabalhe Conosco">
                    </div>



                </div>
            </div>
        </section>



        <section id="projetos" class="py-4">
            <div class="container ">
                <div class="mb-5" data-aos="fade-up">
                    <div data-aos="fade-up">
                        <h4 ch3 class="txtTitulo-custom">PROJETOS</h4>
                        <p class="txtSubtitulo">TRANSFORME SEU FUTURO CONOSCO!</p>
                        <p class="mx-auto mt-1 ">Todos os anos, capacitamos dezenas de pessoas com treinamentos especializados que abrem portas para oportunidades reais em nossa equipe.</p>
                        <p class="mx-auto mt-1">Você vai ter desenvolvimento profissional com certificação, aprendizado prático com especialistas do mercado e a chance de fazer parte de um time de sucesso. </p>
                        <p class="mx-auto mt-1">Fique atento às nossas inscrições! Novas turmas são abertas anualmente com vagas limitadas.</p>
                        <h6 class="mx-auto mt-1">Sua carreira merece esse impulso!</h6>
                    </div>

                    <div class="row gx-5 gy-4 py-4" id="projetos-lista" data-aos="fade-right">

                        @php
                        $projetosAtivosCount = 0;
                        // Conta projetos ativos
                        foreach($projetos as $p) {
                        if($p->statusProjeto != 0) {
                        $projetosAtivosCount++;
                        }
                        }
                        @endphp
                        @php $activeIndex = 0; @endphp
                        @foreach($projetos as $index => $p)
                        @if($p->statusProjeto != 0)

                        <div class="col-12 col-md-6 col-lg-4 rounded-3 py-2 mb-4 overflow-hidden feature-card transition duration-300 feature-card projeto-card {{ $activeIndex >= 3 ? 'escondido' : '' }}" id="projeto-{{ $activeIndex }}" data-aos="fade-up" data-aos-delay="300">
                        
                            <div class="card h-100 shadow-sm p-0">
                                <img src="{{ $p->imagem }}"
                                    class="imgProjeto"
                                    alt="Imagem do Projeto">

                                <div class="card-body d-flex flex-column" data-aos="fade-left">
                                    <p class="txtBpo">{{ $p->nomeBpo }}</p>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ $p->status }}
                                    </p>
                                    <p class="txtNegrito">Curso gratuito.</p>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="/projeto/{{ $p->tipo }}"
                                            class="fw-semibold text-decoration-none btnPequeno bpo transition">
                                            Saiba mais
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $activeIndex++; @endphp
                        @endif
                        @endforeach
                    </div>

                    @if($projetosAtivosCount> 3)
                    <div class="text-center mt-4">
                        <button class="btn btn-vertodos px-4 py-2" onclick="mostrarTodosProjetos()" id="botao-ver-mais">
                            Ver todos
                        </button>
                    </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- Fale conosco -->
        <section id="Contato" >
            <div class="containerContato">
                <div class="esquerdaContato">

                    <div class="frameMap">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d7402.491000994602!2d-46.9255257!3d-21.9251116!3m2!1i1024!2i768!4f13.1!2m1!1susina%20s%C3%A3o%20jo%C3%A3o%20da%20boa%20vista%20abengoa!5e0!3m2!1spt-BR!2sbr!4v1743163241277!5m2!1spt-BR!2sbr"
                            class="map" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    

                    <div class="principalContato" data-aos="fade-left">
                        <div class="textoContato">
                            <h5 class="txtContato">FALE CONOSCO</h5>
                        </div>

                        
                        <div class="divContato">
                            <!-- <i class="fa-solid fa-envelope color-primary"></i> -->
                             <img src="{{ asset('html/img/envelope.png') }}" alt="E-mail" class="icone-contato-img">
                            <a href="mailto:selecao@abbr.agr.br" class="nav-link nav-link-contato textTamanho">selecao@abbr.agr.br</a>
                        </div>

                        <div class="divContato">
                            <!-- <i class="fa-solid fa-phone color-primary"></i> -->
                             <img src="{{ asset('html/img/telefone.png') }}" alt="Telefone" class="icone-contato-img">
                            <a href="tel:+551936023200" class="nav-link nav-link-contato textTamanho">(19) 3602-3200</a>
                        </div>
                        

                    </div>
                </div>
            </div>
        </section>

    <!-- </main> -->

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
                if (window.innerWidth < 750) {
                    navbarCollapse.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.carrossel-track');
        const slides = document.querySelectorAll('.containerProjeto');
        const indicadoresContainer = document.querySelector('.carrossel-indicadores');

        // Calcula a largura do slide incluindo o gap
        const gap = parseInt(window.getComputedStyle(track).gap) || 0;
        const slideWidth = slides[0].offsetWidth + gap;

        let currentIndex = 0;
        const maxIndex = slides.length - 1;

        // Cria os indicadores
        function criarIndicadores() {
            slides.forEach((_, index) => {
                const indicador = document.createElement('div');
                indicador.classList.add('carrossel-indicador');
                if (index === 0) indicador.classList.add('ativo');

                indicador.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                });

                indicadoresContainer.appendChild(indicador);
            });
        }

        function updateCarousel() {
            // Movimento suave do carrossel
            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

            // Atualiza indicadores
            const indicadores = document.querySelectorAll('.carrossel-indicador');
            indicadores.forEach((ind, idx) => {
                ind.classList.toggle('ativo', idx === currentIndex);
            });
        }

        function nextSlide() {
            if (currentIndex < maxIndex) {
                currentIndex++;
            } else {
                currentIndex = 0; // Volta para o primeiro slide
            }
            updateCarousel();
        }

        function prevSlide() {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = maxIndex; // Vai para o último slide
            }
            updateCarousel();
        }

        // Inicialização
        criarIndicadores();
        updateCarousel();

        // Controle por touch (mobile)
        let startX;
        track.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            track.style.transition = 'none'; // Remove transição durante o arrasto
        }, {
            passive: true
        });

        track.addEventListener('touchmove', (e) => {
            const currentX = e.touches[0].clientX;
            const diff = startX - currentX;
            track.style.transform = `translateX(calc(-${currentIndex * slideWidth}px - ${diff}px))`;
        }, {
            passive: true
        });

        track.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (diff > 50) nextSlide(); // Swipe para esquerda → avança
            if (diff < script - 50) prevSlide(); // Swipe para direita ← volta

            track.style.transition = 'transform 0.5s ease-in-out';
        }, {
            passive: true
        });

        // Auto-play opcional (descomente se quiser)
        setInterval(nextSlide, 5000);
    });

    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Mobile menu toggle
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');

        const icon = this.querySelector('i');
        if (menu.classList.contains('hidden')) {
            feather.replace();
        } else {
            icon.setAttribute('data-feather', 'x');
            feather.replace();
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });


                const mobileMenu = document.getElementById('mobile-menu');
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    const menuToggle = document.getElementById('menu-toggle');
                    const icon = menuToggle.querySelector('i');
                    icon.setAttribute('data-feather', 'menu');
                    feather.replace();
                }
            }
        });
    });

    function closeMenu() {
        $('#navbarMenu').collapse('hide');
    }


    // Fecha o menu quando clicar em um link (opcional)
    // $('.nav-link').on('click', function() {
    //     if (window.innerWidth < 500) {
    //         closeMenu();
    //     }
    // });

    // // Adiciona funcionalidade ao botão toggler existente
    // $('.navbar-toggler').on('click', function() {
    //     const isExpanded = $(this).attr('aria-expanded') === 'true';
    //     if (isExpanded) {
    //         closeMenu();
    //     }
    // });


    // Adiciona funcionalidade ao botão toggler existente
    $('.navbar-toggler').on('click', function() {
        const isExpanded = $(this).attr('aria-expanded') === 'true';
        if (isExpanded) {
            closeMenu();
        }
    });

    function mostrarTodosProjetos() {
        // Pega todos os elementos com classe 'escondido'
        var elementos = document.getElementsByClassName('escondido');

        // Converte para array e remove a classe de cada um
        var lista = Array.from(elementos);

        lista.forEach(function(elemento) {
            elemento.classList.remove('escondido');
        });

        // Esconde o botão
        var botao = document.getElementById('botao-ver-mais');
        if (botao) {
            botao.style.display = 'none';
        }
    }
</script>
@endpush

<script>
    feather.replace();
</script>