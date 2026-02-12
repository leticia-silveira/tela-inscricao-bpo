<!DOCTYPE html>
<html lang="pt-br">

<!-- HEADER GLOBAL - SITE -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="{{ asset('html/css/blog.css') }}">
    

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

    @stack('styles')
    @stack('scripts')
    
    <title>@yield('title', 'COX')</title>
</head>
<body>
    <header class="fixed-top bg-white shadow-sm">
        <nav class="navbar navbar-expand-md navbar-light bg-white container">
            <a href="/" class="me-3">
                <img src="/html/img/logoCox.png" alt="" style="width: 80px; height:auto">
            </a>

            <!-- Botão Mobile -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu"
                aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarMenu">
                <button class="close-menu" onclick="closeMenu()">&times;</button>
                <ul class="navbar-nav mx-auto mb-2 mb-md-0 text-center g-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium hover-primary transition" href="/">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium hover-primary transition" href="#projetos">Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium hover-primary transition" href="#trabalheConosco">Trabalhe Conosco</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium hover-primary transition" href="#Contato">Fale Conosco</a>
                    </li>
                </ul>

                <!-- Botões no mobile -->
                <div class="d-flex flex-column flex-md-row justify-content-center mt-2 mt-md-0">
                    <a href="/menu/logar" class="btn btn-custom mr-4 mb-2">Entrar</a>
                    <a href="/curriculo/criar" class="btn btn-custom cad mr-4 mb-2">Cadastrar</a>
                </div>
            </div>
        </nav>
    </header>

</body>