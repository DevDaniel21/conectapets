<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>

<body>
    <?php

    require_once __DIR__ . '/../config/session.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../controller/postAdocaoController.php';

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

    // Get posts
    $posts = controller_listarPosts();

    $public_id = "kbdgtb4oev3pup30r6dp"; // Vai pegar o public_id do banco de dados
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

        <div class="d-flex flex-row justify-content-center align-items-center flex-wrap">
            <?php foreach ($posts as $post): ?>
                <div class="p-2 flex-shrink-0" style="width: 290px;">
                    <div class="card border-0 rounded-4 shadow overflow-hidden">
                        <?php
                        $cardImg = $cld->ImageTag($post['foto'])
                            ->setAttributes([
                                'height' => '290',
                                'class' => 'card-img-top object-fit-cover',
                                'draggable' => 'false',
                                'alt' => 'Pet para adoção',
                                'loading' => 'lazy'
                            ])
                            ->resize(
                                Resize::scale()
                                    ->width(320)
                            );
                        echo $cardImg;
                        ?>
                        <div class="card-body p-3">

                            <p class="text-uppercase text-primary small mb-3">
                                Daniel Custódio
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <h5 class="mb-0 text-dark"><?= htmlspecialchars($post['nome']) ?></h5>

                                <div class="d-flex align-items-center gap-3">
                                    <?php if ($post['sexo'] == 'Macho'): ?>
                                        <i class="bi bi-gender-male text-primary fs-4"></i>
                                    <?php else: ?>
                                        <i class="bi bi-gender-female text-danger fs-4"></i>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <a href="#" class="btn btn-primary text-white w-100 fw-semibold">
                                Quero adotar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Excluir -->
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