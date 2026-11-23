<?php

require_once __DIR__ . '/../config/conexao.php';

function cadastrarPostAdocao($usuario_id, $nome, $especie, $idade, $sexo, $foto, $status, $data_publicacao)
{
    global $pdo;

    $sql = "INSERT INTO post_adocao (usuario_id, nome, especie, idade, sexo, foto, status, data_publicacao)
            VALUES (:usuario_id, :nome, :especie, :idade, :sexo, :foto, :status, :data_publicacao)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ":usuario_id" => $usuario_id,
        ":nome" => $nome,
        ":especie" => $especie,
        ":idade" => $idade,
        ":sexo" => $sexo,
        ":foto" => $foto,
        ":status" => $status,
        ":data_publicacao" => $data_publicacao
    ]);
}


function listarPostsAdocao()
{
    global $pdo;

    $sql = "SELECT id, usuario_id, nome, especie, idade, sexo, foto, status, data_publicacao
            FROM post_adocao
            ORDER BY data_publicacao DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function listarPostsPorUsuario($usuario_id)
{
    global $pdo;

    $sql = "SELECT id, usuario_id, nome, especie, idade, sexo, foto, status, data_publicacao
            FROM post_adocao
            WHERE usuario_id = :usuario_id
            ORDER BY data_publicacao DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":usuario_id" => $usuario_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function buscarPostPorId($id)
{
    global $pdo;

    $sql = "SELECT id, usuario_id, nome, especie, idade, sexo, foto, status, data_publicacao
            FROM post_adocao
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function atualizarPostAdocao($id, $nome, $especie, $idade, $sexo, $foto, $status)
{
    global $pdo;

    $sql = "UPDATE post_adocao
            SET nome = :nome,
                especie = :especie,
                idade = :idade,
                sexo = :sexo,
                foto = :foto,
                status = :status
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ":id" => $id,
        ":nome" => $nome,
        ":especie" => $especie,
        ":idade" => $idade,
        ":sexo" => $sexo,
        ":foto" => $foto,
        ":status" => $status
    ]);
}


function excluirPostAdocao($id)
{
    global $pdo;

    $sql = "DELETE FROM post_adocao WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([":id" => $id]);
}
