<?php
@session_start();
require_once("../../../configs/conexao.php"); 

$idEdit = $_POST['idEditCateg'];
$NomeLink = $_POST['nomeCateg'];


// ===== VERIFICAÇÃO DE INPUTS VAZIOS =====
if($NomeLink == ""){
	echo 'Preencha o campo nome da nova categoria!';
	exit();
}

if($idEdit == ""){
    $res = $pdo->query("SELECT * FROM categoria_links where nome = '$NomeLink'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    if(@count($dados) != 0){
        echo 'Categoria já cadastrada no banco de dados!';
        exit();
    }
}

// ===== INSERÇÃO DE DADOS NO BANCO =====

if($idEdit == ""){
    $res = $pdo->prepare("INSERT INTO categoria_links (nome) VALUES (:nome)");
}
else{
    $res = $pdo->prepare("UPDATE categoria_links SET nome = :nome WHERE id = :id");
    $res->bindValue(":id", $idEdit);
}

$res->bindValue(":nome", $NomeLink);
$res->execute();


if($idEdit == ""){
    echo 'Nova categoria adicionada com Sucesso!!';
}
else{
    echo 'Categoria atualizada com Sucesso!!';
}

?>