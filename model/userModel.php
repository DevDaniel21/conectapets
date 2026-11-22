<?php

require_once __DIR__ . '/../config/conexao.php';

function cadastrarUsuario($nome, $email, $senha, $telefone)
{
    global $pdo;

    $sql = "INSERT INTO usuario (nome, email, senha, telefone)
            VALUES (:nome, :email, :senha, :telefone)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ":nome" => $nome,
        ":email" => $email,
        ":senha" => $senha,
        ":telefone" => $telefone
    ]);
}


function buscarUsuarioPorId($id)
{
    global $pdo;

    $sql = "SELECT id, nome, email, telefone
            FROM usuario
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function buscarUsuarioPorEmail($email)
{
    global $pdo;

    $sql = "SELECT * FROM usuario WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function atualizarUsuario($id, $nome, $email, $telefone)
{
    global $pdo;

    $sql = "UPDATE usuario
            SET nome = :nome,
                email = :email,
                telefone = :telefone
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":nome" => $nome,
        ":email" => $email,
        ":telefone" => $telefone
    ]);
}


function atualizarSenhaUsuario($id, $senha)
{
    global $pdo;

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "UPDATE usuario SET senha = :senha WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ":senha" => $senhaHash,
        ":id" => $id
    ]);
}


function excluirUsuario($id)
{
    global $pdo;

    $sql = "DELETE FROM usuario WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([":id" => $id]);
}
