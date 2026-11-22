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
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $telefone = $_POST['telefone'] ?? 0;
    
    require_once __DIR__ . '/controller/userController.php';
    controller_cadastrar($nome, $email, $senha, $telefone);
    //Registra usuario e redireciona para home

} elseif ($acao === 'home') {
    require __DIR__ . '/view/home.php';

} elseif ($acao === 'sair') {
    require_once __DIR__ . '/config/session.php';
    session_destroy();
    header('Location: index.php');
    exit;

} elseif ($acao === 'excluir_conta') {
    require_once __DIR__ . '/config/session.php';
    require_once __DIR__ . '/model/userModel.php';

    if (isset($_SESSION['usuario']['id'])) {
        excluirUsuario($_SESSION['usuario']['id']);
    }

    session_destroy();
    header('Location: index.php');
    exit;

} else {
    require __DIR__ . '/view/login.php';
}

?>