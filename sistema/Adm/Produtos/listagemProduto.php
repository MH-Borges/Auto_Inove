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
                <th>Nome da categoria</th>
                <th>Sub-Categorias atreladas</th>
                <th>Data criação / Ultima alteração</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < count($dados); $i++) { 
                    
                    $nomeUser = $dados[$i]['nome_Completo'];
                    $temaUser = $dados[$i]['tema'];
                    $emailUser = $dados[$i]['email'];
                    $telUser = $dados[$i]['telefone'];

                    echo "
                        <tr>
                            <td class='imgsCateg'>
                                ".$nomeUser."
                            </td>
                            <td class='nomeCateg'>
                                ".$temaUser."
                            </td>
                            <td class='subCategsCateg'>
                                ".$emailUser."
                            </td>
                            <td class='datasCateg'>
                                ".$telUser."
                            </td>
                            <td class='statusCateg'>
                                ".$telUser."
                            </td>
                            <td class='acoesCateg'>
                                ".$telUser."
                            </td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>


<!-- ***********PRODUTOS************ --> 
<!-- Modal Cria / Editar Produtos -->
<div class="modal fade" id="ModalProduto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="window.location='./index.php?pag=listagemProduto';">
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
                            $Item_Relac_01 = $dados[0]['Item_Relac_01'];
                            $Item_Relac_02 = $dados[0]['Item_Relac_02'];
                            $Item_Relac_03 = $dados[0]['Item_Relac_03'];
                            $Item_Relac_04 = $dados[0]['Item_Relac_04'];
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
                            <a id="DadosProduto_btn" data-toggle="pill" href="#DadosProduto"><?php echo $titulo_Produto ?></a>
                            <a id="ItensRelac_btn" class="active" data-toggle="pill" href="#ItensRelac">Itens relacionados</a>
                        </div>
                        <div class="tab-content Tabs_produtos">
                            <div class="tab-pane fade" id="DadosProduto">
                                <div class="tabBox">
                                    <div class="Base_checkbox">
                                        <div class="Img_Produto">
                                            <input type="file" value="<?php echo @$img_Produto ?>" id="img_Produto_Input" name="img_Produto_Input" onChange="carregarImgProduto();">
                                            <?php
                                                if(@$img_Produto == "placeholder.svg" || @$img_Produto == ""){
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
                                            <textarea type="text" name="descri_Produto" id="descri_Produto" maxlength="500" required><?php echo str_replace('<br />', PHP_EOL, @$descricao_Produto); ?></textarea>
                                            <span>Descrição:</span>
                                            <p class="lengthInput descri_produto_Input"> 150 / 25</p>
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
                                                        echo "
                                                        <li class='option_Categorias'>
                                                            <input type='radio' name='categoria_Produto' value='$nome_categorias' data-label='$nome_categorias'>
                                                            <span class='label'>$nome_categorias</span>
                                                        </li>
                                                        ";
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
                                                <li class='option_SubCategorias' style="pointer-events: none;">
                                                    <input type='radio' name='SubCategoria_Produto' value='null' data-label='null'>
                                                    <span class='label'>Selecione uma categoria antes</span>
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
                                                        echo "
                                                        <li class='option_Codigos'>
                                                            <input type='radio' name='codigo_Produto' value='$nome_codigos' data-label='$nome_codigos'>
                                                            <span class='label'>$nome_codigos</span>
                                                        </li>
                                                        ";
                                                    }
                                                ?>
                                            </ul>
                                        </div>
        
                                        <div class="BlockBox">
                                            <input type="text" value="<?php echo @$marca_Produto ?>" name="marca_Produto" id="marca_Produto" maxlength="150" required>
                                            <span>Marca:</span>
                                            <p class="lengthInput marca_produto_Input"></p>
                                        </div>
        
                                        <div class="BlockBox estoque_input">
                                            <input type="number" value="<?php echo @$estoque_Produto ?>" name="estoque_Produto" id="estoque_Produto" required>
                                            <span>Estoque:</span>
                                        </div>
    
                                        <?php
                                            if($litros_Produto == "" || $litros_Produto == null){
                                                echo "<div class='BlockBox hide litros_input'>";
                                            }else { echo "<div class='BlockBox litros_input'>"; }
                                        ?>
                                            <input type="text" value="<?php echo @$litros_Produto ?>" name="litros_Produto" id="litros_Produto" maxlength="50" required>
                                            <span>Litros:</span>
                                        </div>
        
                                        <?php
                                            if($mercadoLivre_Produto == "" || $mercadoLivre_Produto == null){
                                                echo "<div class='BlockBox hide mercadoLivre_input'>";
                                            }else { echo "<div class='BlockBox mercadoLivre_input'>"; }
                                        ?>
                                            <input type="text" value="<?php echo @$mercadoLivre_Produto ?>" name="mercadoLivre_Produto" id="mercadoLivre_Produto" maxlength="500" required>
                                            <span>Link mercado livre:</span>
                                            <p class="lengthInput mercadoLivre_produto_Input"></p>
                                        </div>
                                    </div>
    
                                    <p>Passo 1 de 2</p>
                                    <button type="button" onclick="document.getElementById('ItensRelac_btn').click();">Ir para itens relacionados</button>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="ItensRelac">
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

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                    <img src="../../assets/icons/close.svg">
                </button>

                <form id="form_delete_categorias" method="POST">
                    <div class="modal-body">
                        <h4>Gostaria mesmo de excluir esta categoria?</h4>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_categ_delete" name="id_categ_delete" value="<?php echo @$_GET['id'] ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
                        <button class="ExcluirBtnModal" type="submit">Excluir</button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_delete_Categ"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Status Produtos-->
<div class="modal fade" id="ModalStatusProduto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                    <img src="../../assets/icons/close.svg">
                </button>

                <?php 
                    $id_categ_stats = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM categorias WHERE id = '$id_categ_stats' LIMIT 1");
                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                    if(@count($dados) > 0){
                        $date_criacao_categ_stats = $dados[0]['data_criacao'];
                        $date_atual_categ_stats = $dados[0]['data_atual'];
                        $status_categ_stats = $dados[0]['status_categ'];
                    }


                    if($status_categ_stats == "" || $status_categ_stats == "ativo" || $status_categ_stats == null){
                        $btnFinal = "<button class='ExcluirBtnModal' type='submit'>Desativar</button>";
                        $titulo = "desativar";
                        $aviso = "<span>*ATENÇÃO: Todas Subcategorias atreladas a essa categoria serão tambem desativadas!</span>";
                    }
                    else{
                        $btnFinal = "<button class='SalvarBtnModal' type='submit'>Ativar</button>";
                        $titulo = "ativar";
                        $aviso = '';
                    }

                ?>

                <form id="form_status_categorias" method="POST">
                    <div class="modal-body">
                        <h4>Gostaria mesmo de <?php echo $titulo ?> está categoria?</h4>
                        <?php echo $aviso ?>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_categ_stats" name="id_categ_stats" value="<?php echo @$id_categ_stats ?>" required>
                        <input type="hidden" id="date_criacao_categ_stats" name="date_criacao_categ_stats" value="<?php echo @$date_criacao_categ_stats ?>" required>
                        <input type="hidden" id="date_atual_categ_stats" name="date_atual_categ_stats" value="<?php echo @$date_atual_categ_stats ?>" required>
                        <input type="hidden" id="status_categ_stats" name="status_categ_stats" value="<?php echo @$status_categ_stats ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
                        <?php echo $btnFinal ?>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_status_Categ"></div>
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

                <?php 
                    if(@$_GET['funcao'] == '' || @$_GET['funcao'] == null || @$_GET['funcao'] == 'novoCodigo'){
                        if(@$_GET['funcao'] == 'novoCodigo'){ $closeReload = 'onclick="history.back();"';} else { $closeReload = ''; }
                        
                        echo '
                            <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" '.$closeReload.'>
                                <img src="../../assets/icons/close.svg">
                            </button>
                        ';

                        $titulo_Codigo = "Novo código!"; 
                        $btn_Codigo = "Adicionar";
                    }
                    if (@$_GET['funcao'] == 'editCodigo') {
                        echo '
                            <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                                <img src="../../assets/icons/close.svg">
                            </button>
                        ';
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
                        <input type="hidden" id="date_criacao_Codigo_edit" name="date_criacao_Codigo_edit" value="<?php echo @$date_criacao_Codigo_edit ?>" required>
                        <input type="hidden" id="date_atual_Codigo_edit" name="date_atual_Codigo_edit" value="<?php echo @$date_atual_Codigo_edit ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
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

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                    <img src="../../assets/icons/close.svg">
                </button>

                <form id="form_delete_Codigos" method="POST">
                    <div class="modal-body">
                        <h4>Gostaria mesmo de excluir esse código?</h4>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_Codigo_delete" name="id_Codigo_delete" value="<?php echo @$_GET['id'] ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
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
    <input type="hidden" id="categoria_lista_subCateg" name="categoria_lista_subCateg" value="">
</form>

<!-- produtos relacionados -->
<form id="form_listagem_prodRelac" class="hide" method="POST">
    <input type="hidden" id="codigo_lista_prodRelac" name="codigo_lista_prodRelac" value="">
</form>

<!-- Item01 -->
<form id="form_itemAtr01_Infos" class="hide" method="POST">
    <input type="hidden" id="item_atr01" name="item_atr01" value="">
</form>

<!-- Item02 -->
<!-- Listagem -->
<form id="form_itemAtr02_Listagem" class="hide" method="POST">
    <input type="hidden" id="codigo_lista_item_atr02" name="codigo_lista_item_atr02" value="">
    <input type="hidden" id="item_atr01_List_Item02" name="item_atr01_List_Item02" value="">
</form>
<!-- infos -->
<form id="form_itemAtr02_Infos" class="hide" method="POST">
    <input type="hidden" id="item_atr02" name="item_atr02" value="">
</form>

<!-- Item03 -->
<!-- Listagem -->
<form id="form_itemAtr03_Listagem" class="hide" method="POST">
    <input type="hidden" id="codigo_lista_item_atr03" name="codigo_lista_item_atr03" value="">
    <input type="hidden" id="item_atr01_List_Item03" name="item_atr01_List_Item03" value="">
    <input type="hidden" id="item_atr02_List_Item03" name="item_atr02_List_Item03" value="">
</form>
<!-- infos -->
<form id="form_itemAtr03_Infos" class="hide" method="POST">
    <input type="hidden" id="item_atr03" name="item_atr03" value="">
</form>

<!-- Item04 -->
<!-- Listagem -->
<form id="form_itemAtr04_Listagem" class="hide" method="POST">
    <input type="hidden" id="codigo_lista_item_atr04" name="codigo_lista_item_atr04" value="">
    <input type="hidden" id="item_atr01_List_Item04" name="item_atr01_List_Item04" value="">
    <input type="hidden" id="item_atr02_List_Item04" name="item_atr02_List_Item04" value="">
    <input type="hidden" id="item_atr03_List_Item04" name="item_atr03_List_Item04" value="">
</form>
<!-- infos -->
<form id="form_itemAtr04_Infos" class="hide" method="POST">
    <input type="hidden" id="item_atr04" name="item_atr04" value="">
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
    //VERIFICACAO GERAL DE TAMANHOS DE INPUT
    setInterval(
        function () {
            verificaTamanhoInput('nome_Produto', 'nome_produto_Input', 200);
            verificaTamanhoInput('descri_Produto', 'descri_produto_Input', 500);
            verificaTamanhoInput('marca_Produto', 'marca_produto_Input', 150);
            verificaTamanhoInput('mercadoLivre_Produto', 'mercadoLivre_produto_Input', 500);
    }, 50);

    //CHAMADA DE FUNÇÃO PARA UPLOAD DE IMG BANCO DE DADOS
    function carregarImgProduto(){ carregarImagem('img_Produto_Input', 'target_imgProduto', "../../assets/icons/placeholder.svg", 'img_produto_modal'); }
    
    //MASCARA PARA INSERÇÃO DE VALOR
    $('#valor_Produto').mask('000.000.000.000.000,00', {reverse: true});
   
    //LISTAGENS DINAMICAS 
    //// Subcategorias
    document.querySelectorAll('.option_Categorias input').forEach(input => { 
        input.addEventListener('click', event => {
            $("#categoria_lista_subCateg").val(input.dataset.label);
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
            $("#codigo_lista_item_atr02").val(input.dataset.label);
            $("#codigo_lista_item_atr03").val(input.dataset.label);
            $("#codigo_lista_item_atr04").val(input.dataset.label);
            $("#form_listagem_prodRelac").click();
        });
    });

    ////Itens atrelados + listagem dinamica
    function RunCodeItens(item){ 
        ////Item atrelado 01
        if(item == 01){
            if($("#select_item02").hasClass('Disabled')){
                $("#item_atr01_List_Item02").val($('[name=ItemAtr01_Produto]').val());
                $("#form_itemAtr02_Listagem").click();
                $("#select_item02").removeClass("Disabled");
            }
            $("#item_atr01").val($('[name=ItemAtr01_Produto]').val());
            $("#form_itemAtr01_Infos").click();
            $("#options_btn_ItemAtr01").click();
        }

        ////Item atrelado 02
        if(item == 02){
            if($("#select_item03").hasClass('Disabled')){
                $("#item_atr01_List_Item03").val($('[name=ItemAtr01_Produto]').val());
                $("#item_atr02_List_Item03").val($('[name=ItemAtr02_Produto]').val());
                $("#form_itemAtr03_Listagem").click();
                $("#select_item03").removeClass("Disabled");
            }
            $("#item_atr02").val($('[name=ItemAtr02_Produto]').val());
            $("#form_itemAtr02_Infos").click();
            $("#options_btn_ItemAtr02").click();
        }

        ////Item atrelado 03
        if(item == 03){
            if($("#select_item04").hasClass('Disabled')){
                $("#item_atr01_List_Item04").val($('[name=ItemAtr01_Produto]').val());
                $("#item_atr02_List_Item04").val($('[name=ItemAtr02_Produto]').val());
                $("#item_atr03_List_Item04").val($('[name=ItemAtr03_Produto]').val());
                $("#form_itemAtr04_Listagem").click();
                $("#select_item04").removeClass("Disabled");
            }

            $("#item_atr03").val($('[name=ItemAtr03_Produto]').val());
            $("#form_itemAtr03_Infos").click();
            $("#options_btn_ItemAtr03").click();
        }

        ////Item atrelado 04
        if(item == 04){
            $("#item_atr04").val($('[name=ItemAtr04_Produto]').val());
            $("#form_itemAtr04_Infos").click();
            $("#options_btn_ItemAtr04").click();
        }
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

    // $('#form_delete_categorias').submit(function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         url: "Produtos/categoria/delete.php",
    //         method: "post",
    //         data: $('form').serialize(),
    //         dataType: "text",
    //         success: function (msg) {
    //             if (msg.trim() === "Excluído com Sucesso!!") {
    //                 $('#msgErro_delete_Categ').removeClass('text-warning');
    //                 $('#msgErro_delete_Categ').removeClass('text-danger');
    //                 $('#msgErro_delete_Categ').addClass('text-success');
    //                 $('#msgErro_delete_Categ').text(msg);
    //                 setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 1500);
    //             }
    //             else{
    //                 $('#msgErro_delete_Categ').removeClass('text-success');
    //                 $('#msgErro_delete_Categ').removeClass('text-warning');
    //                 $('#msgErro_delete_Categ').addClass('text-danger');
    //                 $('#msgErro_delete_Categ').text(msg)
    //             }
    //         }
    //     })
    // });

    // $('#form_status_categorias').submit(function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         url: "Produtos/categoria/update_status.php",
    //         method: "post",
    //         data: $('form').serialize(),
    //         dataType: "text",
    //         success: function (msg) {
    //             if (msg.trim() === "Status atualizado com sucesso!!") {
    //                 $('#msgErro_status_Categ').removeClass('text-warning');
    //                 $('#msgErro_status_Categ').removeClass('text-danger');
    //                 $('#msgErro_status_Categ').addClass('text-success');
    //                 $('#msgErro_status_Categ').text(msg);
    //                 setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 500);
    //             }
    //             else{
    //                 $('#msgErro_status_Categ').removeClass('text-success');
    //                 $('#msgErro_status_Categ').removeClass('text-warning');
    //                 $('#msgErro_status_Categ').addClass('text-danger');
    //                 $('#msgErro_status_Categ').text(msg)
    //             }
    //         }
    //     })
    // });

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

    $('#form_itemAtr01_Infos').click(function (e) {
        $(".select_ItemAtr01").remove();
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/ItemAtr01.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('.ItemAtr01_head').append(msg);
            }
        })
    });

    $('#form_itemAtr02_Listagem').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/List_ItemAtr02.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('#select_item02').append(msg);
            }
        })
    });

    $('#form_itemAtr02_Infos').click(function (e) {
        $(".select_ItemAtr02").remove();
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/ItemAtr02.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('.ItemAtr02_head').append(msg);
            }
        })
    });

    $('#form_itemAtr03_Listagem').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/List_ItemAtr03.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('#select_item03').append(msg);
            }
        })
    });

    $('#form_itemAtr03_Infos').click(function (e) {
        $(".select_ItemAtr03").remove();
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/ItemAtr03.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('.ItemAtr03_head').append(msg);
            }
        })
    });

    $('#form_itemAtr04_Listagem').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/List_ItemAtr04.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('#select_item04').append(msg);
            }
        })
    });

    $('#form_itemAtr04_Infos').click(function (e) {
        $(".select_ItemAtr04").remove();
        e.preventDefault();
        $.ajax({
            url: "Produtos/produto/relacionados/ItemAtr04.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                $('.ItemAtr04_head').append(msg);
            }
        })
    });
    
</script>