<?php

require_once __DIR__ . '/../model/userModel.php';
require_once __DIR__ . '/../model/postAdocaoModel.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/cloudinaryController.php';

function controller_cadastrar()
{
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

// Retorna os dados do usuário logado, usado pelo perfil.php
// Quem não está logado, ou não existe mais, é enviado para a home
function controller_buscarPerfil()
{

    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php?acao=home');
        exit;
    }

    $usuario = buscarUsuarioPorId($_SESSION['usuario']['id']);

    if (!$usuario) {
        header('Location: /conectapets/index.php?acao=home');
        exit;
    }

    return $usuario;
}

// Exclui a conta do usuário logado e encerra a sessão
function controller_excluirConta()
{
    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php?acao=home');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /conectapets/index.php?acao=perfil');
        exit;
    }

    $usuario_id = $_SESSION['usuario']['id'];

    // Exclui as fotos dos posts do usuário no Cloudinary (apenas as imagens)
    $posts = listarPostsPorUsuario($usuario_id);
    foreach ($posts as $post) {
        if (!empty($post['foto'])) {
            deletarImagem($post['foto']);
        }
    }

    $resultado = excluirUsuario($usuario_id);

    if ($resultado) {
        $_SESSION = [];
        session_destroy();
        header('Location: /conectapets/index.php?acao=home');
        exit;
    }

    $_SESSION['perfil_erro'] = 'Não foi possível excluir a conta. Tente novamente.';
    header('Location: /conectapets/index.php?acao=perfil');
    exit;
}


function controller_atualizarPerfil()
{
    if (!isset($_SESSION['usuario']['id'])) {
        header('Location: /conectapets/index.php?acao=home');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /conectapets/index.php?acao=perfil');
        exit;
    }

    $id = $_SESSION['usuario']['id'];

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    $erro = null;

    if ($nome === '' || $email === '' || $telefone === '') {
        $erro = 'Preencha nome, e-mail e telefone.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe um e-mail válido.';
    // } elseif ($senha !== '' && strlen($senha) < 6) {
    //     $erro = 'A nova senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirmarSenha) {
        $erro = 'A confirmação não é igual à nova senha.';
    } else {
        $existente = buscarUsuarioPorEmail($email);
        if ($existente && $existente['id'] != $id) {
            $erro = 'Este e-mail já está em uso por outra conta.';
        }
    }

    // Caso tenha erro
    if ($erro) {
        $_SESSION['perfil_erro'] = $erro;
        header('Location: /conectapets/index.php?acao=perfil');
        exit;
    }

    $resultado = atualizarUsuario($id, $nome, $email, $telefone);

    // Caso atualize a senha
    if ($resultado && $senha !== '') {
        $resultado = atualizarSenhaUsuario($id, $senha);
    }

    // Caso não atualize a senha
    if ($resultado) {
        $_SESSION['usuario']['nome'] = $nome;
        $_SESSION['usuario']['email'] = $email;
        $_SESSION['perfil_sucesso'] = 'Perfil atualizado com sucesso.';
    } else {
        $_SESSION['perfil_erro'] = 'Não foi possível atualizar o perfil. Tente novamente.';
    }

    header('Location: /conectapets/index.php?acao=perfil');
    exit;
}
