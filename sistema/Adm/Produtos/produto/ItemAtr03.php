<?php

require_once("../../../configs/conexao.php"); 

$item03 = $_POST['item_atr03'];

$query = $pdo->query("SELECT * FROM produtos Where nome = '$item03' LIMIT 1");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){
    $img_prod = $dados[0]['img'];
    $nome_prod = $dados[0]['nome'];
    $codigo_prod = $dados[0]['codigo'];
    $valor_prod = $dados[0]['valor'];

    if($img_prod == 'placeholder.jpg'){
        $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
    }else{
        $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
    }

    echo "
        <div id='select-button' class='select_ItemAtr03'>
            <p>$codigo_prod</p>
            $img_URL
            <p>$nome_prod</p>
            <p>$valor_prod</p>
        </div>
    ";
}

?>