<?php

require_once("../../configs/conexao.php"); 

$id = $_POST['idDeletLink'];

$pdo->query("DELETE from links WHERE id = '$id'");

echo 'Excluído com Sucesso!!';

?>