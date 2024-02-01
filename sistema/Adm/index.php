<?php
session_start();
require_once("../configs/conexao.php");

$emailUserSessao = @$_SESSION['email_user'];
    
$query = $pdo->query("SELECT * FROM usuarios WHERE email = '$emailUserSessao' LIMIT 1");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){
    $idAdm = $dados[0]['id'];
    $nomeCompAdm = $dados[0]['nome_Completo'];
    $emailAdm = $dados[0]['email'];
    $telefoneContAdm = $dados[0]['telefone'];
    $senhaAdm = $dados[0]['senha'];
    $dataRegistroAdm = $dados[0]['data_Registro'];
    
    setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
    $date = strftime(" %B de %Y", strtotime($dataRegistroAdm));
} 
else {
    $_SESSION['msg_perfilInvalido'] = "<div class='msgPerfilInvalido' style='left: 1.5vw !important; background:#CC101D;'>Usuario não encontrado!</div>";
    header("Location: ../../links.php");
}

?> 


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universo Farol | Administrativo</title>
    <link rel="icon" href="../../assets/icon_Logo.png" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>


    <!-- Main files -->
    <link rel="stylesheet" href="../../css/style_Links.css">

    <script defer src="js/script.js"></script>
    <script src="../../js/svg-inject.min.js"></script>
</head>

<body class="TelaAdm">
    <img class="EstrelasBack" src="../../assets/estrelas.png" alt="Fundo estrelado">

    <header>
        <a href="../../links.php" class="InfosImg">
            <img src="../../assets/horizontal_Logo.png">
        </a>
        <button type="button" data-toggle="modal" data-target="#ModalEditPerfil">
            <img src="../../assets/icones/configs.svg" onload="SVGInject(this)">
        </button>
        <button type="button" data-toggle="modal" data-target="#ModalLogout">
            <img src="../../assets/icones/logout.svg" onload="SVGInject(this)">
        </button>
    </header>

    <main>
        <div class="nav nav-pills">
            <a class="nav-item activeStar active" data-toggle="pill" id="linksTab" href="#links">Links</a>
            <a class="nav-item" data-toggle="pill" id="formulariosTab" href="#formularios">Formularios</a>
            <a class="nav-item" data-toggle="pill" id="bancoHorasTab" href="#bancoHoras">Banco de Horas</a>
            <a class="nav-item" data-toggle="pill" id="lpGeneratorTab" href="#lpGenerator">Gerador de Lp's</a>
            <a class="backup" href="./Main_Configs/backup.php">Backup</a>
            <span class="star_indicator"><img src="../../assets/icones/Brilho.svg" onload="SVGInject(this)"></span>
        </div>

        <div id="TabsAdm" class="tab-content TabsAdm">
            <div class="tab-pane fade show active" id="links">
                <div class="ActionsList">
                    <button type="button" data-toggle="dropdown" aria-expanded="false"></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href='index.php?funcao=novoLink'>Novo link</a>
                        <a class="dropdown-item" href="index.php?funcao=novaCategoria">Nova Categoria</a>
                        <a class="dropdown-item" href="index.php?funcao=ListarCategorias">Editar ou Excluir Categoria</a>
                        <a id="ListagemLinksbtn" class="dropdown-item" onclick="ToggleListagemLinks()">Ver links desativados</a>
                    </div>
                </div>
                <div class="linksBlock">
                    <div class="linksAtivos">
                        <h2>Links Ativos</h2>
                        <div class="links">
                            <?php
                                $query = $pdo->query("SELECT * FROM links where ativo = 'sim' ORDER BY id ASC");
                                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                for ($i=0; $i < count($dados); $i++) {
                                    $id_Banner = $dados[$i]['id'];
                                    $imgWeb = $dados[$i]['img_Web'];
                                    $imgMobile = $dados[$i]['img_Mobile'];
                                    $nome_Banner = $dados[$i]['nome'];
                                    $categoria_Banner = $dados[$i]['categoria'];
                                    $link_Banner = $dados[$i]['link'];
                                    if($imgWeb == "Default_Banner_Web.webp" && $imgMobile == "Default_Banner_Mobile.webp"){
                                        $img_Banner = "<img src='../../assets/Banner_Links/".$imgWeb."'>"; 
                                    }
                                    else if($imgWeb != "Default_Banner_Web.webp" && $imgMobile == "Default_Banner_Mobile.webp"){
                                        $img_Banner = "<img src='../../assets/Banner_Links/Web/".$imgWeb."'>"; 
                                    }
                                    else if($imgWeb == "Default_Banner_Web.webp" && $imgMobile != "Default_Banner_Mobile.webp"){
                                        $img_Banner = "<img src='../../assets/Banner_Links/Mobile/".$imgMobile."'>"; 
                                    }
                                    else{
                                        $img_Banner = "<img src='../../assets/Banner_Links/Web/".$imgWeb."'>"; 
                                    }
                                    echo "
                                        <div class='BannerLink'>
                                            <h3> $nome_Banner | $categoria_Banner </h3>
                                            
                                            <a target='_blank' class='banner' href='https://$link_Banner'>
                                                $img_Banner
                                            </a>
                                            <div class='linkBtnAction'>
                                                <a id='EditLink' href='index.php?funcao=editarLink&id=$id_Banner'>Editar</a>
                                                <a id='DeletLink' href='index.php?funcao=excluirLink&id=$id_Banner'>Excluir</a>
                                            </div>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>

                    <div class="LinkDesativados hide">
                        <h2>Links Desativados</h2>
                        <div class="links">
                            <?php
                                $query = $pdo->query("SELECT * FROM links where ativo = 'nao' ORDER BY id ASC");
                                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                for ($i=0; $i < count($dados); $i++) {
                                    $id_Banner = $dados[$i]['id'];
                                    $imgWeb = $dados[$i]['img_Web'];
                                    $imgMobile = $dados[$i]['img_Mobile'];
                                    $nome_Banner = $dados[$i]['nome'];
                                    $categoria_Banner = $dados[$i]['categoria'];
                                    $link_Banner = $dados[$i]['link'];

                                    if($imgWeb == "Default_Banner_Web.webp" && $imgMobile == "Default_Banner_Mobile.webp"){
                                        $img_Banner = "<img src='../../assets/Banner_Links/".$imgWeb."'>"; 
                                    }
                                    else if($imgWeb != "Default_Banner_Web.webp" && $imgMobile == "Default_Banner_Mobile.webp"){
                                        $img_Banner = "<img src='../../assets/Banner_Links/Web/".$imgWeb."'>"; 
                                    }
                                    else if($imgWeb == "Default_Banner_Web.webp" && $imgMobile != "Default_Banner_Mobile.webp"){
                                        $img_Banner = "<img src='../../assets/Banner_Links/Mobile/".$imgMobile."'>"; 
                                    }
                                    else{
                                        $img_Banner = "<img src='../../assets/Banner_Links/Web/".$imgWeb."'>"; 
                                    }
                                    
                                    echo "
                                        <div class='BannerLink'>
                                            <h3> $nome_Banner | $categoria_Banner </h3>
                                            
                                            <a target='_blank' class='banner' href='https://$link_Banner'>
                                                $img_Banner
                                            </a>
                                            <div class='linkBtnAction'>
                                                <a id='EditLink' href='index.php?funcao=editarLink&id=$id_Banner'>Editar</a>
                                                <a id='DeletLink' href='index.php?funcao=excluirLink&id=$id_Banner'>Excluir</a>
                                            </div>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="formularios">
                TESTE FORMULARIO
            </div>

            <div class="tab-pane fade" id="bancoHoras">
                TESTE BANCO DE HORAS
            </div>

            <div class="tab-pane fade" id="lpGenerator">
                TESTE GERADOR DE LP'S
            </div>
        </div>

    </main>

    <!-- Modal Logout-->
    <div class="modal fade" id="ModalLogout" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="resetIndex()"></button>
                <div class="modal-body">
                    <h5>Já vai embora?</h5>
                    <h6>Tem certeza que gostaria de sair da sa conta?</h6>
                </div>
                <div class="modal-footer">
                    <button class="CancelaBtnModal" type="button" data-dismiss="modal">Cancelar</button>
                    <a href="../configs/logout.php" class="LogoutBtnModal" type="button">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar perfil-->
    <div class="modal fade" id="ModalEditPerfil" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="resetIndex()"></button>
                <div class="modal-body">
                    <div id="MenuAdm" class="nav nav-pills MenuAdm">
                        <a class="active" data-toggle="pill" id="InicioTab" href="#ContaDados">Dados da conta</a>
                        <a data-toggle="pill" id="GraficosTab" href="#EmailTroca">Troca de email</a>
                        <a data-toggle="pill" id="AstronautasTab" href="#SenhaTroca">Troca de senha</a>
                    </div>
                    <div id="TabsAdm" class="tab-content TabsAdm">
                        <div class="tab-pane fade show active" id="ContaDados">
                            <form id="formEditUser" class="editDados" method="POST">
                                <h4>Alterar informações de conta:</h4>
                                <div class="BlockBox">
                                    <input type="text" name="nomeCompEdit" id="nomeCompEdit" maxlength="75" value="<?php echo $nomeCompAdm ?>" required>
                                    <span>Nome completo:</span>
                                    <p class="lengthInput NomeCompEditInput"></p>
                                </div>
                                <div class="BlockBox">
                                    <input type="text" name="telefoneContatoEdit" id="telefoneContatoEdit" value="<?php echo $telefoneContAdm ?>" required>
                                    <span>Telefone de contato:</span>
                                </div>
                                <input value="<?php echo @$_SESSION['id_user'] ?>" class="hide" type="hidden" name="idUser" id="idUser">
                                <button class="SalvarBtnModal" id="SalvarEditUser" type="submit">Salvar</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="EmailTroca">
                            <form id="formEditEmailUser" class="emailEdit" method="POST">
                                <h4>Alterar Email:</h4>

                                <div class="BlockBox">
                                    <input type="text" name="antigoEmail" id="antigoEmail" maxlength="50" required>
                                    <span>E-mail Antigo:</span>
                                    <p class="lengthInput emailAntigoEditInput"></p>
                                </div>
                                <div class="BlockBox">
                                    <input type="text" name="novoEmail" id="novoEmail" maxlength="50" required>
                                    <span>Novo e-mail:</span>
                                    <p class="lengthInput novoEmailEditInput"></p>
                                </div>
                                <div class="BlockBox">
                                    <input type="text" name="confirmaNovoEmail" id="confirmaNovoEmail" maxlength="50" required>
                                    <span>Confirma novo e-mail:</span>
                                    <p class="lengthInput ConfirmaNovoEmailEditInput"></p>
                                </div>
                                
                                <input value="<?php echo @$_SESSION['id_user'] ?>" class="hide" type="hidden" name="idUserEmail" id="idUserEmail">
                                <input value="<?php echo $emailAdm ?>" class="hide" type="hidden" name="emailUserSemAlteracoes" id="emailUserSemAlteracoes">

                                <button class="SalvarBtnModal" id="SalvarEditEmailUser" type="submit">Salvar</button>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="SenhaTroca">
                            <form id="formEditSenhaUser" class="senhaEdit" method="POST">
                                <h4>Alterar Senha:</h4>
                                <div class="BlockBox senhaInput">
                                    <input type="password" name="antigaSenha" id="antigaSenha" maxlength="25" required>
                                    <span>Senha antiga:</span>
                                    <i id="password_toggle" onclick="setupPasswordToggle('antigaSenha', 'password_toggle')" class="senhaIcon fa fa-eye-slash"></i>
                                    <p class="lengthInput SenhaAntigaEditInput"></p>
                                </div>
                                <div class="BlockBox senhaInput">
                                    <input type="password" name="novaSenha" id="novaSenha" maxlength="25" required>
                                    <span>Nova senha:</span>
                                    <i id="password_toggle_new" onclick="setupPasswordToggle('novaSenha', 'password_toggle_new')" class="senhaIcon fa fa-eye-slash"></i>
                                    <p class="lengthInput NovaSenhaEditInput"></p>
                                </div>
                                <div class="BlockBox senhaInput">
                                    <input type="password" name="confirmaNovaSenha" id="confirmaNovaSenha" maxlength="25" required>
                                    <span>Confirma nova senha:</span>
                                    <i id="password_toggle_confirm" onclick="setupPasswordToggle('confirmaNovaSenha', 'password_toggle_confirm')" class="senhaIcon fa fa-eye-slash"></i>
                                    <p class="lengthInput ConfirmaNovaSenhaEditInput"></p>
                                </div>

                                <input value="<?php echo @$_SESSION['id_user'] ?>" class="hide" type="hidden" name="idUserSenha" id="idUserSenha">
                                <input value="<?php echo $senhaAdm ?>" class="hide" type="hidden" name="senhaUserSemAlteracoes" id="senhaUserSemAlteracoes">

                                <button class="SalvarBtnModal" id="SalvarEditSenhaUser" type="submit">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="msgErro" id="msgErro_EditUser"></div>
            </div>
        </div>
    </div>


<!-- LINKS -->
    <!-- Modal de Novos & Edição-->
    <div class="modal fade" id="ModalLinks" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="resetIndex()"></button>
                <div class="modal-body">
                    <?php 
                        if (@$_GET['funcao'] == 'editarLink') {
                            $titulo_link = "Edição de banner de link";
                            $btn_link = "Atualizar";

                            $id_link = $_GET['id'];

                            $query = $pdo->query("SELECT * FROM links WHERE id = '$id_link' LIMIT 1");
                            $dados = $query->fetchAll(PDO::FETCH_ASSOC);

                            if(@count($dados) > 0){
                                $img_Web = $dados[0]['img_Web'];
                                $img_Mobile = $dados[0]['img_Mobile'];
                                $nome_link = $dados[0]['nome'];
                                $categoria_link = $dados[0]['categoria'];
                                $link = $dados[0]['link'];
                                $ativo = $dados[0]['ativo'];
                            }

                        } else { $titulo_link = "Novo Link"; $btn_link = "Salvar";}

                    ?>
                    <form id="formLinks" method="POST">
                        <h4><?php echo $titulo_link ?></h4>
                        <span>*Tamanho de banner recomendado: 1440 x 810</span>
                        <div class="Img_Web_Block">
                            <input type="file" value="<?php echo @$img_Web ?>" id="Banner_Web" name="Banner_Web" onChange="carregarImgWeb();">
                            <?php
                                if(@$img_Web == "Default_Banner_Web.webp" || @$img_Web == ""){
                                    echo "<img class='Banner_Img_Web' id='target_imgWeb' src='../../assets/Banner_Links/Default_Banner_Web.webp'>";
                                }else{
                                    echo "<img class='Banner_Img_Web imgSelected' id='target_imgWeb' src='../../assets/Banner_Links/Web/$img_Web'>";
                                }
                            ?>
                            <img class="editPen" onclick="Banner_Web()" src="../../assets/icones/caneta.svg" onload="SVGInject(this)">
                        </div>
                        <div class="Img_Mobile_Block">
                            <input type="file" value="<?php echo @$img_Mobile ?>" id="Banner_Mobile" name="Banner_Mobile" onChange="carregarImgMobile();">
                            <?php
                                if(@$img_Mobile == "Default_Banner_Mobile.webp" || @$img_Mobile == ""){
                                    echo "<img class='Banner_Img_Mobile' id='target_imgMobile' src='../../assets/Banner_Links/Default_Banner_Mobile.webp'>";
                                }else{
                                    echo "<img class='Banner_Img_Mobile imgSelected' id='target_imgMobile' src='../../assets/Banner_Links/Mobile/$img_Mobile'>";
                                }
                            ?>
                            <img class="editPen" onclick="Banner_Mobile()" src="../../assets/icones/caneta.svg" onload="SVGInject(this)">
                        </div>
                        <div class="BlockBox categoriasSelect">
                            <span>Selecione uma categoria:</span>
                            <select name="categorias" id="categorias" required>
                                <?php 
                                    if (@$_GET['funcao'] == 'editarLink') {
                                        echo "
                                            <option value='$categoria_link'> $categoria_link </option>
                                            <option value='categoria_null'>Categorias:</option>
                                        ";
                                    }
                                    else{ echo '<option value="categoria_null">Categorias:</option>'; }

                                    $query2 = $pdo->query("SELECT * FROM categoria_links ORDER BY id ASC");
                                    $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                    for ($j=0; $j < count($dados2); $j++) {
                                        $nome_Categorias_link = $dados2[$j]['nome'];
                                        echo "<option value='$nome_Categorias_link'> $nome_Categorias_link </option>";
                                    }
                                    
                                ?>
                            </select>
                        </div>
                        <div class="BlockBox">
                            <input type="text" value="<?php echo @$nome_link ?>" name="nomeLink" id="nomeLink" maxlength="50" required>
                            <span>Nome do Link:</span>
                            <p class="lengthInput nomeLinkInput"></p>
                        </div>
                        <div class="BlockBox">
                            <input type="text" value="<?php echo @$link ?>" name="link" id="link" maxlength="250" required>
                            <span>Link:</span>
                            <p class="lengthInput linkInput"></p>
                        </div>
                        <div class="checkBoxLinkAtivo">
                            <label for="linkAtivo">É um link Ativo?</label>
                            <?php
                                if(@$ativo != ""){
                                    if(@$ativo == "sim"){
                                        echo "<input type='checkbox' id='linkAtivo' name='linkAtivo' checked>";
                                    }
                                    else{
                                        echo "<input type='checkbox' id='linkAtivo' name='linkAtivo'>";
                                    }
                                }else{
                                    echo "<input type='checkbox' id='linkAtivo' name='linkAtivo' checked>";
                                }
                            ?>
                        </div>

                        <input type="hidden" id="idEditLink" name="idEditLink" value="<?php echo @$_GET['id'] ?>" required>
                        <button class="SalvarBtnModal" id="SalvarLink" type="submit"><?php echo $btn_link ?></button>
                    </form> 
                </div>
                <div class="msgErro" id="msgErro_Links"></div>
            </div>
        </div>
    </div>

    <!-- Modal Deletar-->
    <div class="modal fade" id="ModalDeletLink" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="resetIndex()"></button>
                <div class="modal-body">
                    <form id="formDeletLink" method="POST">
                        <h4>Excluir Link</h4>

                        <h5>Tem certeza que gostaria de excluir esse link?</h5>
                        <input type="hidden" id="idDeletLink" name="idDeletLink" value="<?php echo @$_GET['id'] ?>" required>
                        <button class="DeletBtnModal" id="DeletLinkbtn" type="button">Excluir</button>
                    </form>
                    <button class="CancelarBtnModal" id="CancelarDeletLink" type="button">Cancelar</button>
                </div>
                <div class="msgErro" id="msgErro_DeletLink"></div>
            </div>
        </div>
    </div>


<!-- CATEGORIAS -->
    <!-- Modal de Listagem-->
    <div class="modal fade" id="ModalListagemCategorias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="resetIndex()"></button>
                <div class="modal-body">
                    <?php
                        $query = $pdo->query("SELECT * FROM categoria_links ORDER BY id ASC");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        for ($i=0; $i < count($dados); $i++) {
                            $id_Categorias = $dados[$i]['id'];
                            $nome_Categorias = $dados[$i]['nome'];
                            echo "
                                <div class='Listagem_categoria_Links'>
                                    <p> $nome_Categorias </p>
                    
                                    <a id='EditCateg' href='index.php?funcao=editarCategoria&id=$id_Categorias'>Editar</a>
                                    <a id='DeletCateg' href='index.php?funcao=excluirCategoria&id=$id_Categorias'>Excluir</a>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>    

    <!-- Modal de Novas & Edição-->
    <div class="modal fade" id="ModalCategoria" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" data-dismiss="modal" aria-label="Close" onclick="resetIndex()"></button>
                <div class="modal-body">
                    <?php 
                        if (@$_GET['funcao'] === 'editarCategoria') {
                            $titulo_categoria = "Edição de categoria";
                            $btn = "Atualizar";

                            $id_Categoria = $_GET['id'];

                            $query = $pdo->query("SELECT * FROM categoria_links WHERE id = '$id_Categoria' LIMIT 1");
                            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                            if(@count($dados) > 0){
                                $nome_Categoria = $dados[0]['nome'];
                            }

                        } else { $titulo_categoria = "Nova Categoria"; $btn = "Salvar";}

                    ?>
                    <form id="formCategorias" method="POST">
                        <h4><?php echo @$titulo_categoria ?></h4>
                        <div class="BlockBox">
                            <input type="text" name="nomeCateg" id="nomeCateg" maxlength="75" value="<?php echo @$nome_Categoria ?>" required>
                            <span>Categoria:</span>
                            <p class="lengthInput categoriaInput">15/20</p>
                        </div>
                        <input type="hidden" id="idEditCateg" name="idEditCateg" value="<?php echo @$_GET['id'] ?>" required>
                        <button class="SalvarBtnModal" id="SalvarCategoriaLinks" type="submit"><?php echo $btn ?></button>
                    </form>
                </div>
                <div class="msgErro" id="msgErro_Categoria"></div>
            </div>
        </div>
    </div>

    <!-- Modal Deletar-->
    <div class="modal fade" id="ModalDeletCategoria" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="CloseBtn" onclick="resetIndex()" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <form id="formDeletCategoria" method="POST">
                        <h4>Exclusão de categoria</h4>
                        <h5>Tem certeza que gostaria de excluir essa categoria?</h5>
                        
                        <input type="hidden" id="idDeletCateg" name="idDeletCateg" value="<?php echo @$_GET['id'] ?>" required>
                        <button class="DeletBtnModal" id="DeletCategoria" type="button" style="margin-left: 25vw;">Excluir</button>
                    </form>
                    <button class="CancelaBtnModal" id="CancelarDeletCateg" type="button" onclick="VoltarPage()">Cancelar</button>
                </div>
                <div class="msgErro" id="msgErro_DeletCateg"></div>
            </div>
        </div>
    </div>
<?php 

// **LINKS** //
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novoLink" || @$_GET["funcao"] == "editarLink") {
    echo "<script language='javascript'> $('#ModalLinks').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluirLink") {
    echo "<script language='javascript'> $('#ModalDeletLink').modal('show');</script>";
}

// **CATEGORIAS** //
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "ListarCategorias") {
    echo "<script language='javascript'> $('#ModalListagemCategorias').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novaCategoria" || @$_GET["funcao"] == "editarCategoria") {
    echo "<script language='javascript'> $('#ModalCategoria').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluirCategoria") {
    echo "<script language='javascript'> $('#ModalDeletCategoria').modal('show');</script>";
}
?>

</body>
</html>