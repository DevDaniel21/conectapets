<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas doações - Conecta Pets</title>
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

    // Só usuários logados acessam suas doações
    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php?acao=login');
        exit;
    }

    // Get posts do usuário logado
    $posts = controller_listarPostsUsuario();

    ?>

    <nav class="navbar fixed-top bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?acao=home">Conecta Pets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end bg-primary-subtle" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Conecta Pets</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 fs-4">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?acao=home">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php?acao=minhas_doacoes">Minhas doações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?acao=perfil">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSair">Sair da conta</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="d-flex flex-row justify-content-between align-items-center mb-4">
            <p class="fs-4 mb-0">Exibindo <?= htmlspecialchars(count($posts)) ?> doação(ões)</p>
            <a href="index.php?acao=cadastrar_post"><button type="button" class="btn btn-primary fw-semibold">Nova doação</button></a>
        </div>

        <!-- LISTA DE MINHAS DOAÇÕES -->
        <div class="d-flex flex-row justify-content-left align-items-center flex-wrap">
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
                                <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <h5 class="mb-0 text-dark"><?= htmlspecialchars($post['nome']) ?></h5>

                                <div class="d-flex align-items-center gap-3">
                                    <?php if ($post['sexo'] === 'Macho'): ?>
                                        <i class="bi bi-gender-male text-primary fs-4" title="Macho"></i>
                                    <?php elseif ($post['sexo'] === 'Fêmea'): ?>
                                        <i class="bi bi-gender-female text-danger fs-4" title="Fêmea"></i>
                                    <?php else: ?>
                                        <i class="bi bi-gender text-secondary fs-4" title="Sexo não definido"></i>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <!-- STATUS -->
                            <div class="mb-3">
                                <span class="badge <?= $post['status'] === 'Adotado' ? 'bg-success' : 'bg-primary' ?>">
                                    <?= htmlspecialchars(ucfirst($post['status'])) ?>
                                </span>
                            </div>

                            <!-- BOTÕES EDITAR E EXCLUIR -->
                            <div class="d-flex gap-2 w-100">
                                <a href="index.php?acao=editar_post&id=<?= htmlspecialchars($post['id']) ?>" class="btn btn-outline-primary flex-fill fw-semibold">
                                    Editar
                                </a>
                                <button type="button" class="btn btn-outline-danger flex-fill fw-semibold" data-bs-toggle="modal" data-bs-target="#modalExcluir<?= htmlspecialchars($post['id']) ?>">
                                    Excluir
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO (único modal permitido por card) -->
                <div class="modal fade" id="modalExcluir<?= htmlspecialchars($post['id']) ?>" tabindex="-1" aria-labelledby="modalExcluirLabel<?= htmlspecialchars($post['id']) ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5" id="modalExcluirLabel<?= htmlspecialchars($post['id']) ?>">Excluir doação</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja excluir a doação "<b><?= htmlspecialchars($post['nome']) ?></b>"? Esta ação não poderá ser desfeita.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="index.php?acao=excluir_post" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'exclusao'): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                Não foi possível excluir a doação. Tente novamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'atualizacao'): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                Não foi possível atualizar a doação. Tente novamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endif; ?>


        <!-- Sair da conta -->
        <div class="modal fade" id="modalSair" tabindex="-1" aria-labelledby="modalSairLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalSairLabel">Sair da conta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja sair da sua conta?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="index.php?acao=sair"><button type="button" class="btn btn-danger">Sair</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
