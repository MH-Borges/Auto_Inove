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
                            <li class="breadcrumb-item"><a href="./Categorias">'.$categAtrelada.'</a></li>
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
                            <li class="breadcrumb-item"><a href="./Categorias">'.$categAtrelada.'</a></li>
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
                            <li class="breadcrumb-item"><a href="./Categorias">'.$categAtrelada.'</a></li>
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
                            <li class="breadcrumb-item"><a href="./Categorias">'.$categAtrelada.'</a></li>
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
    <title>Auto Inove | Carrinho</title>
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

    <main class="Carrinho">
        <section class='carrinho_Block'>
            <h3>Seu carrinho está vazio!!</h3>
            <a class='linkTelaVazia' href="./produtos">Que tal conhecer alguns produtos da nossa marca! Clique aqui e veja mais!</a>
        </section>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y') ?> | Auto inove</p>
        <span>Desenvolvido por:</span>
        <a href="https://www.universofarol.com.br"><img src="assets/icons/Universo_Farol.svg" onload="SVGInject(this)"></a>
    </footer>

    <div class='msg_Carrinho hide'>
        <button type='button' onclick='document.querySelector(".msg_Carrinho").classList.add("hide")'><img src="assets/icons/close.svg" onload="SVGInject(this)"></button>
        <p>1 item foi removido ao carrinho</p>
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
        $(document).ready(function () {
            if(Cookies.get('Carrinho') !== undefined && Cookies.get('Carrinho') !== ''){
                
                let CarrinhoCookie = Cookies.get('Carrinho');
                
                const CookieToArray = CarrinhoCookie.split("&").map(function(item) {
                    var obj = {};
                    item.split("_").forEach(function(pair) {
                        var parts = pair.split(":");
                        obj[parts[0]] = parts[1];
                    });
                    return obj;
                });

                var itensCarrinho = 0;
                $('.carrinho_Block').text(' ');
                $('.carrinho_Block').append(`<div class='headerCarrinho'><h2>Item</h2><h2>Código</h2><h2>Quantidade</h2></div>`);
                $('.carrinho_Block').append(`<div class='itens_block'></div>`);

                CookieToArray.forEach(item => { 
                    itensCarrinho = itensCarrinho + Number(item.quant); 
                    
                    if(item.imgProd == "placeholder.jpg" || item.imgProd == ""){
                        var img = "<img src='assets/produtos/placeholder.jpg'>";
                    }else{
                        var img = `<img src='assets/produtos/${item.imgProd}'>`;
                    }

                    let nome_url = item.nomeProd.replaceAll(' ','_');

                    $('.itens_block').append(`
                        <div class='itenCarrinho'>
                            ${img}
                            <a class='nomeProd' href='produto_${nome_url}'>${item.nomeProd}</a>
                            <h4>${item.codigo}</h4>
                            <div class='AddRemove'>
                                <button class='remove' type='button' onclick='SubtraiCarrinho()'></button>
                                <span class='quant'>${item.quant}</span>
                                <button class='add' type='button' onclick='SomaCarrinho()'></button>
                            </div>
                        </div>`);
                });

                $('.carrinho_Block').append(`<a class='linkfinal' href='#'>Finalizar Compra</a>`);
            }
        });

        function SubtraiCarrinho() {
            console.log('remove');
        }

        function SomaCarrinho() {
            console.log('addCarrinho');
        }
        
    </script>
</body>
</html>

<!-- %20 = espaço em branco -->
<!-- ///// = divisoria -->

<!-- https://wa.me/5541998431084?text=teste%20de%20mensagem%20quantidade:2%20/////%20testedeaaaaa%20quantidade:5%20///// -->