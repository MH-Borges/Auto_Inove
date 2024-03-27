<?php
@session_start();
require_once("../sistema/configs/conexao.php");

$item = $_POST['item_notf'];
$tipo = $_POST['tipo_notf'];

if($tipo === 'categoria'){
    $res = $pdo->query("SELECT * FROM categorias where nome = '$item'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $nome = $dados[0]['nome'];

    $mensagem = 'A categoria '.$nome.' recebeu um clique!';
    $acao = 'clique';
}

if($tipo === 'sub-categoria'){
    $res = $pdo->query("SELECT * FROM sub_categorias where nome = '$item'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $nome = $dados[0]['nome'];

    $mensagem = 'A Sub-Categoria '.$nome.' recebeu um clique!';
    $acao = 'clique';
}

if($tipo === 'produto'){
    $res = $pdo->query("SELECT * FROM produtos where nome = '$item'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $nome = $dados[0]['nome'];

    $mensagem = 'O produto '.$nome.' recebeu um clique para visualizar detalhes!';
    $acao = 'visualizacao';
}

if($tipo === 'produto_carrinho'){
    $res = $pdo->query("SELECT * FROM produtos where nome = '$item'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $nome = $dados[0]['nome'];

    $mensagem = 'O produto '.$nome.' foi adicionado ao carrinho!';
    $acao = 'carrinho';
}

if($tipo === 'Remove_carrinho'){
    $res = $pdo->query("SELECT * FROM produtos where nome = '$item'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $nome = $dados[0]['nome'];

    $mensagem = 'O produto '.$nome.' foi removido do carrinho!';
    $acao = 'carrinho';
}

$data = date('d/m/Y');

$res = $pdo->prepare("INSERT INTO notificacoes (acao, mensagem, data_, status_notif) VALUES (:acao, :mensagem, :data_, :status_notif)");
$res->bindValue(":acao", $acao);
$res->bindValue(":mensagem", $mensagem);
$res->bindValue(":data_", $data);
$res->bindValue(":status_notif", 'ativa');
$res->execute();

?>