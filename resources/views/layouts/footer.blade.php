<link rel="stylesheet" href="{{ asset('html/css/blog.css') }}">
<footer class="text-gray py-5" style="background-color: #283198; color: #d1d1d1;">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between">

            {{-- Links Rápidos --}}
            <div class="flex-fill px-3 mb-4 mb-md-0">
                <h5 class="fs-5 fw-semibold mb-3 text-white">Links Rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/" class="text-white text-decoration-none opacity-75">Início</a></li>
                    <li class="mb-2"><a href="#projetos" class="text-white text-decoration-none opacity-75">Projetos</a></li>
                    <li class="mb-2"><a href="#trabalheConosco" class="text-white text-decoration-none opacity-75">Trabalhe Conosco</a></li>
                    <li class="mb-2"><a href="#Contato" class="text-white text-decoration-none opacity-75">Contato</a></li>
                </ul>
            </div>

            {{-- Projetos --}}
            <div class="flex-fill px-3 mb-4 mb-md-0">
                <h5 class="fs-5 fw-semibold mb-3 text-white">Projetos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/" class="text-white text-decoration-none opacity-75">Curso de Caminhão</a></li>
                    <li class="mb-2"><a href="/" class="text-white text-decoration-none opacity-75">Curso Industrial</a></li>
                    <li class="mb-2"><a href="/" class="text-white text-decoration-none opacity-75">Curso de Trator</a></li>
                </ul>
            </div>

            {{-- Endereço --}}
            <div class="flex-fill px-3 mb-4 mb-md-0">
                <h5 class="fs-5 fw-semibold mb-3 text-white">Endereço da nossa unidade</h5>
                <a href="https://maps.google.com" class="text-white text-decoration-none opacity-75">
                    Fazenda Lagoa Formosa, s/n - Distrito Industrial, <br> 
                    São João da Boa Vista - SP, 13870-672
                </a>
            </div>

        </div>

        <div class="border-top border-secondary mt-4 pt-3 d-flex justify-content-center">
            <p class="text-footer mb-0">© {{ date('Y') }} Cox Energy. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>