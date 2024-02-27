<?php

require_once("../../../../configs/conexao.php"); 

$item01 = $_POST['item_atr01_List_Item03'];
$item02 = $_POST['item_atr02_List_Item03'];
$codigo = $_POST['codigo_lista_item_atr03'];

echo '<ul id="options">';
    $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
    if(count($dados) == 0){
        echo "
            <li class='option_ItemAtr03' style='pointer-events: none;'>
                <input type='radio' name='ItemAtr03_Produto' value='null' data-label='null'>
                <span class='label'> Nenhum produto encontrado </span>
            </li>
        ";
    }
    else{
        for ($j=0; $j < count($dados); $j++) {
            $img_prod = $dados[$j]['img'];
            $nome_prod = $dados[$j]['nome'];

            if($nome_prod !== $item01 && $nome_prod !== $item02 ){
                if($img_prod == 'placeholder.jpg'){
                    $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                }else{
                    $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                }
    
                echo "
                    <li class='option_ItemAtr03' onclick='RunCodeItens(`03`);'>
                        <input type='radio' name='ItemAtr03_Produto' value='$nome_prod' data-label='$nome_prod'>
                        $img_URL
                        <span class='label'>$nome_prod</span>
                    </li>
                ";
            }
        }
    }
echo '</ul>';

?>