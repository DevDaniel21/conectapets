<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php?acao=login" method="POST">
        <input type="email" name="email" required>
        <input type="password" name="senha" required>
        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'credenciais'): ?>
            <p>E-mail ou senha incorretos!</p>
        <?php endif; ?>

        <button type="submit">Entrar</button>
    </form>
    <a href="index.php?acao=cadastrar">Criar uma conta.</a>
</body>

</html>