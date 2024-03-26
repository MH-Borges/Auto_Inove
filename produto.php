<?php 
require_once("sistema/configs/conexao.php"); 

$nome_get = @$_GET['nome'];
$nome_clean = preg_replace('/_/', ' ', $nome_get);
$codigo_get = @$_COOKIE["Cookie_Codigo"];

$query = $pdo->query("SELECT * FROM produtos where nome = '$nome_clean'");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);
@$estoque = $dados[0]['estoque'];
@$status = $dados[0]['status_prod'];

if($estoque === '0'){
    $res = $pdo->prepare("UPDATE produtos SET status_prod = :status_prod WHERE nome = :nome");
    $res->bindValue(":status_prod", 'sem_estoque');
    $res->bindValue(":nome", $nome_clean);
    $res->execute();
    $status = 'sem_estoque';
}

if($status === 'ativo'){
    $Visualizacoes = $dados[0]['Visualizacoes'];
    $Visualizacoes++;
    //atualiza Visualizações da página
    $res = $pdo->prepare("UPDATE produtos SET Visualizacoes = :Visualizacoes WHERE nome = :nome");
    $res->bindValue(":Visualizacoes", $Visualizacoes);
    $res->bindValue(":nome", $nome_clean);
    $res->execute();

    $id_prod = $dados[0]['id'];
    $img = $dados[0]['img'];
    $nome = $dados[0]['nome'];
    $valor = $dados[0]['valor'];
    $descricao = $dados[0]['descricao'];
    $categoria = $dados[0]['categoria'];
    $sub_categoria = $dados[0]['sub_categoria'];
    $codigo_prod = $dados[0]['codigo'];
    $marca = $dados[0]['marca'];
    $litros = $dados[0]['litros'];
    
    $Item_Relac_1 = $dados[0]['Item_Relac_1'];
    $Item_Relac_2 = $dados[0]['Item_Relac_2'];
    $Item_Relac_3 = $dados[0]['Item_Relac_3'];
    $Item_Relac_4 = $dados[0]['Item_Relac_4'];

    if($sub_categoria !== NULL && $sub_categoria !== " "){
        $nome_novo_Categ = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", strtr(utf8_decode(trim($categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
        $Categ_url = preg_replace('/[ -]+/' , '_' , $nome_novo_Categ);

        $nome_novo_subCateg = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", strtr(utf8_decode(trim($sub_categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
        $subCateg_url = preg_replace('/[ -]+/' , '_' , $nome_novo_subCateg);

        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="./produtos_'.$Categ_url.'">'.$categoria.'</a></li>
                        <li class="breadcrumb-item"><a href="./produtos_'.$subCateg_url.'">'.$sub_categoria.'</a></li>
                        <li class="breadcrumb-item active" aria-current="page">'.$nome.'</li>';
    }
    else{
        $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", strtr(utf8_decode(trim($categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
        $Categ_url = preg_replace('/[ -]+/' , '_' , $nome_novo);

        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="./produtos_'.$Categ_url.'">'.$categoria.'</a></li>
                        <li class="breadcrumb-item active" aria-current="page">'.$nome.'</li>';
    }

    if($img == "placeholder.jpg" || $img == ""){
        $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
    }else{
        $img_prod = "<img src='assets/produtos/$img'>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Inove | <?php echo $nome_clean ?></title>
    <link rel="icon" href="assets/icon.svg" />
    <link rel="canonical" href="" />

    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    
    <meta property="og:locale" content="pt_BR">
    <meta name="og:title" property="og:title" content="">
    <meta name="og:type" property="og:type" content="website">
    <meta name="og:image" property="og:image" content="assets/Ilust_Farol.jpg">

    <!-- SVG Inject -->
    <script src="js/svg-inject.min.js"></script>

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- Cookies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.5/js.cookie.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    
    <!-- Main files -->
    <link rel="stylesheet" href="css/Front/style.css">
    <script defer src="js/script.js"></script>
</head>

<body>
    <header>
        <a id="LogoMenu" href="https://www.autoinove.com.br">
            <img src="assets/logo_Horizontal.svg" onload="SVGInject(this)">
        </a>

        <div class="searchBar_Block">
            <div class="Select_Produtos">
                <div id="category-select">
                    <input type="checkbox" id="options_btn_Codigos" onchange="OptionSelection('selected_val_Codigos', 'options_btn_Codigos', 'option_Codigos');">
    
                    <div id="select-button">
                        <div id='selected_val_Codigos'>código</div>
                        <img src="assets/icons/seta.svg" onload="SVGInject(this)">
                    </div>
                </div>
                
                <ul id="options">
                    <?php 
                        $query = $pdo->query("SELECT * FROM codigos ORDER BY id DESC");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($j=0; $j < count($dados); $j++) {
                            $nome_codigos = $dados[$j]['nome'];
                            $query2 = $pdo->query("SELECT * FROM produtos where codigo = '$nome_codigos'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            for ($i=0; $i < count($dados2); $i++) {
                                $statusProd = $dados2[$i]['status_prod'];
                                $categ = $dados2[$i]['categoria'];
                                $query3 = $pdo->query("SELECT * FROM categorias where nome = '$categ'");
                                $dados3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                                $statusCateg = $dados3[0]['status_categ'];
                                if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                                    $codigo = $dados2[$i]['codigo'];
                                    if($codigo === $nome_codigos){
                                        $k++;
                                    }
                                }
                            }

                            if($k != 0){
                                echo "
                                    <li class='option_Codigos' onclick='codigoRedirect(`".$nome_codigos."`)'>
                                        <input type='radio' name='codigo_Produto' value='$nome_codigos' data-label='$nome_codigos'>
                                        <span class='label'>$nome_codigos</span>
                                    </li>
                                ";
                            }
                            $k=0;
                        }
                    ?>
                </ul>
            </div>
            <div class="searchBar">
                <input type="text" id="filter" placeholder="Faça sua busca">
                <div class="search"></div>
                <div class="Search_resultBox hide"></div>
            </div>
        </div>

        <div class="cart">
            <span class='CartNotf hide'></span>
            <button type='button' data-toggle='dropdown' aria-expanded='false'>
                <img  src="assets/icons/cart.svg" onload="SVGInject(this)">
            </button>
            <div class='dropdown-menu dropdown-menu-right dropdownCarrinho'>
                <p>Carrinho Vazio</p>
                <a class='btn-carrinho hide' href="./carrinho">Ver pagina de carrinho</a>
            </div>
        </div>

        <img class="menu" src="assets/icons/menu.svg" onload="SVGInject(this)" onclick="menuToggle()">
        <div class="side_menu hide">
            <img class="close_menu" src="assets/icons/close.svg" onclick="menuToggle()">
            <a href="./produtos ">Produtos</a>
            <a href="./categorias ">Categorias</a>
            <a target="_blank" href="https://wa.me/554198492024">Contato</a>
            <a href="./carrinho ">Meu carrinho</a>
        </div>
    </header>

    <?php if($status === 'ativo'){ ?>
        <main class="Produto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php echo $breadcrumbs ?>
                </ol>
            </nav>
            <?php 
                if($estoque < 10){
                    echo"<span class='estoque'> Poucas unidades no estoque!!</span>";
                }  
            ?>
            <div class='main_Block'>
                <div class='infos'>
                    <h1 class='nomeProd'><?php echo $nome ?></h1>
                    <h5>Código: <span class='codigo_Show'><?php echo $codigo_prod ?></span></h5>
                    <h5>Marca: <span><?php echo $marca ?></span></h5>
                    <?php if($litros !== '' && $litros !== NULL){
                        echo '<h5>Litros: <span>'.$litros.' L</span></h5>';
                    }?>
                    <div class='valor'>
                        <span>R$</span><h3><?php echo $valor?><h3>
                    </div>

                    <div class='Acoes'>
                        <div class='AddRemove'>
                            <button class='remove' type='button' onclick='quantidade("subtrai")'></button>
                            <span class='quant'>1</span>
                            <button class='add' type='button' onclick='quantidade("soma")'></button>
                            <button class='addCarrinho' type='button' onclick='addCarrinho(<?php echo "`$id_prod`, `$img`, `$nome`, `$codigo`, true"; ?>)'>Adicionar ao carrinho</button>
                        </div>
                        <a target='_blank' class='linkcompra' onclick='linkCompra()'>Comprar agora</a>
                    </div>

                </div>
                <div class='img'><?php echo $img_prod ?></div>
            </div>
            <div class='descrition_Block'>
                <h2>Descrição</h2>
                <p><?php echo $descricao ?></p>
            </div>
            <div class='ProdsRelacionados_Block'>
                <h2>Produtos relacionados</h2>
                <?php
                    if($Item_Relac_1 !== '' && $Item_Relac_2 !== '' && $Item_Relac_3 !== '' && $Item_Relac_4 !== ''){
                        //prod 01
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_1'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 02
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_2'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 03
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_3'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_4'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }
                    }
                    if($Item_Relac_1 !== '' && $Item_Relac_2 !== '' && $Item_Relac_3 !== '' && $Item_Relac_4 === ''){
                        //prod 01
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_1'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 02
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_2'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 03
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_3'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo_prod'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $valor = $dados[0]['valor'];
                            $nome = $dados[0]['nome'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }
                    }
                    if($Item_Relac_1 !== '' && $Item_Relac_2 !== '' && $Item_Relac_3 === '' && $Item_Relac_4 === ''){
                        //prod 01
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_1'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 02
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_2'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 03 & 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo_prod'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($i=0; $i < count($dados); $i++) { 
                            $statusProd = $dados[$i]['status_prod'];
                            $Categ = $dados[$i]['categoria'];
                            $nome = $dados[$i]['nome'];
                            $nome_lower = strtolower($nome);

                            $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $statusCateg = $dados2[0]['status_categ'];

                            if($statusProd === 'ativo' && $statusCateg === 'ativo' && $k < 2 && $nome !== $Item_Relac_1 && $nome !== $Item_Relac_2 && $nome_lower !== $nome_clean){
                                $k++;
                                $id = $dados[$i]['id'];
                                $codigo = $dados[$i]['codigo'];
                                $img = $dados[$i]['img'];
                                $valor = $dados[$i]['valor'];
            
                                if($img == "placeholder.jpg" || $img == ""){
                                    $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                                }else{
                                    $img_prod = "<img src='assets/produtos/$img'>";
                                }
            
                                $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                    strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                    "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
            
                                $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
            
                                echo "<div class='produtos_atrelados'>
                                        <span class='code'>".$codigo."</span>
                                        <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                        ".$img_prod."
                                        <h4>".$nome."</h4>
                                        <p><span>R$</span>".$valor."</p>
                                        <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                    </div>";
                            }
                        }
                    }
                    if($Item_Relac_1 !== '' && $Item_Relac_2 === '' && $Item_Relac_3 === '' && $Item_Relac_4 === ''){
                        //prod 01
                        $query = $pdo->query("SELECT * FROM produtos WHERE nome = '$Item_Relac_1'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $statusProd = $dados[0]['status_prod'];
                        $Categ = $dados[0]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];
                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            $id = $dados[0]['id'];
                            $codigo = $dados[0]['codigo'];
                            $img = $dados[0]['img'];
                            $nome = $dados[0]['nome'];
                            $valor = $dados[0]['valor'];
        
                            if($img == "placeholder.jpg" || $img == ""){
                                $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                            }else{
                                $img_prod = "<img src='assets/produtos/$img'>";
                            }
        
                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
        
                            $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
        
                            echo "<div class='produtos_atrelados'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 02 & 03 & 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo_prod'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($i=0; $i < count($dados); $i++) { 
                            $statusProd = $dados[$i]['status_prod'];
                            $Categ = $dados[$i]['categoria'];
                            $nome = $dados[$i]['nome'];
                            $nome_lower = strtolower($nome);

                            $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $statusCateg = $dados2[0]['status_categ'];

                            if($statusProd === 'ativo' && $statusCateg === 'ativo' && $k < 3 && $nome !== $Item_Relac_1 && $nome_lower !== $nome_clean){
                                $k++;
                                $id = $dados[$i]['id'];
                                $codigo = $dados[$i]['codigo'];
                                $img = $dados[$i]['img'];
                                $valor = $dados[$i]['valor'];
            
                                if($img == "placeholder.jpg" || $img == ""){
                                    $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                                }else{
                                    $img_prod = "<img src='assets/produtos/$img'>";
                                }
            
                                $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                    strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                    "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
            
                                $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
            
                                echo "<div class='produtos_atrelados'>
                                        <span class='code'>".$codigo."</span>
                                        <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                        ".$img_prod."
                                        <h4>".$nome."</h4>
                                        <p><span>R$</span>".$valor."</p>
                                        <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                    </div>";
                            }
                        }
                    }
                    if($Item_Relac_1 === '' && $Item_Relac_2 === '' && $Item_Relac_3 === '' && $Item_Relac_4 === ''){
                        //prod 01 & 02 & 03 & 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo_prod'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($i=0; $i < count($dados); $i++) { 
                            $statusProd = $dados[$i]['status_prod'];
                            $Categ = $dados[$i]['categoria'];
                            $nome = $dados[$i]['nome'];
                            $nome_lower = strtolower($nome);

                            $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $statusCateg = $dados2[0]['status_categ'];

                            if($statusProd === 'ativo' && $statusCateg === 'ativo' && $k < 4 && $nome_lower !== $nome_clean){
                                $k++;
                                $id = $dados[$i]['id'];
                                $codigo = $dados[$i]['codigo'];
                                $img = $dados[$i]['img'];
                                $valor = $dados[$i]['valor'];
            
                                if($img == "placeholder.jpg" || $img == ""){
                                    $img_prod = "<img src='assets/produtos/placeholder.jpg'>";
                                }else{
                                    $img_prod = "<img src='assets/produtos/$img'>";
                                }
            
                                $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                    strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                    "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
            
                                $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"';
            
                                echo "<div class='produtos_atrelados'>
                                        <span class='code'>".$codigo."</span>
                                        <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                        ".$img_prod."
                                        <h4>".$nome."</h4>
                                        <p><span>R$</span>".$valor."</p>
                                        <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                    </div>";
                            }
                        }
                    }
                ?>
            </div>
        </main>
    <?php } 
        if($status === 'sem_estoque'){ 
            echo '<main class="Produto prod_status"><h4> Este produto atualmente está sem estoque! <br/> Agradecemos sua paciencia. Iremos trabalhar o mais rápido possivel para repor nossos estoques!</h4><a href="./produtos">Enquanto isso, conheça os outros produtos do nosso catálogo Clicando aqui!</a></main>'; 
        }if($status === 'inativo'){ 
            echo '<main class="Produto prod_status"><h4> Produto não encontrado </h4><a href="./produtos">Volte o catálogo de todos nossos produtos Clicando aqui!</a></main>'; 
        }
    ?>
    
    <footer>
        <p>&copy; <?php echo date('Y') ?> | Auto inove</p>
        <span>Desenvolvido por:</span>
        <a href="https://www.universofarol.com.br"><img src="assets/icons/Universo_Farol.svg" onload="SVGInject(this)"></a>
    </footer>

    <div class='msg_Carrinho hide'>
        <button type='button' onclick='document.querySelector(".msg_Carrinho").classList.add("hide")'><img src="assets/icons/close.svg" onload="SVGInject(this)"></button>
        <p>1 item foi adicionado ao carrinho</p>
        <div class="progress-wrap progress" data-progress-percent="100">
            <div class="progress-bar progress"></div>
        </div>
    </div>

    <div class="hide searchBar_List">
        <?php
            $query = $pdo->query("SELECT * FROM sub_categorias ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($dados); $i++) { 
                $nome = $dados[$i]['nome'];
                $categAtrelada = $dados[$i]['categ_Atrelada'];

                $query2 = $pdo->query("SELECT * FROM categorias where nome = '$categAtrelada'");
                $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $status = $dados2[0]['status_categ'];
                if($status === 'ativo'){
                    $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                            strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                            "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                    $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                    echo "
                        <div class='hidelist'>
                            <p>null</p>
                            <p>".$nome."</p>
                            <p class='hide'>".$nome_url."</p>
                            <span>sub_categorias</span>
                        </div>
                    ";
                }                
            }
        
            $query = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($dados); $i++) {
                $status = $dados[$i]['status_categ'];
                if($status === 'ativo'){
                    $nome = $dados[$i]['nome'];
                    $img = $dados[$i]['img'];
    
                    $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                            strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                            "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                    $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                    echo "
                        <div class='hidelist'>
                            <p>".$img."</p>
                            <p>".$nome."</p>
                            <p class='hide'>".$nome_url."</p>
                            <span>categorias</span>
                        </div>
                    ";
                }
            }
        
            $query = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($dados); $i++) { 
                $status = $dados[$i]['status_prod'];
                if($status === 'ativo'){
                    $nome = $dados[$i]['nome'];
                    $img = $dados[$i]['img'];
    
                    $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                            strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                            "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                    $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                    echo "
                        <div class='hidelist list_prod_search'>
                            <p>".$img."</p>
                            <p>".$nome."</p>
                            <p>".$nome_url."</p>
                            <span>produtos</span>
                        </div>
                    ";
                }
            }
        ?>
    </div>

    <form id="form_vendaDireta" class="hide" method="POST">
        <input type="hidden" id="id_prod" name="id_prod" value="<?php echo $id_prod ?>">
        <input type="hidden" id="quant_prod" name="quant_prod" value="">
    </form>

    <script>
        $('header').css('background', '#131313');

        function quantidade(acao) { 
            var valor = Number($('.quant').text());
            if (acao === 'subtrai' && valor > 0) {
                valor--;
            } else if (acao === 'soma' && valor < <?php echo $estoque ?>) {
                valor++;
            }
            $('.quant').text(valor);
        }

        $('#form_vendaDireta').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "./vendas_Prod/update_Val.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (msg) { }
            })
        });

        function linkCompra() {
            let quant = $('.quant').text();

            $('#quant_prod').val(quant);
            $('#form_vendaDireta').click();

            $(".linkcompra").attr("href", `https://wa.me/<?php echo $numero_Whats ?>?text=Olá,%20Gostaria%20de%20comprar%20${quant}%20unidade(s)%20do%20produto: <?php echo $nome_clean ?>`);
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    </script>
</body>
</html>