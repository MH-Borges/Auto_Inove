<div class="blockContent produtosCategorias">

    <a class="produtos_Btn_CriacaoCateg" href="index.php?pag=categoriasProduto&funcao=novaCateg">
        <p>Nova categoria</p>
        <img src="../../assets/icons/add.svg" >
    </a>
    <a class="produtos_Btn_CriacaoSubcateg" href="index.php?pag=categoriasProduto&funcao=novaSubcateg">
        <p>Nova Sub-categoria</p>
        <img src="../../assets/icons/add.svg" >
    </a>
    <button class="produtos_Btn_ListSubcateg" type="button" data-toggle="modal" data-target="#ModalListagemSubcateg">
        <p>Listagem de Sub-categorias</p>
        <img src="../../assets/icons/list.svg" >
    </button>

    <h2>Tabela de categorias</h2>

    <table id="CategoriasTable">
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
                $query = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < count($dados); $i++) { 
                    
                    $id_categoria = $dados[$i]['id'];
                    $img_categoria = $dados[$i]['img'];
                    $nome_categoria = $dados[$i]['nome'];
                    $data_criacao_categoria = $dados[$i]['data_criacao'];
                    $data_atual_categoria = $dados[$i]['data_atual'];
                    $status_categoria = $dados[$i]['status_categ'];


                    if($img_categoria == "placeholder.svg" || $img_categoria == ""){
                        $img_categoria = "<img class='img_categoria' src='../../assets/icons/placeholder.svg'>";
                    }else{
                        $img_categoria = "<img class='img_categoria' src='../../assets/categorias/$img_categoria'>";
                    }

                    if($data_atual_categoria == "" || $data_atual_categoria == null){
                        $datas = $data_criacao_categoria;
                    }else{
                        $datas = $data_criacao_categoria. " - " .$data_atual_categoria;
                    }

                    echo "
                        <tr>
                            <td class='imgsCateg'>
                                ".$img_categoria."
                            </td>
                            <td class='nomeCateg'>
                                <p>".$nome_categoria."</p>
                            </td>
                            <td class='subCategsCateg'>
                                ";
                                $query2 = $pdo->query("SELECT * FROM sub_categorias where categ_Atrelada = '$nome_categoria' ORDER BY id ASC");
                                $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                $results = count($dados2);

                                $mais = '';
                                if($results > 7){
                                    $mais = '<p>Outras...</p>';
                                    $results = 7;
                                }

                                for ($j=0; $j < $results; $j++) {
                                    $nome_subcateg = $dados2[$j]['nome'];
                                    echo "<p>".$nome_subcateg."</p>";
                                }

                                echo $mais;
                    echo "
                            </td>
                            <td class='datasCateg'>
                                ".$datas."
                            </td>
                            <td class='statusCateg'>
                                <p class='".$status_categoria."'>".$status_categoria."</p>
                            </td>
                            <td class='acoesCateg'>
                                <a href='index.php?pag=categoriasProduto&funcao=deleteCateg&id=".$id_categoria."'><img src='../../assets/icons/delet.svg'></a>
                                <a href='index.php?pag=categoriasProduto&funcao=editCateg&id=".$id_categoria."'><img src='../../assets/icons/edit.svg'></a>
                                <a class='".$status_categoria."' href='index.php?pag=categoriasProduto&funcao=statusCateg&id=".$id_categoria."'><img src='../../assets/icons/light.svg' onload='SVGInject(this)'></a>
                            </td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>

<!-- ***********CATEGORIAS************ --> 
<!-- Modal Cria / Editar categorias -->
<div class="modal fade" id="Modalcateg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                    <img src="../../assets/icons/close.svg">
                </button>

                <?php 
                    if (@$_GET['funcao'] == 'editCateg') {
                        $titulo_categ = "Edição de categoria!";
                        $btn_categ = "Salvar edição";

                        $id_categ_edit = $_GET['id'];

                        $query = $pdo->query("SELECT * FROM categorias WHERE id = '$id_categ_edit' LIMIT 1");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                        if(@count($dados) > 0){
                            $img_categ_edit = $dados[0]['img'];
                            $nome_categ_edit = $dados[0]['nome'];
                            $date_criacao_categ_edit = $dados[0]['data_criacao'];
                            $date_atual_categ_edit = $dados[0]['data_atual'];
                            $status_categ_edit = $dados[0]['status_categ'];
                        }

                    } else { $titulo_categ = "Nova categoria!"; $btn_categ = "Adicionar";}
                ?>

                <form id="form_categorias" method="POST">
                    <div class="modal-body">
                        <h4><?php echo $titulo_categ ?></h4>

                        <div class="Img_Categ">
                            <input type="file" value="<?php echo @$img_categ_edit ?>" id="img_categ_Input" name="img_categ_Input" onChange="carregarImgWeb();">
                            <?php
                                if(@$img_categ_edit == "placeholder.svg" || @$img_categ_edit == ""){
                                    echo "<img class='img_categ_modal' id='target_imgCateg' src='../../assets/icons/placeholder.svg'>";
                                }else{
                                    echo "<img class='img_categ_modal imgSelected' id='target_imgCateg' src='../../assets/categorias/$img_categ_edit'>";
                                }
                            ?>
                            <img class="editPen" onclick="document.getElementById('img_categ_Input').click();" src="../../assets/icons/edit.svg" onload="SVGInject(this)">
                        </div>
                        
                        <div class="BlockBox">
                            <input type="text" value="<?php echo @$nome_categ_edit ?>" name="nome_categ" id="nome_categ" maxlength="150" required>
                            <span>Nome:</span>
                            <p class="lengthInput nome_categ_Input"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_categ_edit" name="id_categ_edit" value="<?php echo @$id_categ_edit ?>" required>
                        <input type="hidden" id="nome_categ_edit" name="nome_categ_edit" value="<?php echo @$nome_categ_edit ?>" required>
                        <input type="hidden" id="date_criacao_categ_edit" name="date_criacao_categ_edit" value="<?php echo @$date_criacao_categ_edit ?>" required>
                        <input type="hidden" id="date_atual_categ_edit" name="date_atual_categ_edit" value="<?php echo @$date_atual_categ_edit ?>" required>
                        <input type="hidden" id="status_categ_edit" name="status_categ_edit" value="<?php echo @$status_categ_edit ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
                        <button class="SalvarBtnModal" type="submit"><?php echo $btn_categ ?></button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_InsertEdit_Categ"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete categoria-->
<div class="modal fade" id="ModalDeletcateg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

<!-- Modal Status categoria-->
<div class="modal fade" id="ModalStatuscateg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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


<!-- ***********SUBCATEGORIAS************ --> 
<!-- Modal Cria / Editar sub-categorias -->
<div class="modal fade" id="ModalSubcateg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <?php 
                    if(@$_GET['funcao'] == '' || @$_GET['funcao'] == null || @$_GET['funcao'] == 'novaSubcateg'){
                        if(@$_GET['funcao'] == 'novaSubcateg'){ $closeReload = 'onclick="history.back();"';} else { $closeReload = ''; }
                        
                        echo '
                            <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" '.$closeReload.'>
                                <img src="../../assets/icons/close.svg">
                            </button>
                        ';

                        $titulo_Subcateg = "Nova sub-categoria!"; 
                        $btn_Subcateg = "Adicionar";
                        $selectBox = "Selecione a categoria";
                    }
                    if (@$_GET['funcao'] == 'editSubcateg') {
                        echo '
                            <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                                <img src="../../assets/icons/close.svg">
                            </button>
                        ';
                        $titulo_Subcateg = "Edição de sub-categoria!";
                        $btn_Subcateg = "Salvar edição";

                        $id_Subcateg_edit = $_GET['id'];

                        $query = $pdo->query("SELECT * FROM sub_categorias WHERE id = '$id_Subcateg_edit' LIMIT 1");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        if(@count($dados) > 0){
                            $nome_Subcateg_edit = $dados[0]['nome'];
                            $date_criacao_Subcateg_edit = $dados[0]['data_criacao'];
                            $date_atual_Subcateg_edit = $dados[0]['data_atual'];
                            $categ_Atrelada = $dados[0]['categ_Atrelada'];
                        }

                        $selectBox = "$categ_Atrelada";
                    }
                ?>

                <form id="form_Subcategorias" method="POST">
                    <div class="modal-body">
                        <h4><?php echo $titulo_Subcateg ?></h4>
                        
                        <div class="BlockBox">
                            <input type="text" value="<?php echo @$nome_Subcateg_edit ?>" name="nome_Subcateg" id="nome_Subcateg" maxlength="75" required>
                            <span>Nome:</span>
                            <p class="lengthInput nome_Subcateg_Input"></p>
                        </div>
                        
                        <!-- categ_Atreladas_Select -->
                        <div class="categ_Atreladas_Select">
                            <div id="category-select">
                                <input type="checkbox" id="options_btn_Subcat" onchange="OptionSelection('selected_val_Subcat', 'options_btn_Subcat', 'option_Subcat');">

                                <div id="select-button">
                                    <div id='selected_val_Subcat'> <?php echo $selectBox ?> </div>
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
                                        <li class='option_Subcat'>
                                            <input type='radio' name='categ_Atreladas' value='$nome_categ_atrelada' data-label='$nome_categ_atrelada'>
                                            <span class='label'>$nome_categ_atrelada</span>
                                        </li>
                                        ";
                                    }
                                ?>
                            </ul>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_Subcateg_edit" name="id_Subcateg_edit" value="<?php echo @$id_Subcateg_edit ?>" required>
                        <input type="hidden" id="date_criacao_Subcateg_edit" name="date_criacao_Subcateg_edit" value="<?php echo @$date_criacao_Subcateg_edit ?>" required>
                        <input type="hidden" id="date_atual_Subcateg_edit" name="date_atual_Subcateg_edit" value="<?php echo @$date_atual_Subcateg_edit ?>" required>
                        <input type="hidden" id="categ_atrelada_edit" name="categ_atrelada_edit" value="<?php echo @$categ_Atrelada ?>" required>


                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
                        <button class="SalvarBtnModal" type="submit"><?php echo $btn_Subcateg ?></button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_InsertEdit_Subcateg"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal listagem sub-categorias -->
<div class="modal fade" id="ModalListagemSubcateg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/icons/close.svg">
                </button>

                <div class="modal-body">
                
                    <h4>Tabela de sub-categorias</h4>

                    <table id="SubcategoriasTable">
                        <thead>
                            <tr>
                                <th>Nome da Subcategoria</th>
                                <th>Categorias atrelada</th>
                                <th>Data criação / Ultima alteração</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = $pdo->query("SELECT * FROM sub_categorias ORDER BY id DESC");
                                $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                                for ($i=0; $i < count($dados); $i++) { 
                                    
                                    $id_Subcategoria = $dados[$i]['id'];
                                    $nome_Subcategoria = $dados[$i]['nome'];
                                    $data_criacao_Subcategoria = $dados[$i]['data_criacao'];
                                    $data_atual_Subcategoria = $dados[$i]['data_atual'];
                                    $categ_Atrelada = $dados[$i]['categ_Atrelada'];

                                    if($data_atual_Subcategoria == "" || $data_atual_Subcategoria == null){
                                        $datas = $data_criacao_Subcategoria;
                                    }else{
                                        $datas = $data_criacao_Subcategoria. " - " .$data_atual_Subcategoria;
                                    }

                                    echo "
                                        <tr>
                                            <td class='nomeSubCateg'>
                                                <p>".$nome_Subcategoria."</p>
                                            </td>
                                            <td class='categ_atrelada'>
                                                <p>".$categ_Atrelada."</p>
                                            </td>
                                            <td class='datasSubcateg'>
                                                ".$datas."
                                            </td>
                                            <td class='acoesSubcateg'>
                                                <a href='index.php?pag=categoriasProduto&funcao=deleteSubcateg&id=".$id_Subcategoria."'><img src='../../assets/icons/delet.svg'></a>
                                                <a href='index.php?pag=categoriasProduto&funcao=editSubcateg&id=".$id_Subcategoria."'><img src='../../assets/icons/edit.svg'></a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </tbody>
                    </table>

                    <button class="produtos_Btn_CriacaoSubcateg" type="button" data-toggle="modal" data-target="#ModalSubcateg">
                        <p>Nova Sub-categoria</p>
                        <img src="../../assets/icons/add.svg" >
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete sub-categoria-->
<div class="modal fade" id="ModalDeletSubcateg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-block">
        <div class="modal-dialog">
            <div class="modal-content">

                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="history.back();">
                    <img src="../../assets/icons/close.svg">
                </button>

                <form id="form_delete_Subcategorias" method="POST">
                    <div class="modal-body">
                        <h4>Gostaria mesmo de excluir esta subcategoria?</h4>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_Subcateg_delete" name="id_Subcateg_delete" value="<?php echo @$_GET['id'] ?>" required>

                        <button class="CancelaBtnModal" type="button" data-dismiss="modal" onclick="history.back();">Cancelar</button>
                        <button class="ExcluirBtnModal" type="submit">Excluir</button>
                    </div>
                </form>

                <div class="msgErro" id="msgErro_delete_Subcateg"></div>
            </div>
        </div>
    </div>
</div>


<?php 
    if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novaCateg" || @$_GET["funcao"] == "editCateg") {
        echo "<script language='javascript'> $('#Modalcateg').modal('show');</script>";
    }
    else if(@$_GET["funcao"] == "deleteCateg"){
        echo "<script language='javascript'> $('#ModalDeletcateg').modal('show');</script>";
    }
    else if(@$_GET["funcao"] == "statusCateg"){
        echo "<script language='javascript'> $('#ModalStatuscateg').modal('show');</script>";
    }

    else if (@$_GET["funcao"] == "novaSubcateg" || @$_GET["funcao"] == "editSubcateg") {
        echo "<script language='javascript'> $('#ModalSubcateg').modal('show');</script>";
    }
    else if(@$_GET["funcao"] == "deleteSubcateg"){
        echo "<script language='javascript'> $('#ModalDeletSubcateg').modal('show');</script>";
    }
?>

<script>
    //CHAMADA DE FUNÇÃO PARA UPLOAD DE IMG BANCO DE DADOS
    function carregarImgWeb(){ carregarImagem('img_categ_Input', 'target_imgCateg', "../../assets/icons/placeholder.svg", 'img_categ_modal'); }

    //UPLOAD DAS INFOS NO BANCO DE DADOS
    $("#form_categorias").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "Produtos/categoria/insert_Edit.php",
            type: 'POST',
            data: formData,
            success: function (msg) {
                $('#msgErro_InsertEdit_Categ').removeClass('text-danger');
                $('#msgErro_InsertEdit_Categ').addClass('text-warning');
                $('#msgErro_InsertEdit_Categ').text('carregando...');
                if (msg.trim() === "Categoria adicionada com Sucesso!!" || msg.trim() === "Categoria Atualizada com Sucesso!!" ) {
                    $('#msgErro_InsertEdit_Categ').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Categ').removeClass('text-danger');
                    $('#msgErro_InsertEdit_Categ').addClass('text-success');
                    $('#msgErro_InsertEdit_Categ').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 1500);
                }
                else {
                    $('#msgErro_InsertEdit_Categ').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Categ').addClass('text-danger');
                    $('#msgErro_InsertEdit_Categ').text(msg);
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

    $('#form_delete_categorias').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/categoria/delete.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Excluído com Sucesso!!") {
                    $('#msgErro_delete_Categ').removeClass('text-warning');
                    $('#msgErro_delete_Categ').removeClass('text-danger');
                    $('#msgErro_delete_Categ').addClass('text-success');
                    $('#msgErro_delete_Categ').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 1500);
                }
                else{
                    $('#msgErro_delete_Categ').removeClass('text-success');
                    $('#msgErro_delete_Categ').removeClass('text-warning');
                    $('#msgErro_delete_Categ').addClass('text-danger');
                    $('#msgErro_delete_Categ').text(msg)
                }
            }
        })
    });

    $('#form_status_categorias').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/categoria/update_status.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Status atualizado com sucesso!!") {
                    $('#msgErro_status_Categ').removeClass('text-warning');
                    $('#msgErro_status_Categ').removeClass('text-danger');
                    $('#msgErro_status_Categ').addClass('text-success');
                    $('#msgErro_status_Categ').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 500);
                }
                else{
                    $('#msgErro_status_Categ').removeClass('text-success');
                    $('#msgErro_status_Categ').removeClass('text-warning');
                    $('#msgErro_status_Categ').addClass('text-danger');
                    $('#msgErro_status_Categ').text(msg)
                }
            }
        })
    });

    $('#form_Subcategorias').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/subCategoria/insert_Edit.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Subcategoria adicionada com Sucesso!!" || msg.trim() === "Subcategoria Atualizada com Sucesso!!") {
                    $('#msgErro_InsertEdit_Subcateg').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Subcateg').removeClass('text-danger');
                    $('#msgErro_InsertEdit_Subcateg').addClass('text-success');
                    $('#msgErro_InsertEdit_Subcateg').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 500);
                }
                else{
                    $('#msgErro_InsertEdit_Subcateg').removeClass('text-success');
                    $('#msgErro_InsertEdit_Subcateg').removeClass('text-warning');
                    $('#msgErro_InsertEdit_Subcateg').addClass('text-danger');
                    $('#msgErro_InsertEdit_Subcateg').text(msg)
                }
            }
        })
    });

    $('#form_delete_Subcategorias').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Produtos/subCategoria/delete.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (msg) {
                if (msg.trim() === "Excluído com Sucesso!!") {
                    $('#msgErro_delete_Subcateg').removeClass('text-warning');
                    $('#msgErro_delete_Subcateg').removeClass('text-danger');
                    $('#msgErro_delete_Subcateg').addClass('text-success');
                    $('#msgErro_delete_Subcateg').text(msg);
                    setTimeout(() => { window.location='./index.php?pag=categoriasProduto'; }, 1500);
                }
                else{
                    $('#msgErro_delete_Subcateg').removeClass('text-success');
                    $('#msgErro_delete_Subcateg').removeClass('text-warning');
                    $('#msgErro_delete_Subcateg').addClass('text-danger');
                    $('#msgErro_delete_Subcateg').text(msg)
                }
            }
        })
    });

    //VERIFICACAO DE TAMANHOS DE INPUT
    setInterval(
        function () {
            verificaTamanhoInput('nome_categ', 'nome_categ_Input', 150);
            verificaTamanhoInput('nome_Subcateg', 'nome_Subcateg_Input', 75);
    }, 50);
</script>