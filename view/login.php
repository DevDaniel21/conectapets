<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container min-vh-100 d-flex justify-content-center align-items-center py-5">
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 450px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Login no Sistema</h2>
                </div>
                <form action="index.php?acao=login" method="POST" class="was-validated">
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
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Senha
                        </label>
                        <input
                            name="senha"
                            type="password"
                            class="form-control form-control-lg"
                            placeholder="Digite sua senha"
                            required>
                        <div class="invalid-feedback">Por favor, coloque uma senha.</div>
                    </div>
                    <div class="fs-6 mb-3">
                        <a href="index.php?acao=cadastrar" class="text-decoration-none">Criar uma conta</a>
                    </div>
                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'credenciais'): ?>
                        <p class="text-danger fw-bold fs-6 mb-3">E-mail ou senha incorretos!</p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>