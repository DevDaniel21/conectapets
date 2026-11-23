<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php

    require_once __DIR__ . '/../config/session.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    use Dotenv\Dotenv;
    use Cloudinary\Configuration\Configuration;
    use Cloudinary\Cloudinary;
    use Cloudinary\Transformation\Resize;

    // Load .env
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    // Init config and Create Cloudinary
    $config = new Configuration($_ENV['CLOUDINARY_URL']);
    $cld = new Cloudinary($config);

    $public_id = "main-sample"; // Vai pegar o public_id do banco de dados
    ?>
    <div class="container py-4">
        <?php if (isset($_SESSION['usuario']['nome'])): ?>
            <p>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?></p>
            <a href="index.php?acao=cadastrar_post"><button type="button" class="btn btn-primary">Cadastrar Pet para Adoção</button></a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir">
                Excluir conta
            </button>
            <a href="index.php?acao=sair"><button type="button" class="btn btn-secondary">Sair da conta</button></a>
        <?php endif; ?>

        <!-- Card de exemplo: Post de Adoção -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <?php
                        $cardImg = $cld->ImageTag($public_id)
                            ->setAttributes([
                                'class' => 'card-img-top',
                                'alt' => 'Pet para adoção',
                                'loading' => 'lazy'
                            ])
                            ->resize(Resize::scale()
                                ->width(400)
                            );
                        echo $cardImg;
                    ?>
                    <div class="card-body">
                        <h5 class="card-title">Amarelinho</h5>
                        <p class="card-text">
                            <strong>Espécie:</strong> Gato<br>
                            <strong>Idade:</strong> 1 ano<br>
                            <strong>Sexo:</strong> Macho<br>
                            <strong>Status:</strong> Disponível<br>
                            <strong>Publicado em:</strong> 23/11/2026 02:40
                        </p>
                        <span class="badge bg-success">Disponível</span>
                    </div>
                    <div class="card-footer text-muted small">
                        ID: 1 | Usuário ID: 1
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmação de exclusão (padrão Bootstrap 5.3) -->
        <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalExcluirLabel">Excluir conta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir sua conta? Esta ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="index.php?acao=excluir_conta"><button type="button" class="btn btn-danger">Excluir</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
