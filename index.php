<?php

$acao = $_GET['acao'] ?? '';
$auto_login = $_GET['auto_login'] ?? '';
$metodo = $_SERVER['REQUEST_METHOD'];


if ($acao === 'login' && $metodo === 'POST') {
    require_once __DIR__ . '/controller/authController.php';
    // Registra sessao

} elseif ($acao === 'cadastrar') {
    require __DIR__ . '/view/cadastro.php';
    // Manda para pagina de cadastro

} elseif ($acao === 'salvar_cadastro') {
    require_once __DIR__ . '/controller/userController.php';
    controller_cadastrar();
    //Registra usuario e redireciona para home

} elseif ($acao === 'perfil') {
    require __DIR__ . '/view/perfil.php';

} elseif ($acao === 'atualizar_perfil') {
    require __DIR__ . '/controller/userController.php';
    controller_atualizarPerfil();
    // Atualiza o usuario e volta para o perfil

} elseif ($acao === 'home') {
    require __DIR__ . '/view/home.php';

} elseif ($acao === 'sair') {
    require_once __DIR__ . '/config/session.php';
    session_destroy();
    header('Location: index.php');
    exit;

} elseif ($acao === 'excluir_conta') {
    require_once __DIR__ . '/controller/userController.php';
    controller_excluirConta();
    // O controller encerra a sessão e redireciona

} elseif ($acao === 'listar_posts_usuario') {
    require_once __DIR__ . '/controller/postAdocaoController.php';
    controller_listarPostsUsuario();

} elseif ($acao === 'atualizar_post') {
    require_once __DIR__ . '/controller/postAdocaoController.php';
    controller_atualizarPost();

} elseif ($acao === 'excluir_post') {
    require_once __DIR__ . '/controller/postAdocaoController.php';
    controller_excluirPost();

} elseif ($acao === 'cadastrar_post') {
    require_once __DIR__ . '/controller/postAdocaoController.php';
    controller_cadastrarPost();

} elseif ($acao === 'minhas_doacoes') {
    require_once __DIR__ . '/controller/postAdocaoController.php';
    require __DIR__ . '/view/minhas_doacoes.php';

} elseif ($acao === 'editar_post') {
    require_once __DIR__ . '/controller/postAdocaoController.php';
    controller_editarPost();

} else {
    require __DIR__ . '/view/login.php';
}

?>