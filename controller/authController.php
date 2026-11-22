<?php

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../model/userModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /conectapets/index.php');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$usuario = buscarUsuarioPorEmail($email);

// Caso não exista o email ou senha esteja incorreta
if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    header('Location: /conectapets/index.php?erro=credenciais');
    exit;
}

// Registra sessao
session_regenerate_id(true);

$_SESSION['usuario'] = [
    'id' => $usuario['id'],
    'nome' => $usuario['nome'],
    'email' => $usuario['email']
];

header('Location: /conectapets/index.php?acao=home');
exit;

?>  