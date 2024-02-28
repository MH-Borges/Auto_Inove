<?php

require_once("../../../../configs/conexao.php"); 

$num = $_POST['numItem_info'];
$item01 = $_POST['item_atr01_info'];
$item02 = $_POST['item_atr02_info'];
$item03 = $_POST['item_atr03_info'];
$item04 = $_POST['item_atr04_info'];

if($num == '01'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item01' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr01'>
                <div class='infos_Selected'>
                    <p class='codigo_prod_infos'>$codigo_prod</p>
                    $img_URL
                    <p class='nome_prod_infos'>$nome_prod</p>
                    <p class='valor_prod_infos'>$valor_prod</p>
                </div>
            </div>
        ";
    }
}
if($num == '02'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item02' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr02'>
                <div class='infos_Selected'>
                    <p class='codigo_prod_infos'>$codigo_prod</p>
                    $img_URL
                    <p class='nome_prod_infos'>$nome_prod</p>
                    <p class='valor_prod_infos'>$valor_prod</p>
                </div>
            </div>
        ";
    }
}
if($num == '03'){
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
                <div class='infos_Selected'>
                    <p class='codigo_prod_infos'>$codigo_prod</p>
                    $img_URL
                    <p class='nome_prod_infos'>$nome_prod</p>
                    <p class='valor_prod_infos'>$valor_prod</p>
                </div>
            </div>
        ";
    }
}
if($num == '04'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item04' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr04'>
                <div class='infos_Selected'>
                    <p class='codigo_prod_infos'>$codigo_prod</p>
                    $img_URL
                    <p class='nome_prod_infos'>$nome_prod</p>
                    <p class='valor_prod_infos'>$valor_prod</p>
                </div>
            </div>
        ";
    }
}

?>