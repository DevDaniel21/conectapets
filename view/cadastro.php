<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php?acao=salvar_cadastro" method="POST">
        <input type="text" name="nome" required>
        <input type="email" name="email" required>
        <input type="password" name="senha" required>
        <input type="text" name="telefone" maxlength="15" placeholder="(99) 99999-9999" required>
        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'credenciais'): ?>
            <p>Informações estão em falta!</p>
        <?php endif; ?>

        <button type="submit">Cadastrar</button>
    </form>

    <script>
        const inputTelefone = document.querySelector('input[name="telefone"]');

        inputTelefone.addEventListener('input', function (e) {
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
