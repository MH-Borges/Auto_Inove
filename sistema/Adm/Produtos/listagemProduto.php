<div class="blockContent produtosListagem">

    <a class="produtos_Btn_CriacaoProd" href="index.php?pag=listagemProduto&funcao=novoProd">
        <p>Novo Produto</p>
        <img src="../../assets/icons/add.svg" >
    </a>
    <a class="produtos_Btn_CriacaoCodigo" href="index.php?pag=listagemProduto&funcao=novoCodigo">
        <p>Novo Código</p>
        <img src="../../assets/icons/add.svg" >
    </a>
    <button class="produtos_Btn_ListCodigos" type="button" data-toggle="modal" data-target="#ModalListagemCodigos">
        <p>Listagem de Códigos</p>
        <img src="../../assets/icons/list.svg" >
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
                            
                        }

                    } else { $titulo_Produto = "Cadastro de produto!"; $btn_Produto = "Cadastrar produto";}
                ?>

                <form id="form_Produtos" method="POST">
                    <div class="modal-body">
                        <div class="nav nav-pills Menu_produtos">
                            <a id="DadosProduto_btn" class="active" data-toggle="pill" href="#DadosProduto"><?php echo $titulo_Produto ?></a>
                            <a id="ItensRelac_btn" data-toggle="pill" href="#ItensRelac">Itens relacionados</a>
                        </div>
                        <div class="tab-content Tabs_produtos">
                            <div class="tab-pane fade show active" id="DadosProduto">


                                <button type="button" onclick="clickTab('ItensRelac_btn');">Ir para itens relacionados</button>
                            </div>
                            <div class="tab-pane fade" id="ItensRelac">
                                <!-- categ_Atreladas_Select -->
                                <div class="Select_Produtos">
                                    <div id="category-select">
                                        <input type="checkbox" id="options_btn_ItemAtr01" onchange="OptionSelection('selected_val_ItemAtr01', 'options_btn_ItemAtr01', 'option_ItemAtr01');">

                                        <div id="select-button">
                                        <div id='selected_val_ItemAtr01'> Selecione a categoria </div>
                                            <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                        </div>
                                    </div>
                                    
                                    <ul id="options" >
                                        <?php 
                                            $query2 = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
                                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                            for ($j=0; $j < count($dados2); $j++) {
                                                $nome_categ_atrelada = $dados2[$j]['nome'];
                                                echo "
                                                <li class='option_ItemAtr01'>
                                                    <input type='radio' name='categ_Atreladas' value='$nome_categ_atrelada' data-label='$nome_categ_atrelada'>
                                                    <span class='label'>$nome_categ_atrelada</span>
                                                </li>
                                                ";
                                            }
                                        ?>
                                    </ul>
                                </div>

                                <div class="Select_Produtos">
                                    <div id="category-select">
                                        <input type="checkbox" id="options_btn_ItemAtr02" onchange="OptionSelection('selected_val_ItemAtr02', 'options_btn_ItemAtr02', 'option_ItemAtr02');">

                                        <div id="select-button">
                                        <div id='selected_val_ItemAtr02'> Selecione a categoria </div>
                                            <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                        </div>
                                    </div>
                                    
                                    <ul id="options">
                                        <?php 
                                            $query2 = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
                                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                            for ($j=0; $j < count($dados2); $j++) {
                                                $nome_categ_atrelada = $dados2[$j]['nome'];
                                                echo "
                                                <li class='option_ItemAtr02'>
                                                    <input type='radio' name='categ_Atreladas' value='$nome_categ_atrelada' data-label='$nome_categ_atrelada'>
                                                    <span class='label'>$nome_categ_atrelada</span>
                                                </li>
                                                ";
                                            }
                                        ?>
                                    </ul>
                                </div>

                                <div class="Select_Produtos">
                                    <div id="category-select">
                                        <input type="checkbox" id="options_btn_ItemAtr03" onchange="OptionSelection('selected_val_ItemAtr03', 'options_btn_ItemAtr03', 'option_ItemAtr03');">

                                        <div id="select-button">
                                        <div id='selected_val_ItemAtr03'> Selecione a categoria </div>
                                            <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                        </div>
                                    </div>
                                    
                                    <ul id="options">
                                        <?php 
                                            $query2 = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
                                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                            for ($j=0; $j < count($dados2); $j++) {
                                                $nome_categ_atrelada = $dados2[$j]['nome'];
                                                echo "
                                                <li class='option_ItemAtr03'>
                                                    <input type='radio' name='categ_Atreladas' value='$nome_categ_atrelada' data-label='$nome_categ_atrelada'>
                                                    <span class='label'>$nome_categ_atrelada</span>
                                                </li>
                                                ";
                                            }
                                        ?>
                                    </ul>
                                </div>

                                <div class="Select_Produtos">
                                    <div id="category-select">
                                        <input type="checkbox" id="options_btn_ItemAtr04" onchange="OptionSelection('selected_val_ItemAtr04', 'options_btn_ItemAtr04', 'option_ItemAtr04');">

                                        <div id="select-button">
                                        <div id='selected_val_ItemAtr04'> Selecione a categoria </div>
                                            <img src="../../assets/icons/seta.svg" onload="SVGInject(this)">
                                        </div>
                                    </div>
                                    
                                    <ul id="options">
                                        <?php 
                                            $query2 = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
                                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                            for ($j=0; $j < count($dados2); $j++) {
                                                $nome_categ_atrelada = $dados2[$j]['nome'];
                                                echo "
                                                <li class='option_ItemAtr04'>
                                                    <input type='radio' name='categ_Atreladas' value='$nome_categ_atrelada' data-label='$nome_categ_atrelada'>
                                                    <span class='label'>$nome_categ_atrelada</span>
                                                </li>
                                                ";
                                            }
                                        ?>
                                    </ul>
                                </div>

                                <div class="aviso">
                                    <img src="../../assets/icons/!.svg">
                                    <span>Deixando essa aba vazia os 'itens relacionados' desse produto serão organizados por códigos similares cadastrados recentemente!</span>
                                </div>
                                <button type="button" onclick="clickTab('DadosProduto_btn');">Voltar</button>
                                <button class="SalvarBtnModal" type="submit"><?php echo $btn_Produto ?></button>
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
                            <p class="lengthInput nome_Codigo_Input"></p>
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
    //CHAMADA DE FUNÇÃO PARA UPLOAD DE IMG BANCO DE DADOS
    // function carregarImgWeb(){ carregarImagem('img_categ_Input', 'target_imgCateg', "../../assets/icons/placeholder.svg", 'img_categ_modal'); }

    //UPLOAD DAS INFOS NO BANCO DE DADOS
    // $("#form_categorias").submit(function (e) {
    //     e.preventDefault();
    //     var formData = new FormData(this);
    //     $.ajax({
    //         url: "Produtos/categoria/insert_Edit.php",
    //         type: 'POST',
    //         data: formData,
    //         success: function (msg) {
    //             $('#msgErro_InsertEdit_Categ').removeClass('text-danger');
    //             $('#msgErro_InsertEdit_Categ').addClass('text-warning');
    //             $('#msgErro_InsertEdit_Categ').text('carregando...');
    //             if (msg.trim() === "Categoria adicionada com Sucesso!!" || msg.trim() === "Categoria Atualizada com Sucesso!!" ) {
    //                 $('#msgErro_InsertEdit_Categ').removeClass('text-warning');
    //                 $('#msgErro_InsertEdit_Categ').removeClass('text-danger');
    //                 $('#msgErro_InsertEdit_Categ').addClass('text-success');
    //                 $('#msgErro_InsertEdit_Categ').text(msg);
    //                 setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 1500);
    //             }
    //             else {
    //                 $('#msgErro_InsertEdit_Categ').removeClass('text-warning');
    //                 $('#msgErro_InsertEdit_Categ').addClass('text-danger');
    //                 $('#msgErro_InsertEdit_Categ').text(msg);
    //             }
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         xhr: function () {
    //             var myXhr = $.ajaxSettings.xhr();
    //             if (myXhr.upload){ myXhr.upload.addEventListener('progress', function() {}, false); }
    //             return myXhr;
    //         }
    //     });
    // });

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

    //VERIFICACAO DE TAMANHOS DE INPUT
    setInterval(
        function () {
            verificaTamanhoInput('nome_Codigo', 'nome_Codigo_Input', 10);
    }, 50);

    function clickTab(buttonId) {
        document.getElementById(buttonId).click();
    }
</script>