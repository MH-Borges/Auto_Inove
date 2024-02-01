<?php

require_once("../../../configs/conexao.php"); 

$id = $_POST['idDeletCateg'];

$pdo->query("DELETE from categoria_links WHERE id = '$id'");

echo 'Excluído com Sucesso!!';

?>