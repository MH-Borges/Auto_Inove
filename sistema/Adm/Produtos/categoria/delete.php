<?php

require_once("../../../configs/conexao.php"); 

$id = $_POST['id_categ_delete'];

$res = $pdo->query("SELECT * FROM categorias where id = '$id'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_categ = $dados[0]['nome'];

$res2 = $pdo->query("SELECT * FROM sub_categorias where categ_Atrelada = '$nome_categ'"); 
$dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados2) != 0){
    echo 'Existe uma Subcategoria atrelada a esta categoria, para continuar desvincule a subcategoria atrelada!';
    exit();
}
else{
    $pdo->query("DELETE from categorias WHERE id = '$id'");
    echo 'Excluído com Sucesso!!';
}

?>