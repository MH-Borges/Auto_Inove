<?php

require_once("../../../../configs/conexao.php"); 

$num = $_POST['numItem_info'];
$item1 = $_POST['item_atr1_info'];
$item2 = $_POST['item_atr2_info'];
$item3 = $_POST['item_atr3_info'];
$item4 = $_POST['item_atr4_info'];

if($num == '1'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item1' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr1'>
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
if($num == '2'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item2' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr2'>
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
if($num == '3'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item3' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr3'>
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
if($num == '4'){
    $query = $pdo->query("SELECT * FROM produtos Where nome = '$item4' LIMIT 1");
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
            <div id='select-button' class='select_ItemAtr4'>
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