<?php

require_once("../../../configs/conexao.php"); 

$codigo = $_POST['codigo_lista_prodRelac'];

echo '<div class="SeletoresProds">
    <div class="Select_Produtos_Relac">
        <div id="category-select" class="ItemAtr01_head">
            <input type="checkbox" id="options_btn_ItemAtr01" onchange="OptionSelection(`selected_val_ItemAtr01`, `options_btn_ItemAtr01`, `option_ItemAtr01`);">

            <div id="select-button" class="select_ItemAtr01">
                <div id="selected_val_ItemAtr01"> Adicionar item 01 </div>
            </div>
        </div>
        
        <ul id="options">';
            $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            if(count($dados) == 0){
                echo "
                    <li class='option_ItemAtr01' style='pointer-events: none;'>
                        <input type='radio' name='ItemAtr01_Produto' value='null' data-label='null'>
                        <span class='label'> Nenhum produto encontrado </span>
                    </li>
                ";
            }
            else{
                for ($j=0; $j < count($dados); $j++) {
                    $img_prod = $dados[$j]['img'];
                    $nome_prod = $dados[$j]['nome'];

                    if($img_prod == 'placeholder.jpg'){
                        $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                    }else{
                        $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                    }

                    echo "
                        <li class='option_ItemAtr01'>
                            <input type='radio' name='ItemAtr01_Produto' value='$nome_prod' data-label='$nome_prod'>
                            $img_URL
                            <span class='label'>$nome_prod</span>
                        </li>
                    ";
                }
            }
  echo '</ul>
    </div>

    <div id="select_item02" class="Select_Produtos_Relac Disabled">
        <div id="category-select" class="ItemAtr02_head">
            <input type="checkbox" id="options_btn_ItemAtr02" onchange="OptionSelection(`selected_val_ItemAtr02`, `options_btn_ItemAtr02`, `option_ItemAtr02`);">

            <div id="select-button" class="select_ItemAtr02">
                <div id="selected_val_ItemAtr02"> Adicionar item 02 </div>
            </div>
        </div>
        
        <ul id="options">';
            $query2 = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            if(count($dados2) == 0){
                echo "
                    <li class='option_ItemAtr02' style='pointer-events: none;'>
                        <input type='radio' name='ItemAtr02_Produto' value='null' data-label='null'>
                        <span class='label'> Nenhum produto encontrado </span>
                    </li>
                ";
            }
            else{
                for ($j=0; $j < count($dados2); $j++) {
                    $img_prod = $dados2[$j]['img'];
                    $nome_prod = $dados2[$j]['nome'];

                    if($img_prod == 'placeholder.jpg'){
                        $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                    }else{
                        $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                    }

                    echo "
                        <li class='option_ItemAtr02'>
                            <input type='radio' name='ItemAtr02_Produto' value='$nome_prod' data-label='$nome_prod'>
                            $img_URL
                            <span class='label'>$nome_prod</span>
                        </li>
                    ";
                }
            }
  echo '</ul>
    </div>

    <div id="select_item03" class="Select_Produtos_Relac Disabled">
        <div id="category-select" class="ItemAtr03_head">
            <input type="checkbox" id="options_btn_ItemAtr03" onchange="OptionSelection(`selected_val_ItemAtr03`, `options_btn_ItemAtr03`, `option_ItemAtr03`);">

            <div id="select-button" class="select_ItemAtr03">
                <div id="selected_val_ItemAtr03"> Adicionar item 03 </div>
            </div>
        </div>
        
        <ul id="options">';
            $query3 = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
            $dados3 = $query3->fetchAll(PDO::FETCH_ASSOC);
            if(count($dados3) == 0){
                echo "
                    <li class='option_ItemAtr03' style='pointer-events: none;'>
                        <input type='radio' name='ItemAtr03_Produto' value='null' data-label='null'>
                        <span class='label'> Nenhum produto encontrado </span>
                    </li>
                ";
            }
            else{
                for ($j=0; $j < count($dados3); $j++) {
                    $img_prod = $dados3[$j]['img'];
                    $nome_prod = $dados3[$j]['nome'];

                    if($img_prod == 'placeholder.jpg'){
                        $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                    }else{
                        $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                    }

                    echo "
                        <li class='option_ItemAtr03'>
                            <input type='radio' name='ItemAtr03_Produto' value='$nome_prod' data-label='$nome_prod'>
                            $img_URL
                            <span class='label'>$nome_prod</span>
                        </li>
                    ";
                }
            }
  echo '</ul>
    </div>

    <div id="select_item04" class="Select_Produtos_Relac Disabled">
        <div id="category-select" class="ItemAtr04_head">
            <input type="checkbox" id="options_btn_ItemAtr04" onchange="OptionSelection(`selected_val_ItemAtr04`, `options_btn_ItemAtr04`, `option_ItemAtr04`);">

            <div id="select-button" class="select_ItemAtr04">
                <div id="selected_val_ItemAtr04"> Adicionar item 04 </div>
            </div>
        </div>
        
        <ul id="options">';
            $query4 = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
            $dados4 = $query4->fetchAll(PDO::FETCH_ASSOC);
            if(count($dados4) == 0){
                echo "
                    <li class='option_ItemAtr04' style='pointer-events: none;'>
                        <input type='radio' name='ItemAtr04_Produto' value='null' data-label='null'>
                        <span class='label'> Nenhum produto encontrado </span>
                    </li>
                ";
            }
            else{
                for ($j=0; $j < count($dados4); $j++) {
                    $img_prod = $dados4[$j]['img'];
                    $nome_prod = $dados4[$j]['nome'];

                    if($img_prod == 'placeholder.jpg'){
                        $img_URL = '<img src="../../assets/produtos/placeholder.jpg">';
                    }else{
                        $img_URL = '<img src="../../assets/produtos/'.$img_prod.'">';
                    }

                    echo "
                        <li class='option_ItemAtr04'>
                            <input type='radio' name='ItemAtr04_Produto' value='$nome_prod' data-label='$nome_prod'>
                            $img_URL
                            <span class='label'>$nome_prod</span>
                        </li>
                    ";
                }
            }
  echo '</ul>
    </div>
</div>';

?>