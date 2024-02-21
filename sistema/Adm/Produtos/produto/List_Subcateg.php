<?php

require_once("../../../configs/conexao.php"); 

$categoria = $_POST['categoria_lista_subCateg'];

echo "<ul id='options' class='listagem_subcat'>";
                                             
    $query = $pdo->query("SELECT * FROM sub_categorias WHERE categ_Atrelada = '$categoria' ");
    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
    for ($j=0; $j < count($dados); $j++) {
        $nome_SubCategorias = $dados[$j]['nome'];
        echo "
        <li class='option_SubCategorias'>
            <input type='radio' name='SubCategoria_Produto' value='$nome_SubCategorias' data-label='$nome_SubCategorias'>
            <span class='label'>$nome_SubCategorias</span>
        </li>
        ";
    }
                                            
echo "</ul>";   

?>