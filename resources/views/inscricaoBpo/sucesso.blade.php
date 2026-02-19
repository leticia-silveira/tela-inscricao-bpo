<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição finalizada</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('html/css/inscricaoBpo.css') }}">
</head>
<body>
    <div class="wrapper-principal">
        <main class="success-container">
            <div class="card-sucesso">
                <i class="bi bi-check2-circle success-icon"></i>
                <h1 class="success-title">Inscrição Recebida!</h1>
                
                <div class="message-box">
                    <p>Sua inscrição no <strong>projeto {{ str_replace('-', ' ', $tipo) }}</strong> foi registrada com sucesso em nossa base de dados.</p>
                    <p><strong>Próximos passos:</strong> Nossa equipe analisará seu perfil técnico e profissional. Caso você seja selecionado(a) para a próxima etapa, entraremos em contato através dos canais informados.</p>
                </div>
                
                
                <!-- <a href="{{ url('/projeto/' . $tipo) }}" class="btn-back-success"> -->
                <a href="{{ url('/') }}" class="btn-back-success">
                    Voltar para o início
                </a>
            </div>
        </main>
    </div>
</body>
</html>