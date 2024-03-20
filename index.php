<?php require_once("./sistema/configs/conexao.php"); ?>
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

    <main class="Inicio" >
        <section class="Banner">
            <img src="assets/backgrounds/Home_Background.webp" alt="">
            <h1>Potência e alto desempenho <br> para o <span>SEU VEÍCULO!</span></h1>
            <h3>A excelência em peças de transmissão automática <br> para uma performance inigualável!</h3>
        </section>
        <section class="Dobra_Categ">
            <div id='img_bg_categ'></div>
            <h2>A maior diversidade <br> de peças para <span>o seu carro!<span></h2>
            <img class="underline" src="assets/icons/Underline_highlight.svg" onload="SVGInject(this)">
            <?php
                $query = $pdo->query("SELECT * FROM categorias ORDER BY id ASC LIMIT 12");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                for ($i=0; $i < count($dados); $i++) { 
                        
                    $img_categoria = $dados[$i]['img'];
                    $nome_categoria = $dados[$i]['nome'];

                    $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "_", 
                        strtr(utf8_decode(trim($nome_categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
                        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
                    $nome_url = preg_replace('/[ -]+/' , '_' , $nome_novo);

                    if($img_categoria == "placeholder.svg" || $img_categoria == ""){
                        $img_categoria = "<img class='img_categoria' src='assets/icons/placeholder.svg'>";
                    }else{
                        $img_categoria = "<img class='img_categoria' src='assets/categorias/$img_categoria'>";
                    }
                    echo "
                        <a class='categoria' href='produtos_".$nome_url."'>
                            ".$img_categoria."
                            <p>".$nome_categoria."</p>
                        </a>
                    ";
                }
            ?>
            <a class="btn btn_Categ" href="./categorias ">Conheça mais</a>
        </section>
        <section class="Dobra_Prods">
            <div id='img_bg_prods'></div>
            <h2>Últimos produtos adicionados ao estoque</h2>
            <?php
                $query = $pdo->query("SELECT * FROM produtos ORDER BY id DESC LIMIT 4");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                for ($i=0; $i < count($dados); $i++) { 
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

                    $Onclick = '"'.$id.'", "'.$img.'", "'.$nome.'"';

                    echo "<div class='produtos_recentes'>
                            <span class='code'>".$codigo."</span>
                            <button onclick='addCarrinho(".$Onclick.")'><img src='assets/icons/bag.svg' onload='SVGInject(this)'></button>
                            ".$img_prod."
                            <h4>".$nome."</h4>
                            <p><span>R$</span>".$valor."</p>
                            <a href='produto_".$nome_url."'><img src='assets/icons/close.svg' onload='SVGInject(this)'></a>
                        </div>";
                }
            ?>
            <a class="btn btn_prods" href="./produtos">Veja mais</a>
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