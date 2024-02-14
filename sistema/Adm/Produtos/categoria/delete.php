<?php

require_once("../../../configs/conexao.php"); 

$id = $_POST['id_categ_delete'];

$pdo->query("DELETE from categorias WHERE id = '$id'");

echo 'Excluído com Sucesso!!';

?>