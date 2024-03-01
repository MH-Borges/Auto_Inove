<?php

require_once("../../../../configs/conexao.php"); 

$codigo = $_POST['codigo_lista_prodRelac'];

echo '<div class="SeletoresProds" >
    <div id="select_item1" class="Select_Produtos_Relac" >
        <div id="category-select" class="ItemAtr1_head">
            <input type="checkbox" id="options_btn_ItemAtr1">

            <div id="select-button" class="select_ItemAtr1">
                <div id="selected_val_ItemAtr1"> Adicionar item 1 </div>
            </div>
        </div>
        
        <ul class="List_Itens_1" id="options">';
            $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo' ");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            if(count($dados) == 0){
                echo "
                    <li class='option_ItemAtr1' style='pointer-events: none;'>
                        <input type='radio' name='ItemAtr1_Produto' value='null' data-label='null'>
                        <span class='label null_prod'> Nenhum produto encontrado </span>
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
                        <li class='option_ItemAtr1' onclick='RunCodeItens(`1`);'>
                            <input type='radio' name='ItemAtr1_Produto' value='$nome_prod' data-label='$nome_prod'>
                            $img_URL
                            <span class='label'>$nome_prod</span>
                        </li>
                    ";
                }
            }
  echo '</ul>
    </div>

    <div id="select_item2" class="Select_Produtos_Relac Disabled">
        <div id="category-select" class="ItemAtr2_head">
            <input type="checkbox" id="options_btn_ItemAtr2">

            <div id="select-button" class="select_ItemAtr2">
                <div id="selected_val_ItemAtr2"> Adicionar item 2 </div>
            </div>
        </div>
    </div>

    <div id="select_item3" class="Select_Produtos_Relac Disabled">
        <div id="category-select" class="ItemAtr3_head">
            <input type="checkbox" id="options_btn_ItemAtr3">

            <div id="select-button" class="select_ItemAtr3">
                <div id="selected_val_ItemAtr3"> Adicionar item 3 </div>
            </div>
        </div>
    </div>

    <div id="select_item4" class="Select_Produtos_Relac Disabled">
        <div id="category-select" class="ItemAtr4_head">
            <input type="checkbox" id="options_btn_ItemAtr4">

            <div id="select-button" class="select_ItemAtr4">
                <div id="selected_val_ItemAtr4"> Adicionar item 4 </div>
            </div>
        </div>
    </div>
</div>';

?>