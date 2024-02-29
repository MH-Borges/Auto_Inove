<?php

require_once("../../../../configs/conexao.php"); 

$codigo = $_POST['codigo_Select'];
$num = $_POST['numItem_list'];
$item1 = $_POST['item_atr1_list'];
$item2 = $_POST['item_atr2_list'];
$item3 = $_POST['item_atr3_list'];
$item4 = $_POST['item_atr4_list'];

if($num == '2'){
    echo '<ul class="List_Itens_2" id="options">';
        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados) == 0){
            echo "
                <li class='option_ItemAtr2' style='pointer-events: none;'>
                    <input type='radio' name='ItemAtr2_Produto' value='null' data-label='null'>
                    <span class='label'> Nenhum produto encontrado </span>
                </li>
            ";
        }
        else{
            for ($j=0; $j < count($dados); $j++) {
                $img_prod = $dados[$j]['img'];
                $nome_prod = $dados[$j]['nome'];
                if($item2 != ""){
                    if($nome_prod == $item2){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr2' onclick='RunCodeItens(`2`);'>
                                <input type='radio' name='ItemAtr2_Produto' value='$nome_prod' data-label='$nome_prod' checked>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                    else if($nome_prod != $item1 && $nome_prod != $item2){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr2' onclick='RunCodeItens(`2`);'>
                                <input type='radio' name='ItemAtr2_Produto' value='$nome_prod' data-label='$nome_prod'>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                }
                else{
                    if($nome_prod != $item1){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr2' onclick='RunCodeItens(`2`);'>
                                <input type='radio' name='ItemAtr2_Produto' value='$nome_prod' data-label='$nome_prod'>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                }
            }
        }
    echo '</ul>';
}
if($num == '3'){
    echo '<ul class="List_Itens_3" id="options">';
        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados) == 0){
            echo "
                <li class='option_ItemAtr3' style='pointer-events: none;'>
                    <input type='radio' name='ItemAtr3_Produto' value='null' data-label='null'>
                    <span class='label'> Nenhum produto encontrado </span>
                </li>
            ";
        }
        else{
            for ($j=0; $j < count($dados); $j++) {
                $img_prod = $dados[$j]['img'];
                $nome_prod = $dados[$j]['nome'];
                if($item3 != ""){
                    if($nome_prod === $item3){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr3' onclick='RunCodeItens(`3`);'>
                                <input type='radio' name='ItemAtr3_Produto' value='$nome_prod' data-label='$nome_prod' checked>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                    else if($nome_prod !== $item1 && $nome_prod !== $item2 && $nome_prod !== $item3){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr3' onclick='RunCodeItens(`3`);'>
                                <input type='radio' name='ItemAtr3_Produto' value='$nome_prod' data-label='$nome_prod'>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                }
                else{
                    if($nome_prod !== $item1 && $nome_prod !== $item2){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr3' onclick='RunCodeItens(`3`);'>
                                <input type='radio' name='ItemAtr3_Produto' value='$nome_prod' data-label='$nome_prod'>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                }
            }
        }
    echo '</ul>';
}
if($num == '4'){
    echo '<ul class="List_Itens_4" id="options">';
        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados) == 0){
            echo "
                <li class='option_ItemAtr4' style='pointer-events: none;'>
                    <input type='radio' name='ItemAtr4_Produto' value='null' data-label='null'>
                    <span class='label'> Nenhum produto encontrado </span>
                </li>
            ";
        }
        else{
            for ($j=0; $j < count($dados); $j++) {
                $img_prod = $dados[$j]['img'];
                $nome_prod = $dados[$j]['nome'];

                if($item4 != ""){
                    if($nome_prod === $item4){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr4' onclick='RunCodeItens(`4`);'>
                                <input type='radio' name='ItemAtr4_Produto' value='$nome_prod' data-label='$nome_prod' checked>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                    else if($nome_prod !== $item1 && $nome_prod !== $item2 && $nome_prod !== $item3 && $nome_prod !== $item4){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr4' onclick='RunCodeItens(`4`);'>
                                <input type='radio' name='ItemAtr4_Produto' value='$nome_prod' data-label='$nome_prod'>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                }
                else{
                    if($nome_prod !== $item1 && $nome_prod !== $item2 && $nome_prod !== $item3 ){
                        if($img_prod == 'placeholder.jpg'){
                            $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                        }else{
                            $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                        }
            
                        echo "
                            <li class='option_ItemAtr4' onclick='RunCodeItens(`4`);'>
                                <input type='radio' name='ItemAtr4_Produto' value='$nome_prod' data-label='$nome_prod'>
                                $img_URL
                                <span class='label'>$nome_prod</span>
                            </li>
                        ";
                    }
                }
            }
        }
    echo '</ul>';
}

?>