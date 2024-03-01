<?php

require_once("../../../configs/conexao.php"); 

$id = $_POST['id_prod_delete'];

$pdo->query("DELETE from produtos WHERE id = '$id'");

echo 'Excluído com Sucesso!!';

?>