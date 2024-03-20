<div class="blockContent produtosListagem">
    <a class="produtos_Btn_CriacaoProd" href="index.php?pag=listagemProduto&funcao=novoProd">
        <p>Novo Produto</p>
        <img src="../../assets/icons/add.svg">
    </a>
    <a class="produtos_Btn_CriacaoCodigo" href="index.php?pag=listagemProduto&funcao=novoCodigo">
        <p>Novo Código</p>
        <img src="../../assets/icons/add.svg">
    </a>
    <button class="produtos_Btn_ListCodigos" type="button" data-toggle="modal" data-target="#ModalListagemCodigos">
        <p>Listagem de Códigos</p>
        <img src="../../assets/icons/list.svg">
    </button>

    <h2>Listagem de produtos</h2>

    <table id="ProdutosTable">
        <thead>
            <tr>
                <th>Imgs</th>
                <th>Nome de produto</th>
                <th>ações</th>
                <th>Código</th>
                <th>Cat / subcat</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < count($dados); $i++) { 
                    $id = $dados[$i]['id'];
                    $img = $dados[$i]['img'];
                    $nome = $dados[$i]['nome'];
                    $status = $dados[$i]['status_prod'];
                    $valor = $dados[$i]['valor'];
                    $estoque = $dados[$i]['estoque'];
                    $codigo = $dados[$i]['codigo'];
                    $categoria = $dados[$i]['categoria'];
                    $subcategoria = $dados[$i]['sub_categoria'];
                    $data_criacao = $dados[$i]['data_criacao'];
                    $data_atual = $dados[$i]['data_atual'];

                    if($img == "placeholder.jpg" || $img == ""){
                        $img_prod = "<img src='../../assets/produtos/placeholder.jpg'>";
                    }else{
                        $img_prod = "<img src='../../assets/produtos/$img'>";
                    }

                    if($data_atual == "" || $data_atual == null){
                        $data = $data_criacao;
                    }else{
                        $data = $data_atual;
                    }

                    echo "
                        <tr class='".$status."Block'>
                            <td class='img_prod'>
                                ".$img_prod."
                            </td>
                            <td class='nome_prod'>
                                <p>".$nome."</p>
                            </td>
                            <td class='acoes_prod'>
                                <a href='index.php?pag=listagemProduto&funcao=editProd&id=".$id."'><img src='../../assets/icons/edit.svg'></a>
                                <a href='index.php?pag=listagemProduto&funcao=deleteProd&id=".$id."'><img src='../../assets/icons/delet.svg'></a>
                                <a class='".$status."' href='index.php?pag=listagemProduto&funcao=statusProd&id=".$id."'><span class='hide'>".$status."</span></a>

                                <p><span>R$</span>".$valor."</p>

                                <form class='estoque_prod' method='POST'>
                                    <span>Estoque:</span>
                                    <input id='".$id."' type='number' value=".$estoque." name='estoque_Prod' onchange='atualizaEstoque(".$id.")' min='0' max='999999'>
                                </form>
                            </td>
                            <td class='codigo_prod'>
                                <p>Código:</p>
                                <span>".$codigo."</span>
                            </td>
                            <td class='status_prod'>
                                <p>Categ / Subcat:</p>
                                <span>".$categoria."</span><span> / ".$subcategoria."</span>
                            </td>
                            <td class='data_prod'>
                                <p>Data:</p>
                                <span>".$data."</span>
                            </td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>

    <div class="msgErro" id="msgErro_edit_Estoque"></div>
</div>


<!-- ***********PRODUTOS************ --> 
<!-- Modal Cria / Editar Produtos -->
<div class="modal fade" id="ModalProduto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <?php 
                    if (@$_GET['funcao'] == 'editProd') {
                        $titulo_Produto = "Edição de Produto!";
                        $btn_Produto = "Salvar edições de produto";

                        $id_Produto_edit = $_GET['id'];

                        $query = $pdo->query("SELECT * FROM produtos WHERE id = '$id_Produto_edit' LIMIT 1");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                        if(@count($dados) > 0){
                            $img_Produto = $dados[0]['img'];
                            $nome_Produto = $dados[0]['nome'];
                            $valor_Produto = $dados[0]['valor'];
                            $descricao_Produto = $dados[0]['descricao'];
                            $categoria_Produto = $dados[0]['categoria'];
                            $subcategoria_Produto = $dados[0]['sub_categoria'];
                            $codigo_Produto = $dados[0]['codigo'];
                            $marca_Produto = $dados[0]['marca'];
                            $estoque_Produto = $dados[0]['estoque'];
                            $litros_Produto = $dados[0]['litros'];
                            $mercadoLivre_Produto = $dados[0]['mercado_livre'];
                            $date_criacao_Produto = $dados[0]['data_criacao'];
                            $date_atual_Produto = $dados[0]['data_atual'];
                            $status = $dados[0]['status_prod'];

                            $Item_Relac_1 = $dados[0]['Item_Relac_1'];
                            $Item_Relac_2 = $dados[0]['Item_Relac_2'];
                            $Item_Relac_3 = $dados[0]['Item_Relac_3'];
                            $Item_Relac_4 = $dados[0]['Item_Relac_4'];
                        }

                        if($categoria_Produto !== "" && $categoria_Produto !== ""){
                            echo "<script language='javascript'>
                                document.addEventListener('DOMContentLoaded', function(){
                                    document.getElementById('categoria_lista_subCateg').value = '$categoria_Produto';
                                    document.getElementById('subcategoria_lista_edit').value = '$subcategoria_Produto';
                                    $('#form_listagem_subCateg').click();
                                });
                            </script>";
                        }

                        if($codigo_Produto !== ""){
                            echo "<script language='javascript'>
                                document.addEventListener('DOMContentLoaded', function(){
                                    $('#codigo_lista_prodRelac').val('".$codigo_Produto."');
                                    $('#codigo_Select').val('".$codigo_Produto."');
                                    $('#form_listagem_prodRelac').click();
                                });
                            </script>";

                            if($Item_Relac_1 !== ""){
                                echo "
                                    <script defer language='javascript'>
                                        document.addEventListener('DOMContentLoaded', function(){
                                            setTimeout(() => { 
                                                $('#id_edit_prod').val('".$id_Produto_edit."');
                                                $('#numItem_list').val('1');
                                                $('#item_atr1_list').val('".$Item_Relac_1."');
                                                $('#form_itemAtr_Listagem').click();
                                            }, 500);

                                            setTimeout(() => { 
                                                $('#numItem_info').val('1');
                                                $('#item_atr1_info').val('".$Item_Relac_1."');
                                                $('#form_itemAtr_Infos').click();
                                            }, 1000);
                                        });
                                    </script>
                                ";
                            }
                            if($Item_Relac_2 !== ""){
                                echo "
                                    <script defer language='javascript'>
                                        document.addEventListener('DOMContentLoaded', function(){
                                            setTimeout(() => { 
                                                $('#id_edit_prod').val('".$id_Produto_edit."');
                                                $('#numItem_list').val('2');
                                                $('#item_atr1_list').val('".$Item_Relac_1."');
                                                $('#item_atr2_list').val('".$Item_Relac_2."');
                                                $('#form_itemAtr_Listagem').click();
                                                $('#select_item2').removeClass('Disabled');
                                            }, 1500);
    
                                            setTimeout(() => { 
                                                $('#numItem_info').val('2');
                                                $('#item_atr2_info').val('".$Item_Relac_2."');
                                                $('#form_itemAtr_Infos').click();
                                            }, 2000);
                                        });
                                    </script>
                                ";
                            }
                            if($Item_Relac_3 !== ""){
                                echo "
                                    <script defer language='javascript'>
                                        document.addEventListener('DOMContentLoaded', function(){
                                            setTimeout(() => { 
                                                $('#id_edit_prod').val('".$id_Produto_edit."');
                                                $('#numItem_list').val('3');
                                                $('#item_atr1_list').val('".$Item_Relac_1."');
                                                $('#item_atr2_list').val('".$Item_Relac_2."');
                                                $('#item_atr3_list').val('".$Item_Relac_3."');
                                                $('#form_itemAtr_Listagem').click();
                                                $('#select_item3').removeClass('Disabled');
                                            }, 2500);
    
                                            setTimeout(() => { 
                                                $('#numItem_info').val('3');
                                                $('#item_atr3_info').val('".$Item_Relac_3."');
                                                $('#form_itemAtr_Infos').click();
                                            }, 3000);
                                        });
                                    </script>
                                ";
                            }
                            if($Item_Relac_4 !== ""){
                                echo "
                                    <script defer language='javascript'>
                                        document.addEventListener('DOMContentLoaded', function(){
                                            setTimeout(() => { 
                                                $('#id_edit_prod').val('".$id_Produto_edit."');
                                                $('#numItem_list').val('4');
                                                $('#item_atr1_list').val('".$Item_Relac_1."');
                                                $('#item_atr2_list').val('".$Item_Relac_2."');
                                                $('#item_atr3_list').val('".$Item_Relac_3."');
                                                $('#item_atr4_list').val('".$Item_Relac_4."');
                                                $('#form_itemAtr_Listagem').click();
                                                $('#select_item4').removeClass('Disabled');
                                            }, 3500);
    
                                            setTimeout(() => { 
                                                $('#numItem_info').val('4');
                                                $('#item_atr4_info').val('".$Item_Relac_4."');
                                                $('#form_itemAtr_Infos').click();
                                            }, 4000);
                                        });
                                    </script>
                                ";
                            }
                        }


                    } else { 
                        $titulo_Produto = "Cadastro de produto!"; 
                        $btn_Produto = "Cadastrar produto";

                        $categoria_Produto = "Selecione a categoria";
                        $subcategoria_Produto = "Selecione a subcategoria";
                        $codigo_Produto = "Selecione o código";

                        $mercadoLivre_Produto = "";
                        $litros_Produto = "";
                    }
                ?>

                <form id="form_Produtos" method="POST">
                    <div class="modal-body">
                        <div class="nav nav-pills Menu_produtos">
                            <a id="DadosProduto_btn" class="active" data-toggle="pill" href="#DadosProduto"><?php echo $titulo_Produto ?></a>
                            <a id="ItensRelac_btn" data-toggle="pill" href="#ItensRelac">Itens relacionados</a>
                        </div>
                        <div class="tab-content Tabs_produtos">
                            <div class="tab-pane fade show active" id="DadosProduto">
                                <div class="tabBox">
                                    <div class="Base_checkbox">
                                        <div class="Img_Produto">
                                            <input type="file" value="<?php echo @$img_Produto ?>" id="img_Produto_Input" name="img_Produto_Input" onChange="carregarImgProduto();">
                                            <?php
                                                if(@$img_Produto == "placeholder.jpg" || @$img_Produto == ""){
                                                    echo "<img class='img_produto_modal' id='target_imgProduto' src='../../assets/icons/placeholder.svg'>";
                                                }else{
                                                    echo "<img class='img_produto_modal imgSelected' id='target_imgProduto' src='../../assets/Produtos/$img_Produto'>";
                                                }
                                            ?>
                                            <img class="editPen" onclick="document.getElementById('img_Produto_Input').click();" src="../../assets/icons/edit.svg" onload="SVGInject(this)">
                                        </div>
        
                                        <div class="BlockBox">
                                            <input type="text" value="<?php echo @$nome_Produto ?>" name="nome_Produto" id="nome_Produto" maxlength="200" required>
                                            <span>Nome:</span>
                                            <p class="lengthInput nome_produto_Input"></p>
                                        </div>
    
                                        <div class="BlockBox">
                                            <input type="text" value="<?php echo @$valor_Produto ?>" name="valor_Produto" id="valor_Produto" maxlength="100" required>
                                            <span>Valor:</span>
                                        </div>
                                        
                                        <div class="litros_checkBox">
                                            <?php
                                                if($litros_Produto == "" || $litros_Produto == null){
                                                    echo "<input type='checkbox' id='litros_checkBox' name='litros_checkBox' onclick='litrosCheck()'>";
                                                }else { echo "<input type='checkbox' id='litros_checkBox' name='litros_checkBox' onclick='litrosCheck()' checked>"; }
                                            ?>
                                            <label for="litros_checkBox">É medido por litros?</label>
                                        </div>
    
                                        <div class="mercadoLivre_checkBox" >
                                            <?php
                                                if($mercadoLivre_Produto == "" || $mercadoLivre_Produto == null){
                                                    echo "<input type='checkbox' id='mercadoLivre_checkBox' name='mercadoLivre_checkBox' onclick='mercadoLivreCheck()'>";
                                                }else { echo "<input type='checkbox' id='mercadoLivre_checkBox' name='mercadoLivre_checkBox' onclick='mercadoLivreCheck()' checked>"; }
                                            ?>
                                            <label for="mercadoLivre_checkBox">Link para o mercado livre?</label>
                                        </div>
                                    </div>
    
                                    <div class="Infos">
                                        <div class="BlockBox descricaoBox">
                                            <textarea type="text" name="descri_Produto" id="descri_Produto" maxlength="2000" required><?php echo @$descricao_Produto ?></textarea>
                                            <span>Descrição:</span>
                                            <p class="lengthInput descri_produto_Input"></p>
                                        </div>
        
                                        <div class="Select_Produtos">
                                            <div id="category-select">
                                                <input type="checkbox" id="options_btn_Categorias" onchange="OptionSelection('selected_val_Categorias', 'options_btn_Categorias', 'option_Categorias');">
        
                                                <div id="select-button">
                                                    <div id='selected_val_Categorias'> <?php echo $categoria_Produto ?>  </div>
                                                    <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                                </div>
                                            </div>
                                            
                                            <ul id="options">
                                                <?php 
                                                    $query = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
                                                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                                    for ($j=0; $j < count($dados); $j++) {
                                                        $nome_categorias = $dados[$j]['nome'];

                                                        if($nome_categorias == $categoria_Produto){
                                                            echo "
                                                            <li class='option_Categorias'>
                                                                <input type='radio' name='categoria_Produto' value='$nome_categorias' data-label='$nome_categorias' checked>
                                                                <span class='label'>$nome_categorias</span>
                                                            </li>
                                                            ";
                                                        }
                                                        else{
                                                            echo "
                                                            <li class='option_Categorias'>
                                                                <input type='radio' name='categoria_Produto' value='$nome_categorias' data-label='$nome_categorias'>
                                                                <span class='label'>$nome_categorias</span>
                                                            </li>
                                                            ";
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </div>
        
                                        <div class="Select_Produtos Select_subCateg_lista">
                                            <div id="category-select">
                                                <input type="checkbox" id="options_btn_SubCategorias" onchange="OptionSelection('selected_val_SubCategorias', 'options_btn_SubCategorias', 'option_SubCategorias');">
        
                                                <div id="select-button">
                                                    <div id='selected_val_SubCategorias'><?php echo $subcategoria_Produto ?></div>
                                                    <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                                </div>
                                            </div>

                                            <ul id='options' class='listagem_subcat'> 
                                                <li class='option_SubCategorias' style='pointer-events: none;'>
                                                    <input type='radio' name='SubCategoria_Produto' value='null' data-label='null'>
                                                    <span class='label'> Selecione uma categoria antes </span>
                                                </li>
                                            </ul> 
                                        </div>
        
                                        <div class="Select_Produtos">
                                            <div id="category-select">
                                                <input type="checkbox" id="options_btn_Codigos" onchange="OptionSelection('selected_val_Codigos', 'options_btn_Codigos', 'option_Codigos');">
        
                                                <div id="select-button">
                                                    <div id='selected_val_Codigos'><?php echo $codigo_Produto ?></div>
                                                    <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                                </div>
                                            </div>
                                            
                                            <ul id="options">
                                                <?php 
                                                    $query = $pdo->query("SELECT * FROM codigos ORDER BY id DESC");
                                                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                                    for ($j=0; $j < count($dados); $j++) {
                                                        $nome_codigos = $dados[$j]['nome'];
                                                        if($nome_codigos === $codigo_Produto){
                                                            echo "
                                                                <li class='option_Codigos'>
                                                                    <input type='radio' name='codigo_Produto' value='$nome_codigos' data-label='$nome_codigos' checked>
                                                                    <span class='label'>$nome_codigos</span>
                                                                </li>
                                                                
                                                            ";
                                                        }
                                                        else{
                                                            echo "
                                                                <li class='option_Codigos'>
                                                                    <input type='radio' name='codigo_Produto' value='$nome_codigos' data-label='$nome_codigos'>
                                                                    <span class='label'>$nome_codigos</span>
                                                                </li>
                                                            ";
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </div>
        
                                        <div class="BlockBox">
                                            <input type="text" value="<?php echo @$marca_Produto ?>" name="marca_Produto" id="marca_Produto" maxlength="150" required>
                                            <span>Marca:</span>
                                            <p class="lengthInput marca_produto_Input"></p>
                                        </div>
                                        
                                        <?php
                                            if($litros_Produto == "" || $litros_Produto == null){
                                                echo ' <div class="BlockBox estoque_input"> ';
                                            }else{  echo ' <div class="BlockBox estoque_input metade"> '; }
                                        ?>
                                            <input type="number" value='<?php echo @$estoque_Produto ?>' name="estoque_Produto" id="estoque_Produto" required>
                                            <span>Estoque:</span>
                                        </div>

                                        <?php
                                            if($litros_Produto == "" || $litros_Produto == null){
                                                echo ' <div class="BlockBox hide litros_input"> ';
                                            }else{  echo ' <div class="BlockBox litros_input"> '; }
                                        ?>
                                            <input type="text" value='<?php echo @$litros_Produto ?>' name="litros_Produto" id="litros_Produto" maxlength="50">
                                            <span>Litros:</span>
                                        </div>
                                            
                                        <?php
                                            if($mercadoLivre_Produto == "" || $mercadoLivre_Produto == null){
                                                echo "<div class='BlockBox hide mercadoLivre_input'>";
                                            }else { echo "<div class='BlockBox mercadoLivre_input'>"; }
                                        ?>
                                            <input type="text" value="<?php echo @$mercadoLivre_Produto ?>" name="mercadoLivre_Produto" id="mercadoLivre_Produto" maxlength="500">
                                            <span>Link mercado livre:</span>
                                            <p class="lengthInput mercadoLivre_produto_Input"></p>
                                        </div>
                                    </div>
    
                                    <p>Passo 1 de 2</p>
                                    <button type="button" onclick="document.getElementById('ItensRelac_btn').click();">Ir para itens relacionados</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ItensRelac">
                                <div class="tabBox">

                                    <div class="BoxSelect_Dinamico">
                                        <div class="SeletoresProds">
                                            Selecione um código para o produto!
                                        </div>
                                    </div>
    
                                    <div class="aviso">
                                        <img src="../../assets/icons/!.svg">
                                        <p>Deixando a aba de 'itens relacionados' vazia, fará com que os produtos recomendados na 'página do produto' sejam produtos com código igual ao do item atual!</p>
                                    </div>

                                    <input type="hidden" id="id_produto_edit" name="id_produto_edit" value="<?php echo @$id_Produto_edit ?>" required>
                                    <input type="hidden" id="date_criacao_Produto" name="date_criacao_Produto" value="<?php echo @$date_criacao_Produto ?>" required>
                                    <input type="hidden" id="date_atual_Produto" name="date_atual_Produto" value="<?php echo @$date_atual_Produto ?>" required>
                                    <input type="hidden" id="status_Produto_edit" name="status_Produto_edit" value="<?php echo @$status ?>" required>


                                    <span>Passo 2 de 2</span>
                                    <button type="button" onclick="document.getElementById('DadosProduto_btn').click();">Voltar</button>
                                    <button class="SalvarBtnModal" type="submit"><?php echo $btn_Produto ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_InsertEdit_Produto"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Produtos-->
<div class="modal fade" id="ModalDeletProduto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <form id="form_Delete_Produtos" method="POST">
                    <div class="modal-body">
                        <h4>Gostaria mesmo de excluir este produto?</h4>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_prod_delete" name="id_prod_delete" value="<?php echo @$_GET['id'] ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="ExcluirBtnModal" type="submit">Excluir</button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_delete_Prod"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Status Produtos-->
<div class="modal fade" id="ModalStatusProduto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <?php 
                    $id_prod_stats = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM produtos WHERE id = '$id_prod_stats' LIMIT 1");
                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                    if(@count($dados) > 0){
                        $status_date_criacao_prod = $dados[0]['data_criacao'];
                        $status_date_atual_prod = $dados[0]['data_atual'];
                        $status_prod = $dados[0]['status_prod'];
                    }

                    if($status_prod === "ativo" || $status_prod == "" || $status_prod == null){
                        $bodyStatus = "
                            <div class='modal-body'>
                                <h4>Gostaria mesmo de desativar este Produto?</h4>
                            </div>
                            <div class='modal-footer'>
                                <input type='hidden' id='id_prod_stats' name='id_prod_stats' value='".@$id_prod_stats."' required>
                                <input type='hidden' id='status_date_criacao_prod' name='status_date_criacao_prod' value='".@$status_date_criacao_prod."' required>
                                <input type='hidden' id='status_date_atual_prod' name='status_date_atual_prod' value='".@$status_date_atual_prod."' required>
                                <input type='hidden' id='status_prod' name='status_prod' value='".@$status_prod."' required>

                                <button class='CancelaBtnModal' type='button' data-dismiss='modal'> Cancelar </button>
                                <button class='ExcluirBtnModal' type='submit'> Desativar </button>
                            </div>
                        ";
                    }
                    if($status_prod === "inativo"){
                        $bodyStatus = "
                            <div class='modal-body'>
                                <h4>Gostaria mesmo de ativar este Produto?</h4>
                            </div>
                            <div class='modal-footer'>
                                <input type='hidden' id='id_prod_stats' name='id_prod_stats' value='".@$id_prod_stats."' required>
                                <input type='hidden' id='status_date_criacao_prod' name='status_date_criacao_prod' value='".@$status_date_criacao_prod."' required>
                                <input type='hidden' id='status_date_atual_prod' name='status_date_atual_prod' value='".@$status_date_atual_prod."' required>
                                <input type='hidden' id='status_prod' name='status_prod' value='".@$status_prod."' required>

                                <button class='CancelaBtnModal' type='button' data-dismiss='modal'> Cancelar </button>
                                <button class='SalvarBtnModal' type='submit'> Ativar </button>
                            </div>
                        ";
                    }
                    if($status_prod === "sem_estoque"){
                        $ativa = 'ativa';
                        $inativa = 'inativa';

                        $bodyStatus = '
                            <div class="modal-body">
                                <h4>Este produto atualmente está sem estoque. gostaria de:</h4>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="id_prod_stats" name="id_prod_stats" value="'.$id_prod_stats.'" required>
                                <input type="hidden" id="status_date_criacao_prod" name="status_date_criacao_prod" value="'.$status_date_criacao_prod.'" required>
                                <input type="hidden" id="status_date_atual_prod" name="status_date_atual_prod" value="'.$status_date_atual_prod.'" required>
                                <input type="hidden" id="status_prod" name="status_prod" value="" required>

                                <button class="SalvarBtnModal" type="button" onclick="atualizaStatusProd(`'.$ativa.'`)"> Ativar </button>
                                <button class="ExcluirBtnModal" type="button" onclick="atualizaStatusProd(`'.$inativa.'`)"> Desativar </button>

                                <button class="hide submitStatusProd" type="submit"></button>
                            </div>
                        ';
                    }
                ?>

                <form id="form_status_Produtos" method="POST">
                    <?php echo @$bodyStatus ?>
                </form>

                <div class="msgErro" id="msgErro_status_Prod"></div>
            </div>
        </div>
    </div>
</div>


<!-- ***********CODIGOS************ --> 
<!-- Modal Cria / Editar Codigos -->
<div class="modal fade" id="ModalCodigos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <?php 
                    if (@$_GET['funcao'] == 'editCodigo') {
                        $titulo_Codigo = "Edição de código!";
                        $btn_Codigo = "Salvar edição";

                        $id_Codigo_edit = $_GET['id'];

                        $query = $pdo->query("SELECT * FROM codigos WHERE id = '$id_Codigo_edit' LIMIT 1");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        if(@count($dados) > 0){
                            $nome_Codigo_edit = $dados[0]['nome'];
                            $date_criacao_Codigo_edit = $dados[0]['data_criacao'];
                            $date_atual_Codigo_edit = $dados[0]['data_atual'];
                        }
                    }else{
                        $titulo_Codigo = "Novo código!"; 
                        $btn_Codigo = "Adicionar";
                    }
                ?>

                <form id="form_Codigos" method="POST">
                    <div class="modal-body">
                        <h4><?php echo $titulo_Codigo ?></h4>
                        
                        <div class="BlockBox">
                            <input type="text" value="<?php echo @$nome_Codigo_edit ?>" name="nome_Codigo" id="nome_Codigo" maxlength="10" required>
                            <span>Código:</span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_Codigo_edit" name="id_Codigo_edit" value="<?php echo @$id_Codigo_edit ?>" required>
                        <input type="hidden" id="nome_Codigo_edit" name="nome_Codigo_edit" value="<?php echo @$nome_Codigo_edit ?>" required>
                        <input type="hidden" id="date_criacao_Codigo_edit" name="date_criacao_Codigo_edit" value="<?php echo @$date_criacao_Codigo_edit ?>" required>
                        <input type="hidden" id="date_atual_Codigo_edit" name="date_atual_Codigo_edit" value="<?php echo @$date_atual_Codigo_edit ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="SalvarBtnModal" type="submit"><?php echo $btn_Codigo ?></button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_InsertEdit_Codigos"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal listagem Codigos -->
<div class="modal fade" id="ModalListagemCodigos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <div class="modal-body">
                
                    <h4>Tabela de códigos</h4>

                    <table id="CodigosTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Produto atrelado</th>
                                <th>Data criação / Ultima alteração</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = $pdo->query("SELECT * FROM codigos ORDER BY id DESC");
                                $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                                for ($i=0; $i < count($dados); $i++) { 
                                    
                                    $id_Codigos = $dados[$i]['id'];
                                    $nome_Codigos = $dados[$i]['nome'];
                                    $data_criacao_Codigos = $dados[$i]['data_criacao'];
                                    $data_atual_Codigos = $dados[$i]['data_atual'];
                                    $produto_atrelado = $dados[$i]['produto_atrelado'];

                                    if($data_atual_Codigos == "" || $data_atual_Codigos == null){
                                        $datas = $data_criacao_Codigos;
                                    }else{
                                        $datas = $data_criacao_Codigos. " - " .$data_atual_Codigos;
                                    }

                                    echo "
                                        <tr>
                                            <td class='nomeCodigo'>
                                                <p>".$nome_Codigos."</p>
                                            </td>
                                            <td class='produto_atrelado'>
                                                <p>".$produto_atrelado."</p>
                                            </td>
                                            <td class='datasCodigo'>
                                                ".$datas."
                                            </td>
                                            <td class='acoesCodigo'>
                                                <a href='index.php?pag=listagemProduto&funcao=deleteCodigo&id=".$id_Codigos."'><img src='../../assets/icons/delet.svg'></a>
                                                <a href='index.php?pag=listagemProduto&funcao=editCodigo&id=".$id_Codigos."'><img src='../../assets/icons/edit.svg'></a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>

                    <button class="produtos_Btn_CriacaoCodigo" type="button" data-toggle="modal" data-target="#ModalCodigos">
                        <p>Novo código</p>
                        <img src="../../assets/icons/add.svg" >
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Codigos-->
<div class="modal fade" id="ModalDeleteCodigos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <form id="form_delete_Codigos" method="POST">
                    <div class="modal-body">
                        <h4>Gostaria mesmo de excluir esse código?</h4>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_Codigo_delete" name="id_Codigo_delete" value="<?php echo @$_GET['id'] ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="ExcluirBtnModal" type="submit">Excluir</button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_delete_Codigos"></div>
            </div>
        </div>
    </div>
</div>



<!-- LISTAGENS DINAMICAS -->
<!-- subcategorias -->
<form id="form_listagem_subCateg" class="hide" method="POST">
    <input type="hidden" id="subcategoria_lista_edit" name="subcategoria_lista_edit" value="">
    <input type="hidden" id="categoria_lista_subCateg" name="categoria_lista_subCateg" value="">
</form>

<!-- produtos relacionados -->
<form id="form_listagem_prodRelac" class="hide" method="POST">
    <input type="hidden" id="codigo_lista_prodRelac" name="codigo_lista_prodRelac" value="">
</form>

<form id="form_itemAtr_Listagem" class="hide" method="POST">
    <input type="hidden" id="id_edit_prod" name="id_edit_prod" value="">
    <input type="hidden" id="codigo_Select" name="codigo_Select" value="">
    <input type="hidden" id="numItem_list" name="numItem_list" value="">
    <input type="hidden" id="item_atr1_list" name="item_atr1_list" value="">
    <input type="hidden" id="item_atr2_list" name="item_atr2_list" value="">
    <input type="hidden" id="item_atr3_list" name="item_atr3_list" value="">
    <input type="hidden" id="item_atr4_list" name="item_atr4_list" value="">
</form>

<form id="form_itemAtr_Infos" class="hide" method="POST">
    <input type="hidden" id="numItem_info" name="numItem_info" value="">
    <input type="hidden" id="item_atr1_info" name="item_atr1_info" value="">
    <input type="hidden" id="item_atr2_info" name="item_atr2_info" value="">
    <input type="hidden" id="item_atr3_info" name="item_atr3_info" value="">
    <input type="hidden" id="item_atr4_info" name="item_atr4_info" value="">
</form>

<!-- atualiza estoque -->
<form id="form_Atualiza_Estoque" class="hide" method="POST">
    <input type="hidden" id="id_Produto_estoque" name="id_Produto_estoque" value="">
    <input type="hidden" id="estoque_Edit" name="estoque_Edit" value="">
</form>


<!-- FUNÇÕES PHP NA CHAMADA DE MODAL -->
<?php
    if (@$_GET["funcao"] == "novoProd" || @$_GET["funcao"] == "editProd") {
        echo "<script language='javascript'> $('#ModalProduto').modal('show');</script>";
    }
    else if(@$_GET["funcao"] == "deleteProd"){
        echo "<script language='javascript'> $('#ModalDeletProduto').modal('show');</script>";
    }
    else if(@$_GET["funcao"] == "statusProd"){
        echo "<script language='javascript'> $('#ModalStatusProduto').modal('show');</script>";
    }

    if (@$_GET["funcao"] == "novoCodigo" || @$_GET["funcao"] == "editCodigo") {
        echo "<script language='javascript'> $('#ModalCodigos').modal('show');</script>";
    }
    else if(@$_GET["funcao"] == "deleteCodigo"){
        echo "<script language='javascript'> $('#ModalDeleteCodigos').modal('show');</script>";
    }
?>


<script>
    //ATUALIZA ESTOQUE PROD
    function atualizaEstoque(id){
        $('#id_Produto_estoque').val(id);
        $('#estoque_Edit').val($(`#${id}`).val());
        $('#form_Atualiza_Estoque').click();
    }

    //ATUALIZA STATUS PROD
    function atualizaStatusProd(status){
        $('#status_prod').val(status)
        $('.submitStatusProd').click();
    }

    //VERIFICACAO GERAL DE TAMANHOS DE INPUT
    setInterval(
        function () {
            verificaTamanhoInput('nome_Produto', 'nome_produto_Input', 200);
            verificaTamanhoInput('descri_Produto', 'descri_produto_Input', 2000);
            verificaTamanhoInput('marca_Produto', 'marca_produto_Input', 150);
            verificaTamanhoInput('mercadoLivre_Produto', 'mercadoLivre_produto_Input', 500);
    }, 1000);

    //CHAMADA DE FUNÇÃO PARA UPLOAD DE IMG BANCO DE DADOS
    function carregarImgProduto(){ carregarImagem('img_Produto_Input', 'target_imgProduto', "../../assets/icons/placeholder.svg", 'img_produto_modal'); }
    
    //MASCARA PARA INSERÇÃO DE VALOR
    $('#valor_Produto').mask('000.000.000.000.000.00', {reverse: true});
   
    //LISTAGENS DINAMICAS 
    //// Subcategorias
    document.querySelectorAll('.option_Categorias input').forEach(input => { 
        input.addEventListener('click', event => {
            $("#categoria_lista_subCateg").val(input.dataset.label);

            $("#subcategoria_lista_edit").val($('#selected_val_SubCategorias').text());

            if($("#selected_val_SubCategorias").text() !== "Selecione a subcategoria"){
                $("#selected_val_SubCategorias").html("Selecione a subcategoria");
            }
            $("#form_listagem_subCateg").click();
        });
    });

    ////Produtos relacionados
    document.querySelectorAll('.option_Codigos input').forEach(input => { 
        input.addEventListener('click', event => {
            $("#codigo_lista_prodRelac").val(input.dataset.label);
            $("#codigo_Select").val(input.dataset.label);

            $("#form_listagem_prodRelac").click();
        });
    });

    // //Itens atrelados + listagem dinamica
    function RunCodeItens(item){
        const valoresItens = {
            "1": $('input[name="ItemAtr1_Produto"]:checked').val(),
            "2": $('input[name="ItemAtr2_Produto"]:checked').val(),
            "3": $('input[name="ItemAtr3_Produto"]:checked').val(),
            "4": $('input[name="ItemAtr4_Produto"]:checked').val()
        };

        const showError = (num) => {
            $(`input[name="ItemAtr${num}_Produto"]:checked`).prop('checked', false);
            $(`input[name="ItemAtr${num}_Produto"]`).each(function () {
                if ($(this).val() === $(`#item_atr${num}_list`).val()) $(this).prop('checked', true);
            });
            $('#msgErro_InsertEdit_Produto').addClass('text-danger').text('Produto selecionado em outro campo!');
        };

        const buscaInfo = (num) => {
            $("#numItem_info").val(num);
            $(`#item_atr${num}_info`).val(valoresItens[num]);
            $("#form_itemAtr_Infos").click();
            $(`#options_btn_ItemAtr${num}`).click();
        };

        const list = (num) => {
            $("#numItem_list").val(num);
            for (let i = 1; i <= num; i++) {
                $(`#item_atr${i}_list`).val(valoresItens[i]);
            }
            $("#form_itemAtr_Listagem").click();
        };

        if(item == 1){
            if(valoresItens[2] == undefined && valoresItens[3] == undefined && valoresItens[4] == undefined){
                list(2);
                $("#select_item2").removeClass("Disabled");
                buscaInfo(1);
            }
            else if(valoresItens[2] != undefined && valoresItens[3] == undefined && valoresItens[4] == undefined){
                if(valoresItens[1] != valoresItens[2]){
                    list(2);
                    buscaInfo(1);
                }
                else{ showError(1) }
            }
            else if(valoresItens[2] != undefined && valoresItens[3] != undefined && valoresItens[4] == undefined){
                if(valoresItens[1] != valoresItens[2]){
                    if(valoresItens[1] != valoresItens[3]){
                        list(2);
                        setTimeout(() => { list(3); }, 1000);
                        buscaInfo(1);
                    }
                    else{ showError(1) }
                }
                else{ showError(1) }
            }
            else if(valoresItens[2] != undefined && valoresItens[3] != undefined && valoresItens[4] != undefined){
                if(valoresItens[1] != valoresItens[2]){
                    if(valoresItens[1] != valoresItens[3]){
                        if(valoresItens[1] != valoresItens[4]){
                            list(2);
                            setTimeout(() => { list(3); }, 1000);
                            setTimeout(() => { list(4); }, 2000);
                            buscaInfo(1);
                        }
                        else{ showError(1) }
                    }
                    else{ showError(1) }
                }
                else{ showError(1) }
            }
        }
        
        if(item == 2){
            if(valoresItens[3] == undefined && valoresItens[4] == undefined){
                list(3);
                $("#select_item3").removeClass("Disabled");
                buscaInfo(2);
            }
            else if(valoresItens[3] != undefined && valoresItens[4] == undefined){
                if(valoresItens[2] != valoresItens[3]){
                    list(3);
                    buscaInfo(2);
                }
                else{ showError(2) }
            }
            else if(valoresItens[3] != undefined && valoresItens[4] != undefined){
                if(valoresItens[2] != valoresItens[3]){
                    if(valoresItens[2] != valoresItens[4]){
                        list(3);
                        setTimeout(() => { list(4); }, 1000);
                        buscaInfo(2);
                    }
                    else{ showError(2) }
                }
                else{ showError(2) }
            }
        }

        if(item == 3){
            if(valoresItens[4] == undefined){
                list(4);
                $("#select_item4").removeClass("Disabled");
                buscaInfo(3);
            }
            else if(valoresItens[4] != undefined){
                if(valoresItens[3] != valoresItens[4]){
                    list(4);
                    buscaInfo(3);
                }
                else{ showError(3) }
            }
        }

        if (item == 4) { buscaInfo(4); }
    }

    //CHECKBOX'S
    function litrosCheck() {
        if($(".litros_input").hasClass("hide")){
            $(".litros_input").removeClass("hide");
            $(".estoque_input").addClass("metade");
        }else{
            $(".litros_input").addClass("hide");
            $(".estoque_input").removeClass("metade");
        }
    }
    function mercadoLivreCheck() {
        if($(".mercadoLivre_input").hasClass("hide")){
            $(".Infos .BlockBox").height('16.6%');
            $(".descricaoBox").height('35%');
            $(".mercadoLivre_input").removeClass("hide");

        }else{
            $(".Infos .BlockBox").height('22.5%');
            $(".descricaoBox").height('40%');
            $(".mercadoLivre_input").addClass("hide");
        }
    }

    //UPLOAD DAS INFOS NO BANCO DE DADOS
    $("#form_Produtos").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "Produtos/produto/insert_Edit.php",
            type: 'POST',
            data: formData,
            success: function (msg) {
                $('#msgErro_InsertEdit_Produto').removeClass('text-danger');
                $('#msgErro_InsertEdit_Produto').addClass('text-warning');
                $('#msgErro_InsertEdit_Produto').text('carregando...');
                if (msg.trim() === "Produto adicionado com Sucesso!!" || msg.trim() === "Produto Atualizado com Sucesso!!" ) {
                    $('#msgErro_InsertEdit_Produto').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Produto').removeClass('text-danger');
                    $('#msgErro_InsertEdit_Produto').addClass('text-success');
                    $('#msgErro_InsertEdit_Produto').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=listagemProduto'; }, 1500);
                }
                else {
                    $('#msgErro_InsertEdit_Produto').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Produto').addClass('text-danger');
                    $('#msgErro_InsertEdit_Produto').text(msg);
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload){ myXhr.upload.addEventListener('progress', function() {}, false); }
                return myXhr;
            }
        });
    });

    $('#form_Delete_Produtos').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/delete.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Excluído com Sucesso!!") {
                    $('#msgErro_delete_Prod').removeClass('text-warning');
                    $('#msgErro_delete_Prod').removeClass('text-danger');
                    $('#msgErro_delete_Prod').addClass('text-success');
                    $('#msgErro_delete_Prod').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=listagemProduto'; }, 1500);
                }
                else{
                    $('#msgErro_delete_Prod').removeClass('text-success');
                    $('#msgErro_delete_Prod').removeClass('text-warning');
                    $('#msgErro_delete_Prod').addClass('text-danger');
                    $('#msgErro_delete_Prod').text(msg)
                }
            }
        })
    });

    $('#form_status_Produtos').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/update_status.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Status atualizado com sucesso!!") {
                    $('#msgErro_status_Prod').removeClass('text-warning');
                    $('#msgErro_status_Prod').removeClass('text-danger');
                    $('#msgErro_status_Prod').addClass('text-success');
                    $('#msgErro_status_Prod').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=listagemProduto'; }, 500);
                }
                else{
                    $('#msgErro_status_Prod').removeClass('text-success');
                    $('#msgErro_status_Prod').removeClass('text-warning');
                    $('#msgErro_status_Prod').addClass('text-danger');
                    $('#msgErro_status_Prod').text(msg)
                }
            }
        })
    });

    $('#form_Codigos').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/codigo/insert_Edit.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Código adicionado com Sucesso!!" || msg.trim() === "Código Atualizado com Sucesso!!") {
                    $('#msgErro_InsertEdit_Codigos').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Codigos').removeClass('text-danger');
                    $('#msgErro_InsertEdit_Codigos').addClass('text-success');
                    $('#msgErro_InsertEdit_Codigos').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=listagemProduto'; }, 500);
                }
                else{
                    $('#msgErro_InsertEdit_Codigos').removeClass('text-success');
                    $('#msgErro_InsertEdit_Codigos').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Codigos').addClass('text-danger');
                    $('#msgErro_InsertEdit_Codigos').text(msg)
                }
            }
        })
    });

    $('#form_delete_Codigos').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/codigo/delete.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Excluído com Sucesso!!") {
                    $('#msgErro_delete_Codigos').removeClass('text-warning');
                    $('#msgErro_delete_Codigos').removeClass('text-danger');
                    $('#msgErro_delete_Codigos').addClass('text-success');
                    $('#msgErro_delete_Codigos').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=listagemProduto'; }, 1500);
                }
                else{
                    $('#msgErro_delete_Codigos').removeClass('text-success');
                    $('#msgErro_delete_Codigos').removeClass('text-warning');
                    $('#msgErro_delete_Codigos').addClass('text-danger');
                    $('#msgErro_delete_Codigos').text(msg)
                }
            }
        })
    });

    //LISTAGENS DINAMICAS
    //// Subcategorias
    $('#form_listagem_subCateg').click(function (e) {
        $('.listagem_subcat').remove();
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/List_Subcateg.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('.Select_subCateg_lista').append(msg);
            }
        })
    });

    //// itens relacionados
    $('#form_listagem_prodRelac').click(function (e) {
        $('.SeletoresProds').remove();
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/List_ProdRelac.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('.BoxSelect_Dinamico').append(msg);
            }
        })
    });

    $('#form_itemAtr_Listagem').click(function (e) {
        $('#msgErro_InsertEdit_Produto').text('');
        if($("#numItem_list").val() == '1'){ $(".List_Itens_1").remove(); }
        if($("#numItem_list").val() == '2'){ $(".List_Itens_2").remove(); }
        if($("#numItem_list").val() == '3'){ $(".List_Itens_3").remove(); }
        if($("#numItem_list").val() == '4'){ $(".List_Itens_4").remove(); }
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/List_ItemAtr.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if($("#numItem_list").val() == '1'){
                    $('#select_item1').append(msg);
                }
                if($("#numItem_list").val() == '2'){
                    $('#select_item2').append(msg);
                }
                if($("#numItem_list").val() == '3'){
                    $('#select_item3').append(msg);
                }
                if($("#numItem_list").val() == '4'){
                    $('#select_item4').append(msg);
                }
            }
        });
    });

    $('#form_itemAtr_Infos').click(function (e) {
        $('#msgErro_InsertEdit_Produto').text('');
        if($("#numItem_info").val() == '1'){ $(".select_ItemAtr1").remove(); }
        if($("#numItem_info").val() == '2'){ $(".select_ItemAtr2").remove(); }
        if($("#numItem_info").val() == '3'){ $(".select_ItemAtr3").remove(); }
        if($("#numItem_info").val() == '4'){ $(".select_ItemAtr4").remove(); }

        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/Infos_ItemAtr.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if($("#numItem_info").val() == '1'){ 
                    $('.ItemAtr1_head').append(msg);
                }
                if($("#numItem_info").val() == '2'){ 
                    $('.ItemAtr2_head').append(msg);
                }
                if($("#numItem_info").val() == '3'){ 
                    $('.ItemAtr3_head').append(msg);
                }
                if($("#numItem_info").val() == '4'){ 
                    $('.ItemAtr4_head').append(msg);
                }

            }
        })
    });

    //ATUALIZA ESTOQUE
    $('#form_Atualiza_Estoque').click(function (e) {
        $('#msgErro_edit_Estoque').text('');
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/atualiza_estoque.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('#msgErro_edit_Estoque').append(msg);
                setTimeout(() => { window.location='./index.php?pag=listagemProduto'; }, 500);
            }
        })
    });

</script>