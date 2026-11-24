<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar doação - Conecta Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php

    require_once __DIR__ . '/../config/session.php';
    require_once __DIR__ . '/../controller/postAdocaoController.php';

    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php?acao=login');
        exit;
    }

    $id = $_GET['id'] ?? null;
    $post = null;

    if ($id) {
        $post = controller_buscarPostPorId($id);
        if (!$post || $post['usuario_id'] != $_SESSION['usuario']['id']) {
            header('Location: /conectapets/index.php?acao=minhas_doacoes');
            exit;
        }
    } else {
        header('Location: /conectapets/index.php?acao=minhas_doacoes');
        exit;
    }

    ?>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center py-5">
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 450px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Editar doação</h2>
                </div>
                <form action="index.php?acao=editar_post" method="POST" enctype="multipart/form-data" class="was-validated">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">

                    <!-- FOTO (opcional) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="foto">
                            Foto do Pet (.jpeg, .png e .webp)
                        </label>
                        <input
                            name="foto"
                            type="file"
                            class="form-control"
                            accept="image/jpeg, image/png, image/webp"
                            aria-label="file example">
                        <div class="form-text">Deixe em branco para manter a foto atual.</div>
                    </div>

                    <!-- NOME -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="nome">
                            Nome
                        </label>
                        <input
                            name="nome"
                            type="text"
                            class="form-control form-control-lg"
                            placeholder="Digite o nome do pet"
                            value="<?= htmlspecialchars($post['nome']) ?>"
                            required>
                        <div class="invalid-feedback">Por favor, coloque um nome para o pet.</div>
                    </div>

                    <!-- IDADE -->
                    <div class="mb-3">
                        <label for="idade" class="form-label fw-semibold">Idade aproximada (anos):</label>
                        <input
                            type="number"
                            id="idade"
                            name="idade"
                            class="form-control form-control-lg"
                            placeholder="Digite a idade aproximada do pet"
                            min="0"
                            max="25"
                            value="<?= htmlspecialchars($post['idade']) ?>"
                            required>
                        <div class="invalid-feedback">Por favor, coloque uma idade aproximada para o pet.</div>
                    </div>

                    <!-- ESPECIE -->
                    <div class="mb-3">
                        <label for="especie" class="form-label fw-semibold">Espécie:</label>
                        <select id="especie" name="especie" class="form-select" required>
                            <option value="Gato" <?= $post['especie'] === 'Gato' ? 'selected' : '' ?>>Gato</option>
                            <option value="Cachorro" <?= $post['especie'] === 'Cachorro' ? 'selected' : '' ?>>Cachorro</option>
                        </select>

                        <div class="invalid-feedback">Por favor, selecione uma espécie.</div>
                    </div>

                    <!-- SEXO -->
                    <div class="mb-3">
                        <label for="sexo" class="form-label fw-semibold">Sexo:</label>
                        <select id="sexo" name="sexo" class="form-select" required>
                            <option value="Macho" <?= $post['sexo'] === 'Macho' ? 'selected' : '' ?>>Macho</option>
                            <option value="Fêmea" <?= $post['sexo'] === 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
                            <option value="Indefinido" <?= $post['sexo'] === 'Indefinido' ? 'selected' : '' ?>>Indefinido</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione um sexo.</div>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status:</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="Disponível" <?= $post['status'] === 'Disponível' ? 'selected' : '' ?>>Disponível</option>
                            <option value="Adotado" <?= $post['status'] === 'Adotado' ? 'selected' : '' ?>>Adotado</option>
                        </select>
                    </div>

                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'atualizacao'): ?>
                        <p class="text-danger fw-bold fs-6 mb-3">Não foi possível atualizar a doação.</p>
                    <?php endif; ?>

                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'upload'): ?>
                        <p class="text-danger fw-bold fs-6 mb-3">Não foi possível enviar a nova foto. Tente novamente.</p>
                    <?php endif; ?>

                    <div class="d-flex flex-row justify-content-between gap-2">
                        <a href="index.php?acao=minhas_doacoes" class="btn btn-secondary w-50">Cancelar</a>
                        <button type="submit" class="btn btn-primary fw-semibold w-50">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
