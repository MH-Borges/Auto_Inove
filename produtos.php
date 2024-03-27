<?php 
require_once("sistema/configs/conexao.php"); 

$nome_get = @$_GET['nome'];
$nome_clean = preg_replace('/_/', ' ', $nome_get);
$codigo_get = @$_COOKIE["Cookie_Codigo"];

if($nome_get !== '' && $nome_get !== NULL){
    $query = $pdo->query("SELECT * FROM categorias where nome = '$nome_clean'");
    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
    if(count($dados)> 0){
        $TipoBusca = $pdo->query("SELECT * FROM produtos where categoria = '$nome_clean' ");
        $tipo = 'Categoria';
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
    }
    else{
        $query = $pdo->query("SELECT * FROM sub_categorias where nome = '$nome_clean'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados)> 0){
            $TipoBusca = $pdo->query("SELECT * FROM produtos where sub_categoria = '$nome_clean' ");
            $categAtrelada = $dados[0]['categ_Atrelada'];
            $tipo = 'Sub-Categoria';
            $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="./categorias">'.$categAtrelada.'</a></li>
                            <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';

        }
    }
} else{ 
    $TipoBusca = $pdo->query("SELECT * FROM produtos ORDER BY id desc");
    $nome_clean = 'Produtos'; 
    $tipo = ' '; 
    $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li><li class="breadcrumb-item active" aria-current="page">Produtos</li>'; 
}

if($nome_get === 'MaisVendidos' || str_contains($nome_get , 'C_MaisVendidos') || str_contains($nome_get , 'S_MaisVendidos')){
    if($nome_get === 'MaisVendidos'){
        $TipoBusca = $pdo->query("SELECT * FROM produtos ORDER BY Vendas DESC");
        $nome_clean = 'Produtos'; 
        $tipo = ' '; 
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li><li class="breadcrumb-item active" aria-current="page">Produtos</li>'; 
    }

    if(str_contains($nome_get , 'C_MaisVendidos')){
        $nome_clean = preg_replace('/C_MaisVendidos/', ' ', $nome_get);
        $nome_clean = preg_replace('/_/', ' ', $nome_clean);

        $TipoBusca = $pdo->query("SELECT * FROM produtos where categoria = '$nome_clean' ORDER BY Vendas DESC");
        $tipo = 'Categoria';
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
    }

    if(str_contains($nome_get , 'S_MaisVendidos')){
        $nome_clean = preg_replace('/S_MaisVendidos/', ' ', $nome_get);
        $nome_clean = preg_replace('/_/', ' ', $nome_clean);

        $query = $pdo->query("SELECT * FROM sub_categorias where nome = '$nome_clean'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados)> 0){
            $TipoBusca = $pdo->query("SELECT * FROM produtos where sub_categoria = '$nome_clean' ORDER BY Vendas DESC");
            $categAtrelada = $dados[0]['categ_Atrelada'];
            $tipo = 'Sub-Categoria';
            $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="./categorias">'.$categAtrelada.'</a></li>
                            <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
        }

    }
}
if($nome_get === 'MenorPreco' || str_contains($nome_get , 'C_MenorPreco') || str_contains($nome_get , 'S_MenorPreco')){
    if($nome_get === 'MenorPreco'){
        $TipoBusca = $pdo->query("SELECT * FROM produtos ORDER BY valor asc");
        $nome_clean = 'Produtos'; 
        $tipo = ' '; 
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li><li class="breadcrumb-item active" aria-current="page">Produtos</li>'; 
    }

    if(str_contains($nome_get , 'C_MenorPreco')){
        $nome_clean = preg_replace('/C_MenorPreco/', ' ', $nome_get);
        $nome_clean = preg_replace('/_/', ' ', $nome_clean);

        $TipoBusca = $pdo->query("SELECT * FROM produtos where categoria = '$nome_clean' ORDER BY valor asc");
        $tipo = 'Categoria';
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
    }

    if(str_contains($nome_get , 'S_MenorPreco')){
        $nome_clean = preg_replace('/S_MenorPreco/', ' ', $nome_get);
        $nome_clean = preg_replace('/_/', ' ', $nome_clean);

        $query = $pdo->query("SELECT * FROM sub_categorias where nome = '$nome_clean'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados)> 0){
            $TipoBusca = $pdo->query("SELECT * FROM produtos where sub_categoria = '$nome_clean' ORDER BY valor asc");
            $categAtrelada = $dados[0]['categ_Atrelada'];
            $tipo = 'Sub-Categoria';
            $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="./categorias">'.$categAtrelada.'</a></li>
                            <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
        }

    }

  
}
if($nome_get === 'MaiorPreco' || str_contains($nome_get , 'C_MaiorPreco') || str_contains($nome_get , 'S_MaiorPreco')){
    if($nome_get === 'MaiorPreco'){
        $TipoBusca = $pdo->query("SELECT * FROM produtos ORDER BY valor DESC");
        $nome_clean = 'Produtos'; 
        $tipo = ' '; 
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li><li class="breadcrumb-item active" aria-current="page">Produtos</li>'; 
    }

    if(str_contains($nome_get , 'C_MaiorPreco')){
        $nome_clean = preg_replace('/C_MaiorPreco/', ' ', $nome_get);
        $nome_clean = preg_replace('/_/', ' ', $nome_clean);

        $TipoBusca = $pdo->query("SELECT * FROM produtos where categoria = '$nome_clean' ORDER BY valor DESC");
        $tipo = 'Categoria';
        $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
    }

    if(str_contains($nome_get , 'S_MaiorPreco')){
        $nome_clean = preg_replace('/S_MaiorPreco/', ' ', $nome_get);
        $nome_clean = preg_replace('/_/', ' ', $nome_clean);

        $query = $pdo->query("SELECT * FROM sub_categorias where nome = '$nome_clean'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($dados)> 0){
            $TipoBusca = $pdo->query("SELECT * FROM produtos where sub_categoria = '$nome_clean' ORDER BY valor DESC");
            $categAtrelada = $dados[0]['categ_Atrelada'];
            $tipo = 'Sub-Categoria';
            $breadcrumbs = '<li class="breadcrumb-item"><a href="./">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="./categorias">'.$categAtrelada.'</a></li>
                            <li class="breadcrumb-item active" aria-current="page">'.$nome_clean.'</li>';
        }

    }

  
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Inove | Inicio</title>
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

    <main class="Produtos">
        <section class="Header_main">
            <?php 
                $query = $pdo->query("SELECT * FROM categorias ORDER BY id asc");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                $k=0;
                for ($j=0; $j < count($dados); $j++) {
                    $status = $dados[$j]['status_categ'];
                    if($status === 'ativo' && $k < 7){
                        $k++;
                        $nome = $dados[$j]['nome'];
    
                        $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                        $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                        $query2 = $pdo->query("SELECT * FROM sub_categorias WHERE categ_Atrelada = '$nome'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        if (@count($dados2)> 0){
                            echo "
                                <div class='list_Categs'>
                                    <a onclick='notif(`".$nome."`, `categoria`, `".$nome_url."`)' class='categ_Subcategs ".$nome_url."'>
                                        <p>".$nome."</p>
                                        <img src='assets/icons/seta.svg' onload='SVGInject(this)'>
                                    </a>
                                    <div class='dropdown-menu'>
                                    ";
                                    for ($i=0; $i < count($dados2); $i++) {
                                        $nome_subCateg = $dados2[$i]['nome'];
                                        $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                                strtr(utf8_decode(trim($nome_subCateg)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                        $nome_url_sub = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                                        echo "
                                            <a onclick='notif(`".$nome_subCateg."`, `sub-categoria`, `".$nome_url_sub."`)' class='dropdown-item ".$nome_url_sub."'>".$nome_subCateg."</a>
                                        ";
                                    } 
                                echo "</div></div>";
                        }
                        else{
                            echo" <a onclick='notif(`".$nome."`, `categoria`, `".$nome_url."`)' class='list_Categs ".$nome_url."'><p>".$nome."</p></a> ";
                        }
                        $m=$j;
                    }
                }

                echo "
                    <div class='list_Categs'>
                        <button type='button' data-toggle='dropdown' aria-expanded='false'>
                            <p>+Categorias</p>
                            <img src='assets/icons/seta.svg' onload='SVGInject(this)'>
                        </button>
                        <div class='dropdown-menu'>";
                            $query = $pdo->query("SELECT * FROM categorias ORDER BY id asc");
                            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                            $m++;
                            for ($m; $m < count($dados); $m++) {
                                $status = $dados[$m]['status_categ'];       
                                if($status === 'ativo'){
                                    $nome = $dados[$m]['nome'];
    
                                    $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                            strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                            "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                    $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                                    echo" <a onclick='notif(`".$nome."`, `categoria`, `".$nome_url."`)' class='dropdown-item ".$nome_url."'>$nome</a> ";
                                }
                            }
                    echo "</div>
                    </div>
                ";
            ?>
        </section>

        <section class="SubHeader">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php echo $breadcrumbs ?>
                </ol>
            </nav>

            <h1 id='titulo'><?php echo $nome_clean ?></h1>
            <h3 id='tipoBusca'><?php echo $tipo ?></h3>
        </section>

        <section class="Produtos_Block">
            <div class='Sub_menu'>
                <div class='filtros_Block'>
                    <?php
                        if($nome_get === 'MaisVendidos' || str_contains($nome_get, 'C_MaisVendidos') || str_contains($nome_get, 'S_MaisVendidos') 
                        || $nome_get === 'MenorPreco' || str_contains($nome_get, 'C_MenorPreco') || str_contains($nome_get, 'S_MenorPreco') 
                        || $nome_get === 'MaiorPreco' || str_contains($nome_get, 'C_MaiorPreco') || str_contains($nome_get, 'S_MaiorPreco')){ 
                            echo "<button class='LimpaFiltros' onclick='CLeanCodigo()'>Limpar todos os filtros</button>"; 
                        }
                    
                    
                        if(str_contains($nome_get, 'C_MaisVendidos') || str_contains($nome_get, 'S_MaisVendidos')){ 
                            echo "<button class='filtros ativo'>"; 
                        }
                        else{
                            echo "<button class='filtros' onclick='Flitro(`MaisVendidos`)'>";
                        }
                    ?>
    
                        <img src="assets/icons/MaisVendidos.svg" onload="SVGInject(this)">
                        <p>Mais Vendidos</p>
                    </button>
    
    
                    <?php
                        if(str_contains($nome_get, 'C_MenorPreco') || str_contains($nome_get, 'S_MenorPreco')){ 
                            echo "<button class='filtros ativo'>"; 
                        }
                        else{
                            echo "<button class='filtros' onclick='Flitro(`MenorPreco`)'>";
                        }
                    ?>
                    
                        <img src="assets/icons/MenorPreco.svg" onload="SVGInject(this)">
                        <p>Menor Preço</p>
                    </button>
    
                    <?php
                        if(str_contains($nome_get, 'C_MaiorPreco') || str_contains($nome_get, 'S_MaiorPreco')){ 
                            echo "<button class='filtros ativo'>"; 
                        }
                        else{
                            echo "<button class='filtros' onclick='Flitro(`MaiorPreco`)'>";
                        }
                    ?>
                        <img src="assets/icons/MaiorPreco.svg" onload="SVGInject(this)">
                        <p>Maior Preço</p>
                    </button>
                </div>

                <?php
                    if($tipo === ' '){
                        echo "
                            <div class='subCateg_list'>
                                <button type='button' data-toggle='collapse' data-target='#Sub_Categs' onclick='rotate(`Sub_Categs`)'>
                                    Sub-Categorias
                                    <img class='setaSubCategs' src='assets/icons/seta.svg' onload='SVGInject(this)'>
                                </button>
                                <div class='collapse show' id='Sub_Categs'>";

                                    $query = $pdo->query("SELECT * FROM sub_categorias");
                                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                    for ($i=0; $i < count($dados); $i++) { 
                                        $nome_categoria = $dados[$i]['nome'];
                                        $categAtrelada = $dados[$i]['categ_Atrelada'];

                                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$categAtrelada'");
                                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                        $status = $dados2[0]['status_categ'];
                                        if($status === 'ativo'){
                                            $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                                strtr(utf8_decode(trim($nome_categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                                "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                            $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);
    
                                            echo "
                                                <a onclick='notif(`".$nome_categoria."`, `sub-categoria`, `".$nome_url."`)' class='".$nome_url."'>
                                                    <p>".$nome_categoria."</p>
                                                </a>
                                            ";
                                        }
                                    }

                        echo "</div>
                            </div>";
                    } 
                    if($tipo === 'Categoria'){
                        echo "
                            <div class='subCateg_list'>
                                <button type='button' data-toggle='collapse' data-target='#Sub_Categs' onclick='rotate(`Sub_Categs`)'>
                                    Sub-Categorias
                                    <img class='setaSubCategs' src='assets/icons/seta.svg' onload='SVGInject(this)'>
                                </button>
                                <div class='collapse show' id='Sub_Categs'>";

                                    $query = $pdo->query("SELECT * FROM sub_categorias where categ_Atrelada = '$nome_clean' ");
                                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                                    for ($i=0; $i < count($dados); $i++) { 
                                        $nome_categoria = $dados[$i]['nome'];
                                        $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                                            strtr(utf8_decode(trim($nome_categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                                            "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                                        $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);

                                        echo "
                                            <a href='produtos_".$nome_url."'>
                                                <p>".$nome_categoria."</p>
                                            </a>
                                        ";
                                    }

                        echo "</div>
                            </div>";
                    }
                ?>

                <div class="Codigo_list">
                    <button type="button" data-toggle="collapse" data-target="#Codigos_list" onclick='rotate("Codigo")'>
                        Codigos
                        <img class='setaCodigo' src='assets/icons/seta.svg' onload='SVGInject(this)'>
                    </button>
                    <div class="collapse" id="Codigos_list">
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
                                        <a onclick='codigoRedirect(`".$nome_codigos."`)'>
                                            <p>$nome_codigos</p>
                                        </a>
                                    ";
                                }
                                $k=0;
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="Produtos_list">
                <?php
                    if($codigo_get !== NULL && $codigo_get !== ''){ echo "<button class='LimpaFiltroCodigo' onclick='CLeanCodigo()'>Limpar filtro de Codigo</button>"; }
                ?>

                <?php
                    $query = $TipoBusca;
                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i=0; $i < count($dados); $i++) {
                        $codigo = $dados[$i]['codigo'];
                        $statusProd = $dados[$i]['status_prod'];
                        $Categ = $dados[$i]['categoria'];

                        $query2 = $pdo->query("SELECT * FROM categorias where nome = '$Categ'");
                        $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $statusCateg = $dados2[0]['status_categ'];

                        if($statusProd === 'ativo' && $statusCateg === 'ativo'){
                            if($codigo_get !== NULL && $codigo_get !== ' '){
                                if($codigo_get === $codigo){
                                    $id = $dados[$i]['id'];
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
                
                                    $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'", "'.$codigo.'"' ;
                
                                    echo "<div class='produtos'>
                                            <span class='code'>".$codigo."</span>
                                            <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                            ".$img_prod."
                                            <h4>".$nome."</h4>
                                            <p><span>R$</span>".$valor."</p>
                                            <a onclick='notif(`".$nome."`, `produto`, `".$nome_url."`)' class='".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                        </div>";
                                }
                            }
                            else{
                                $id = $dados[$i]['id'];
                                $img = $dados[$i]['img'];
                                $nome = $dados[$i]['nome'];
                                $valor = $dados[$i]['valor'];
                                $vendas = $dados[$i]['Vendas'];
    
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
            
                                echo "<div class='produtos'>
                                        <span class='code'>".$codigo."</span>
                                        <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                                        ".$img_prod."
                                        <h4>".$nome."</h4>
                                        <p><span>R$</span>".$valor."</p>
                                        <a onclick='notif(`".$nome."`, `produto`, `".$nome_url."`)' class='".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                                    </div>";
                            }
                        }
                    }
                ?>

            </div>
        </section>
    </main>
    
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

    <form id="form_Notificacao" class="hide" method="POST"></form>

    <script>
        $('header').css('background', '#131313');
        
        document.querySelectorAll('.categ_Subcategs').forEach(e => {
            let dropdown = e.parentNode.children[1];

            e.addEventListener('mouseenter', () =>{
                dropdown.classList.add("show");
                dropdown.classList.add("showDropdown");
            });

            e.addEventListener('mouseout', () =>{
                setTimeout(() => {
                    dropdown.classList.remove("show");
                    dropdown.classList.remove("showDropdown");
                }, 2000);
            });
        });

        function CLeanCodigo() {
            Cookies.remove('Cookie_Codigo');
            window.location.href = `./produtos`;
        }

        function Flitro(filtro) {
            const tipoBusca = $('#tipoBusca').text().trim();
            const titulo = $('#titulo').text().replaceAll(' ','').trim();
            let urlPrefix = './produtos_';

            if (tipoBusca === 'Categoria' || tipoBusca === 'Sub-Categoria') {
                urlPrefix += `${titulo}_${tipoBusca.charAt(0)}_`;
            }

            switch (filtro) {
                case "MaisVendidos":
                    urlPrefix += "MaisVendidos";
                    break;
                case "MenorPreco":
                    urlPrefix += "MenorPreco";
                    break;
                case "MaiorPreco":
                    urlPrefix += "MaiorPreco";
                    break;
                default:
                    return;
            }

            window.location.href = urlPrefix;
        }
        
        function rotate(bloco) {
            if(bloco === 'Sub_Categs'){
                if($('#Sub_Categs').hasClass('show')){
                    $('.setaSubCategs').css('transform','rotate(0)');
                }
                else{ 
                    $('.setaSubCategs').css('transform','rotate(180deg)'); 
                }
            }
            if(bloco === 'Codigo'){
                if($('#Codigos_list').hasClass('show')){
                    $('.setaCodigo').css('transform','rotate(0)');
                }
                else{ 
                    $('.setaCodigo').css('transform','rotate(180deg)'); 
                }
            }
        }
    </script>
</body>
</html>