<!-- <?php require_once("./sistema/configs/conexao.php"); ?>  -->
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
                                <li class='option_Codigos'>
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
            </div>
        </div>

        <img class="cart" src="assets/icons/cart.svg" onload="SVGInject(this)">
        <span></span>
        <img class="menu" src="assets/icons/menu.svg" onload="SVGInject(this)" onclick="menuToggle()">
        <div class="side_menu" onclick="menuToggle()">
            <img class="close_menu" src="assets/icons/close.svg" onload="SVGInject(this)" onclick="menuToggle()">
            <a href="#">Produtos</a>
            <a href="#">Categorias</a>
            <a href="#">Contato</a>
            <a href="#">Meu carrinho</a>
        </div>
    </header>

    <main class="Inicio">
        <section class="Banner">
            <img src="assets/backgrounds/Home_Background.webp" alt="">
            <h1>Potência e alto desempenho <br> para o <span>SEU VEÍCULO!</span></h1>
            <h3>A excelência em peças de transmissão automática <br> para uma performance inigualável!</h3>
        </section>
        <section class="Dobra_Categ">
            <div id='img_bg'></div>
            <h2>A maior diversidade de peças para o seu carro!</h2>
            <a class="categoria" href="">
                <!-- <img src="" alt=""> -->
                <p></p>
            </a>
            <a class="btn btn_Categ" href="">Conheça mais</a>
        </section>
        <section class="Dobra_Prods">
            <h2>Últimos produtos adicionados ao estoque</h2>
            <a href="#">
            </a>
            <a class="btn btn_prods" href="">Veja mais</a>
        </section>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y') ?> | Auto inove</p>
        <span>Desenvolvido por:</span>
        <a href="https://www.universofarol.com.br"><img src="assets/icons/Universo_Farol.svg" onload="SVGInject(this)"></a>
    </footer>

    <div class="hide searchBar_List">
        <div class="hidelist">
            <p>nome_Teste</p>
            <span>Categoria</span>
        </div>

        <div class="hidelist">
            <p>no</p>
            <span>SubCategoria</span>
        </div>

        <div class="hidelist">
            <p>batatas</p>
            <span>Produto</span>
        </div>

        <div class="hidelist">
            <p>felipe</p>
            <span>Produto</span>
        </div>
    </div>

</body>
</html>

<!-- 

$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
$nome_url = preg_replace('/[ -]+/' , '-' , $nome_novo);

-->