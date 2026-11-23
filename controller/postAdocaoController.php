<?php

require_once __DIR__ . '/../model/postAdocaoModel.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/cloudinaryController.php';


function controller_cadastrarPost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_SESSION['usuario']['id'])) {
            header('Location: /conectapets/index.php?erro=sessao');
            exit;
        }

        date_default_timezone_set('America/Sao_Paulo');

        $usuario_id = $_SESSION['usuario']['id'];
        $nome = $_POST['nome'] ?? '';
        $especie = $_POST['especie'] ?? '';
        $idade = $_POST['idade'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $status = 'Disponível';
        $data_publicacao = date('Y-m-d H:i:s');

        // Controller for errors
        if (empty($nome) || empty($especie) || empty($idade) || empty($sexo)) {
            header('Location: /conectapets/index.php?acao=cadastrar_post&erro=campos');
            exit;
        }

        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            header('Location: /conectapets/index.php?acao=cadastrar_post&erro=arquivo');
            exit;
        }

        // Send image to cloudinary
        $public_id = uploadImagem($_FILES['foto']);
        if (!$public_id) {
            header('Location: /conectapets/index.php?acao=cadastrar_post&erro=upload');
            exit;
        }

        $foto = $public_id;

        $resultado = cadastrarPostAdocao($usuario_id, $nome, $especie, $idade, $sexo, $foto, $status, $data_publicacao);

        if ($resultado) {
            header('Location: /conectapets/index.php?acao=home');
            exit;
        }

        header('Location: /conectapets/index.php?acao=cadastrar_post&erro=credenciais');
        exit;
    }

    require __DIR__ . '/../view/cadastro_post.php';
}


function controller_listarPosts() {

    $posts = listarPostsAdocao();
    
    return $posts;
}


function controller_listarPostsUsuario() {

    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php');
        exit;
    }

    $usuario_id = $_SESSION['usuario']['id'];
    $posts = listarPostsPorUsuario($usuario_id);

    require __DIR__ . '/../view/meus_posts.php';
}


function controller_atualizarPost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $especie = $_POST['especie'] ?? '';
        $idade = $_POST['idade'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $foto = $_POST['foto'] ?? 'main-sample';
        $status = $_POST['status'] ?? '';

        $resultado = atualizarPostAdocao($id, $nome, $especie, $idade, $sexo, $foto, $status);

        if ($resultado) {
            header('Location: /conectapets/index.php?acao=listar_posts_usuario');
            exit;
        }

        header('Location: /conectapets/index.php?acao=listar_posts_usuario&erro=atualizacao');
        exit;
    }

    header('Location: /conectapets/index.php?acao=listar_posts_usuario');
    exit;
}


function controller_excluirPost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'] ?? '';
        

        $resultado = excluirPostAdocao($id);


        if ($resultado) {
            header('Location: /conectapets/index.php?acao=listar_posts_usuario');
            exit;
        }

        header('Location: /conectapets/index.php?acao=listar_posts_usuario&erro=exclusao');
        exit;
    }

    header('Location: /conectapets/index.php?acao=listar_posts_usuario');
    exit;
}

?>
