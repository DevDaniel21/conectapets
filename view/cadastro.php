<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar uma conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container min-vh-100 d-flex justify-content-center align-items-center py-5">
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 450px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Criar uma nova conta</h2>
                </div>
                <form action="index.php?acao=salvar_cadastro" method="POST" class="was-validated">
                    <!-- NOME -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="nome">
                            Nome
                        </label>
                        <input
                            name="text"
                            type="nome"
                            class="form-control form-control-lg"
                            placeholder="Digite seu nome"
                            required>
                        <div class="invalid-feedback">Por favor, coloque seu nome.</div>
                    </div>
                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">
                            Endereço de e-mail
                        </label>
                        <input
                            name="email"
                            type="email"
                            class="form-control form-control-lg"
                            placeholder="Digite seu e-mail"
                            required>
                        <div class="invalid-feedback">Por favor, coloque seu email.</div>
                    </div>
                    <!-- TELEFONE -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">
                            Telefone para contato
                        </label>
                        <input
                            name="telefone"
                            type="text"
                            maxlength="15"
                            class="form-control form-control-lg"
                            placeholder="Digite seu telefone"
                            required>
                        <div class="invalid-feedback">Por favor, coloque telefone.</div>
                    </div>
                    <!-- SENHA -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Senha (minímo 6 caracteres)
                        </label>
                        <input
                            name="senha"
                            type="password"
                            class="form-control form-control-lg"
                            placeholder="Digite sua senha"
                            minlength="6"
                            required>
                        <div class="invalid-feedback">Por favor, coloque uma senha válida.</div>
                    </div>
                    <div class="fs-6 mb-3">
                        <a href="index.php?acao=login" class="text-decoration-none">Fazer login</a>
                    </div>
                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'credenciais'): ?>
                        <p class="text-danger fw-bold fs-6 mb-3">Informações estão em falta!</p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Cadastro
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const inputTelefone = document.querySelector('input[name="telefone"]');

        inputTelefone.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');

            if (valor.length > 11) {
                valor = valor.slice(0, 11);
            }

            if (valor.length <= 2) {
                e.target.value = '(' + valor;
            } else if (valor.length <= 7) {
                e.target.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
            } else {
                e.target.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 7) + '-' + valor.slice(7, 11);
            }
        });
    </script>
</body>

</html>