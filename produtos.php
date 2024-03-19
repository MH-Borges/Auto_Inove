<?php 
require_once("sistema/configs/conexao.php"); 

$nome_get = @$_GET['nome'];
$nome_clean = preg_replace('/_/', ' ', $nome_get);

$codigo_get = $_COOKIE["Cookie_Codigo"];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Inove | <?php echo $titulo ?></title>
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
    
    <!-- Cookies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.5/js.cookie.min.js"></script>

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
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
                        for ($j=0; $j < count($dados); $j++) {
                            $nome_codigos = $dados[$j]['nome'];
                            echo "
                                <li class='option_Codigos' onclick='codigoRedirect(`".$nome_codigos."`)'>
                                    <input type='radio' name='codigo_Produto' value='$nome_codigos' data-label='$nome_codigos'>
                                    <span class='label'>$nome_codigos</span>
                                </li>
                            ";
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

        <img class="cart" src="assets/icons/cart.svg" onload="SVGInject(this)">
        <span></span>
        <img class="menu" src="assets/icons/menu.svg" onload="SVGInject(this)" onclick="menuToggle()">
        <div class="side_menu hide">
            <img class="close_menu" src="assets/icons/close.svg" onclick="menuToggle()">
            <a href="./produtos">Produtos</a>
            <a href="./categorias">Categorias</a>
            <a target="_blank" href="https://wa.me/554198492024">Contato</a>
            <a href="./carrinho">Meu carrinho</a>
        </div>
    </header>

    <main class="Produtos">
        <section class="Header_main">


            <?php 
                $query = $pdo->query("SELECT * FROM categorias ORDER BY id asc LIMIT 7");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                for ($j=0; $j < count($dados); $j++) {
                    $nome = $dados[$j]['nome'];

                    $query2 = $pdo->query("SELECT * FROM sub_categorias WHERE categ_Atrelada = '$nome'");
                    $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);

                    if (@count($dados2)> 0){
                        echo "
                            <div class='list_Categs'>
                                <button type='button' data-toggle='dropdown' aria-expanded='false'>
                                    ".$nome."
                                </button>
                                <div class='dropdown-menu dropdown-menu-right dropdown-menu-lg-left'>
                                ";
                                for ($i=0; $i < count($dados2); $i++) {
                                    $nome_subCateg = $dados2[$i]['nome'];
                                    echo '
                                        <a class="dropdown-item" href="#">'.$nome_subCateg.'</a>
                                    ';
                                } 
                            echo "</div></div>";
                    }
                    else{
                        echo"
                        <div class='list_Categs'>
                            ".$nome."
                        </div>
                        ";
                    }

                    
                }

                echo "
                    <div class='list_Categs'>
                        <button type='button' data-toggle='dropdown' aria-expanded='false'>
                            +Categorias
                        </button>
                        <div class='dropdown-menu dropdown-menu-right dropdown-menu-lg-left'>";
                            $query = $pdo->query("SELECT * FROM categorias ORDER BY id asc");
                            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                            for ($j=7; $j < count($dados); $j++) {
                                $nome = $dados[$j]['nome'];
                                echo '<a class="dropdown-item" href="#">'.$nome.'</a>';
                            }

                    echo "</div>
                    </div>
                ";
            ?>
            
        </section>
        <section class="SubHeader"></section>
        <section class="Sub_menu"></section>
        <section class="Produtos_list"></section>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y') ?> | Auto inove</p>
        <span>Desenvolvido por:</span>
        <a href="https://www.universofarol.com.br"><img src="assets/icons/Universo_Farol.svg" onload="SVGInject(this)"></a>
    </footer>

    <div class="hide searchBar_List">
        <?php
            $query = $pdo->query("SELECT * FROM sub_categorias ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($dados); $i++) { 
                    
                $nome = $dados[$i]['nome'];
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
        ?>
        <?php
            $query = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($dados); $i++) { 
                    
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
        ?>
        <?php
            $query = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($dados); $i++) { 
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
        ?>
    </div>

</body>
</html>