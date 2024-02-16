<?php

require_once("../../../configs/conexao.php"); 

$id = $_POST['id_Codigo_delete'];

$pdo->query("DELETE from codigos WHERE id = '$id'");

echo 'Excluído com Sucesso!!';
?>