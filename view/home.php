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
        <?php
            // Gera tag html de imagem usando Cloudinary com transform
            $imgTag = $cld->ImageTag($public_id)
                ->resize(Resize::scale()
                    ->width(400)
            );
            
            echo $imgTag;
        ?>
        <p>Pet</p>

        <?php if (isset($_SESSION['usuario']['nome'])): ?>
            <p>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?></p>
            <a href="index.php?acao=sair"><button type="button" class="btn btn-secondary">Sair da conta</button></a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir">
                Excluir conta
            </button>
        <?php endif; ?>

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
