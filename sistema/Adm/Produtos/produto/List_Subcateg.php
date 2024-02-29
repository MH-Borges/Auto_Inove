<?php

require_once("../../../configs/conexao.php"); 

$subcategoria_edit = $_POST['subcategoria_lista_edit'];
$categoria = $_POST['categoria_lista_subCateg'];

echo "<ul id='options' class='listagem_subcat'>";
                                             
    $query = $pdo->query("SELECT * FROM sub_categorias WHERE categ_Atrelada = '$categoria' ");
    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
    if(count($dados) == 0){
        echo "
            <li class='option_SubCategorias' style='pointer-events: none;'>
                <input type='radio' name='SubCategoria_Produto' value='null' data-label='null'>
                <span class='label'> Selecione uma categoria antes </span>
            </li>
        ";
    }
    else{
        for ($j=0; $j < count($dados); $j++) {
            $nome_SubCategorias = $dados[$j]['nome'];
            if($nome_SubCategorias === $subcategoria_edit){
                echo "
                    <li class='option_SubCategorias'>
                        <input type='radio' name='SubCategoria_Produto' value='$nome_SubCategorias' data-label='$nome_SubCategorias' checked>
                        <span class='label'>$nome_SubCategorias</span>
                    </li>
                ";
            }
            else{
                echo "
                    <li class='option_SubCategorias'>
                        <input type='radio' name='SubCategoria_Produto' value='$nome_SubCategorias' data-label='$nome_SubCategorias'>
                        <span class='label'>$nome_SubCategorias</span>
                    </li>
                ";
            }
        }
    }
echo "</ul>";   

?>