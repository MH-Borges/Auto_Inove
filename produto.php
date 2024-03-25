<?php 
require_once("sistema/configs/conexao.php"); 

$nome_get = @$_GET['nome'];
$nome_clean = preg_replace('/_/', ' ', $nome_get);
$codigo_get = @$_COOKIE["Cookie_Codigo"];

$query = $pdo->query("SELECT * FROM produtos where nome = '$nome_clean'");
$dados = $query->fetchAll(PDO::FETCH_ASSOC);
@$status = $dados[0]['status_prod'];

if($status === 'ativo'){
    $Visualizacoes = $dados[0]['Visualizacoes'];
    $Visualizacoes++;
    //atualiza Visualizações da página
    $res = $pdo->prepare("UPDATE produtos SET Visualizacoes = :Visualizacoes WHERE nome = :nome");
    $res->bindValue(":Visualizacoes", $Visualizacoes);
    $res->bindValue(":nome", $nome_clean);
    $res->execute();

    $id = $dados[0]['id'];
    $img = $dados[0]['img'];
    $nome = $dados[0]['nome'];
    $valor = $dados[0]['valor'];
    $descricao = $dados[0]['descricao'];
    $categoria = $dados[0]['categoria'];
    $sub_categoria = $dados[0]['sub_categoria'];
    $codigo = $dados[0]['codigo'];
    $marca = $dados[0]['marca'];
    $litros = $dados[0]['litros'];

    $Item_Relac_1 = $dados[0]['Item_Relac_1'];
    $Item_Relac_2 = $dados[0]['Item_Relac_2'];
    $Item_Relac_3 = $dados[0]['Item_Relac_3'];
    $Item_Relac_4 = $dados[0]['Item_Relac_4'];

    if($sub_categoria !== NULL || $sub_categoria !== " "){
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
            <?php echo $breadcrumbs ?>
            <div class='main_Block'>
                <div class='infos'>
                    <h1><?php echo $nome ?></h1>
                    <h5>Código:<?php echo $nome ?></h5>
                    <h5>Marca:<?php echo $marca ?></h5>
                    <?php if($litros !== '' && $litros !== NULL){
                        echo '<h5>Litros:'.$litros.'L</h5>';
                    }?>
                    <div class='valor'>
                        <span>R$ <h3><?php echo $valor?><h3></span>
                    </div>

                    <div class='Ações'>
                        <div class='AddRemove'>
                            <button class='remove' type='button' onclick='SubtraiCarrinho()'></button>
                            <span class='quant'>1</span>
                            <button class='add' type='button' onclick='SomaCarrinho()'></button>
                        </div>
                        <button type='button' onclick='addCarrinho(<?php echo "`$id`, `$img`, `$nome`, `$codigo`, true"; ?>)'>Adicionar ao carrinho</button>
                        <a href="#">Comprar agora</a>
                    </div>
                    

                </div>
                <div class='img'><?php echo $img_prod ?></div>
            </div>
            <div class='descrition_Block'>
                <h2>Descrição</h2>
                <?php echo $descricao ?>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo'");
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
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
        
                            echo "<div class='produtos_recentes'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 03 & 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($i=0; $i < count($dados); $i++) { 
                            $statusProd = $dados[$i]['status_prod'];
                            $Categ = $dados[$i]['categoria'];
                            $nome = $dados[$i]['nome'];

                            $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $statusCateg = $dados2[0]['status_categ'];

                            if($statusProd === 'ativo' && $statusCateg === 'ativo' && $k < 2 && $nome !== $Item_Relac_1 && $nome !== $Item_Relac_2){
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
            
                                echo "<div class='produtos_recentes'>
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
                        var_dump('entrei');

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
        
                            echo "<div class='produtos_recentes'>
                                    <span class='code'>".$codigo."</span>
                                    <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                    ".$img_prod."
                                    <h4>".$nome."</h4>
                                    <p><span>R$</span>".$valor."</p>
                                    <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                </div>";
                        }

                        //prod 02 & 03 & 04
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($i=0; $i < count($dados); $i++) { 
                            $statusProd = $dados[$i]['status_prod'];
                            $Categ = $dados[$i]['categoria'];
                            $nome = $dados[$i]['nome'];

                            $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $statusCateg = $dados2[0]['status_categ'];

                            if($statusProd === 'ativo' && $statusCateg === 'ativo' && $k < 3 && $nome !== $Item_Relac_1){
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
            
                                echo "<div class='produtos_recentes'>
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
                        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo'");
                        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                        $k=0;
                        for ($i=0; $i < count($dados); $i++) { 
                            $statusProd = $dados[$i]['status_prod'];
                            $Categ = $dados[$i]['categoria'];

                            $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            $statusCateg = $dados2[0]['status_categ'];

                            if($statusProd === 'ativo' && $statusCateg === 'ativo' && $k < 4){
                                $k++;
                                $id = $dados[$i]['id'];
                                $codigo = $dados[$i]['codigo'];
                                $img = $dados[$i]['img'];
                                $nome = $dados[$i]['nome'];
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
            
                                echo "<div class='produtos_recentes'>
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

    <?php } else{ echo '<main class="Produto"><h4> Produto não encontrado </h4><a href="./produtos">Volte o catálogo de todos nossos produtos Clicando aqui!</a></main>'; }?>
    
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
                        <div class='hidelist'>
                            <p>".$img."</p>
                            <p>".$nome."</p>
                            <p class='hide'>".$nome_url."</p>
                            <span>produtos</span>
                        </div>
                    ";
                }
            }
        ?>
    </div>

    <script>
       
    </script>
</body>
</html>