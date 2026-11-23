<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php?acao=cadastrar_post" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">

        <label for="especie">Espécie:</label>
        <select id="especie" name="especie" required>
            <option value="">Selecione</option>
            <option value="Gato">Gato</option>
            <option value="Cachorro">Cachorro</option>
        </select>

        <label for="idade">Idade (anos):</label>
        <input type="number" id="idade" name="idade" min="0" max="25" required>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="">Selecione</option>
            <option value="Macho">Macho</option>
            <option value="Fêmea">Fêmea</option>
            <option value="Indefinido">Indefinido</option>
        </select>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" required>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'credenciais'): ?>
            <p>Informações estão em falta!</p>
        <?php endif; ?>

        <button type="submit">Criar adoção</button>
    </form>
</body>

</html>
