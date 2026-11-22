<?php

require_once __DIR__ . '/../model/userModel.php';
require_once __DIR__ . '/../config/session.php';

function controller_cadastrar() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $telefone = $_POST['telefone'] ?? '';

        $senha = password_hash($senha, PASSWORD_DEFAULT);

        $resultado = cadastrarUsuario($nome, $email, $senha, $telefone);

        if ($resultado) {
            $usuario = buscarUsuarioPorEmail($email);
            session_regenerate_id(true);
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ];
            header('Location: /conectapets/index.php?acao=home');
            exit;
        }

        header('Location: /conectapets/index.php?acao=cadastrar&erro=credenciais');
        exit;
    }

    require __DIR__ . '/../view/cadastro.php';
}

?>