<?php

require_once __DIR__ . '/../model/postAdocaoModel.php';
require_once __DIR__ . '/../model/userModel.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/cloudinaryController.php';


function controller_cadastrarPost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Evita envio duplicado (double submit) via token de sessão
        $token = $_POST['cadastro_post_token'] ?? '';
        if (!isset($_SESSION['cadastro_post_token']) || $token !== $_SESSION['cadastro_post_token']) {
            header('Location: /conectapets/index.php?acao=cadastrar_post&erro=duplicado');
            exit;
        }
        // Consome o token para não permitir novo envio com o mesmo valor
        unset($_SESSION['cadastro_post_token']);

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

    // Gera token anti-resubmissão para o formulário
    $_SESSION['cadastro_post_token'] = bin2hex(random_bytes(16));

    require __DIR__ . '/../view/cadastro_post.php';
}


function controller_listarPosts() {

    $posts = listarPostsAdocao();
    
    return $posts;
}


function controller_listarPostsDisponiveis() {

    $posts = listarPostsDisponiveis();
    
    return $posts;
}


function controller_buscarPostPorId($id) {

    return buscarPostPorId($id);
}


function controller_editarPost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        controller_atualizarPost();
        return;
    }

    $id = $_GET['id'] ?? null;

    if (!$id) {
        header('Location: /conectapets/index.php?acao=minhas_doacoes');
        exit;
    }

    $post = controller_buscarPostPorId($id);

    if (!$post || $post['usuario_id'] != $_SESSION['usuario']['id']) {
        header('Location: /conectapets/index.php?acao=minhas_doacoes');
        exit;
    }

    require __DIR__ . '/../view/editar_post.php';
}


function controller_listarPostsUsuario() {

    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php?acao=login');
        exit;
    }

    $usuario_id = $_SESSION['usuario']['id'];
    return listarPostsPorUsuario($usuario_id);
}


function controller_atualizarPost() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /conectapets/index.php?acao=minhas_doacoes');
        exit;
    }

    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $especie = $_POST['especie'] ?? '';
    $idade = $_POST['idade'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $status = $_POST['status'] ?? '';

    // Recupera o post original para manter a foto caso não haja envio
    $postOriginal = controller_buscarPostPorId($id);
    $fotoAntiga = $postOriginal['foto'] ?? '';

    // Foto: se enviou uma nova, faz upload no Cloudinary e exclui a antiga; senão, mantém a original
    if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $public_id = uploadImagem($_FILES['foto']);
        if (!$public_id) {
            header('Location: /conectapets/index.php?acao=editar_post&id=' . $id . '&erro=upload');
            exit;
        }
        // Exclui a foto antiga do Cloudinary
        if (!empty($fotoAntiga)) {
            deletarImagem($fotoAntiga);
        }
        $foto = $public_id;
    } else {
        // Mantém o public_id original do banco
        $foto = $fotoAntiga;
    }

    $resultado = atualizarPostAdocao($id, $nome, $especie, $idade, $sexo, $foto, $status);

    if ($resultado) {
        header('Location: /conectapets/index.php?acao=minhas_doacoes');
        exit;
    }

    header('Location: /conectapets/index.php?acao=minhas_doacoes&erro=atualizacao');
    exit;
}


function controller_excluirPost() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'] ?? '';

        // Exclui a foto do Cloudinary antes de remover o post do banco
        $post = controller_buscarPostPorId($id);
        if ($post && !empty($post['foto'])) {
            deletarImagem($post['foto']);
        }

        $resultado = excluirPostAdocao($id);


        if ($resultado) {
            header('Location: /conectapets/index.php?acao=minhas_doacoes');
            exit;
        }

        header('Location: /conectapets/index.php?acao=minhas_doacoes&erro=exclusao');
        exit;
    }

    header('Location: /conectapets/index.php?acao=minhas_doacoes');
    exit;
}

?>
