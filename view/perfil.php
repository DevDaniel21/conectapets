<?php

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../controller/userController.php';

// Dados do usuário logado
$usuario = controller_buscarPerfil();

// Mensagens de retorno
$sucesso = $_SESSION['perfil_sucesso'] ?? null;
$erro = $_SESSION['perfil_erro'] ?? null;
unset($_SESSION['perfil_sucesso'], $_SESSION['perfil_erro']);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Conecta Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>
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
                            <a class="nav-link" href="#">Suas doações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php?acao=perfil">Perfil</a>
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
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <p class="fs-4">Meu perfil</p>

                <!-- MENSAGEM DE SUCESSO -->
                <?php if ($sucesso): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($sucesso) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>
                <!-- MENSAGEM DE ERRO -->
                <?php if ($erro): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($erro) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 rounded-4 shadow overflow-hidden">
                    <div class="card-body p-4">
                        <form action="index.php?acao=atualizar_perfil" method="POST" class="was-validated">
                            <!-- NOME -->
                            <div class="mb-3">
                                <label for="nome" class="form-label text-uppercase text-primary small">Nome</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="mb-3">
                                <label for="email" class="form-label text-uppercase text-primary small">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?= htmlspecialchars($usuario['email']) ?>" required>
                                </div>
                            </div>

                            <!-- TELEFONE -->
                            <div class="mb-3">
                                <label for="telefone" class="form-label text-uppercase text-primary small">Telefone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="telefone" name="telefone"
                                        value="<?= htmlspecialchars($usuario['telefone']) ?>"
                                        placeholder="(11) 91234-5678" required>
                                </div>
                                <div class="form-text">Usado para os interessados entrarem em contato com você.</div>
                            </div>

                            <hr class="my-4">

                            <!-- SENHA -->
                            <p class="text-uppercase text-primary small mb-2">Alterar senha</p>
                            <p class="text-muted small">Deixe em branco para manter a senha atual.</p>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Nova senha (minímo 6 caracteres)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="senha" name="senha"
                                        minlength="6" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="confirmar_senha" class="form-label">Confirmar nova senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha"
                                        minlength="6" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir">
                                    Excluir conta
                                </button>
                            </div>


                            <div class="d-flex flex-row justify-content-between gap-2">
                                <a href="index.php?acao=home" class="btn btn-secondary w-50">Cancelar</a>
                                <button type="submit" class="btn btn-primary fw-semibold w-50">Salvar alterações</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- SAIR -->
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

        <!-- EXCLUIR -->
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