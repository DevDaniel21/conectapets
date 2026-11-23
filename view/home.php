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
    $post_modal = null;

    // Verifica se tem post_adocao_id para abrir modal
    $post_adocao_id = $_GET['post_adocao_id'] ?? null;
    if ($post_adocao_id) {
        $post_modal = buscarPostPorId($post_adocao_id);
    }

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
                            <a class="nav-link active" aria-current="page" href="index.php?acao=home">Início</a>
                        </li>
                        <?php if (isset($_SESSION['usuario']['nome'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Suas doações</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?acao=perfil">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="modal" data-bs-target="#modalSair">Sair da conta</button>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container mt-5 pt-5">
        <div class="d-flex flex-row justify-content-between">
            <p class="fs-4">Exibindo <?= htmlspecialchars(count($posts)) ?> doações</p>
            <?php if (isset($_SESSION['usuario']['nome'])): ?>
                <!-- <p class="fs-5">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?></p> -->
                <a href="index.php?acao=cadastrar_post"><button type="button" class="btn btn-primary fw-semibold">Quero doar</button></a>
            <?php endif; ?>

        </div>

        <!-- LISTA DE DOAÇÕES -->
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
                                <?= htmlspecialchars($post['usuario_nome']) ?>
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

                            <a href="index.php?acao=home&post_adocao_id=<?= htmlspecialchars($post['id']) ?>" class="btn btn-primary text-white w-100 fw-semibold">
                                Quero adotar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($post_modal): ?>
            <div class="modal fade show d-block" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content flex-row overflow-hidden" style="max-height: 50vh;">
                        <?php
                        $cardImg = $cld->ImageTag($post_modal['foto'])
                            ->setAttributes([
                                'class' => 'w-50 h-100 object-fit-cover',
                                'draggable' => 'false',
                                'alt' => 'Pet para adoção',
                                'loading' => 'lazy'
                            ]);
                        echo $cardImg;
                        ?>
                        <div class="modal-body w-50 flex-shrink-0 overflow-auto p-4">

                            <!-- TOPO: usuário + fechar -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <p class="text-uppercase text-primary small mb-0">
                                    <?= htmlspecialchars($post_modal['usuario_nome']) ?>
                                </p>
                                <!-- FECHAR MODAL -->
                                <a href="index.php?acao=home" class="btn-close" aria-label="Fechar"></a>
                            </div>

                            <!-- NOME + SEXO -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0 text-dark fw-semibold"><?= htmlspecialchars($post_modal['nome']) ?></h5>

                                <?php if ($post_modal['sexo'] == 'Macho'): ?>
                                    <i class="bi bi-gender-male text-primary fs-4" title="Macho"></i>
                                <?php else: ?>
                                    <i class="bi bi-gender-female text-danger fs-4" title="Fêmea"></i>
                                <?php endif; ?>
                            </div>

                            <!-- IDADE APROXIMADA -->
                            <div class="mb-3">
                                <small class="text-muted d-block">Idade aproximada</small>
                                <span><?= htmlspecialchars($post_modal['idade']) ?></span>
                            </div>

                            <!-- ESPÉCIE -->
                            <div class="mb-3">
                                <small class="text-muted d-block">Espécie</small>
                                <span><?= htmlspecialchars($post_modal['especie']) ?></span>
                            </div>

                            <?php
                            // Remove tudo que não for número
                            $telefone = preg_replace('/\D/', '', $post_modal['usuario_telefone']);
                            // Remove o 0 inicial do DDD, se existir (ex.: 011... -> 11...)
                            $telefone = ltrim($telefone, '0');
                            // Adiciona o código do Brasil se ainda não tiver
                            if (!str_starts_with($telefone, '55')) {
                                $telefone = '55' . $telefone;
                            }
                            // Mensagem pré-preenchida (opcional)
                            $mensagem = "Olá! Vi o " . $post_modal['nome'] . " no Conecta Pets e tenho interesse em adotar.";
                            $linkWhatsapp = "https://wa.me/{$telefone}?text=" . urlencode($mensagem);
                            ?>

                            <!-- TELEFONE + BOTÃO QUERO ADOTAR -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted d-block">Telefone para contato</small>
                                    <a href="tel:<?= preg_replace('/\D/', '', $post_modal['usuario_telefone']) ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($post_modal['usuario_telefone']) ?>
                                    </a>
                                </div>

                                <a href="<?= htmlspecialchars($linkWhatsapp) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-warning text-white fw-semibold px-4">
                                    Quero adotar
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-backdrop fade show"></div>
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