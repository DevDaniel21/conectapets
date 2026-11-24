<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar uma nova doação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center py-5">
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 450px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Criar uma nova doação</h2>
                </div>
                <form action="index.php?acao=cadastrar_post" enctype="multipart/form-data" method="POST" class="was-validated">
                    <input type="hidden" name="cadastro_post_token" value="<?= htmlspecialchars($_SESSION['cadastro_post_token'] ?? '') ?>">
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
                            required>
                        <div class="invalid-feedback">Por favor, coloque uma idade aproximada para o pet.</div>
                    </div>
                    <!-- ESPECIE -->
                    <div class="mb-3">
                        <label for="especie" class="form-label fw-semibold">Espécie:</label>
                        <select id="especie" name="especie" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="Gato">Gato</option>
                            <option value="Cachorro">Cachorro</option>
                        </select>

                        <div class="invalid-feedback">Por favor, selecione uma espécie.</div>
                    </div>
                    <!-- SEXO -->
                    <div class="mb-3">
                        <label for="sexo" class="form-label fw-semibold">Sexo:</label>
                        <select id="sexo" name="sexo" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="Macho">Macho</option>
                            <option value="Fêmea">Fêmea</option>
                            <option value="Indefinido">Indefinido</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione um sexo.</div>
                    </div>
                    <!-- FOTO -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">
                            Foto do Pet (.jpeg, .png e .webp)
                        </label>
                        <input
                            name="foto"
                            type="file"
                            class="form-control"
                            accept="image/jpeg, image/png, image/webp"
                            aria-label="file example"
                            required>
                        <div class="invalid-feedback">Formato do arquivo inválido.</div>
                    </div>

                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'credenciais'): ?>
                        <p class="text-danger fw-bold fs-6 mb-3">Informações estão em falta!</p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Criar doação
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>