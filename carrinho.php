<?php require_once("sistema/configs/conexao.php"); ?>
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
            <div class='center'>
                <h3>Seu carrinho está vazio!!</h3>
                <a class='linkTelaVazia' href="./produtos">Que tal conhecer alguns produtos da nossa marca! Clique aqui e veja mais!</a>
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
                                <button class='subtrai' type='button'></button>
                                <span class='quant'>${item.quant}</span>
                                <button class='soma' type='button'></button>
                            </div>
                            <button type='button' class='removeCarrinho'><img src='assets/icons/delet.svg'></button>
                        </div>`);
                });

                $('.carrinho_Block').append(`<a class='linkfinal' href='#'>Finalizar Compra</a>`);
            }

            document.querySelectorAll('.subtrai').forEach(e => {
                e.addEventListener('click', event => {
                    updateCart(event, false);
                });
            });

            document.querySelectorAll('.soma').forEach(e => {
                e.addEventListener('click', event => {
                    updateCart(event, true);
                });
            });

            document.querySelectorAll('.removeCarrinho').forEach(e => {
                e.addEventListener('click', event => {
                    let pai = event.target.parentNode.parentNode;
                    let nome = pai.children[1].innerHTML;

                    let CarrinhoCookie = Cookies.get('Carrinho');
                    let CookieToArray = [];
                    if (CarrinhoCookie) {
                        CookieToArray = CarrinhoCookie.split("&").map(function (item) {
                            let obj = {};
                            item.split("_").forEach(function (pair) {
                                let parts = pair.split(":");
                                obj[parts[0]] = parts[1];
                            });
                            return obj;
                        });
                    }

                    document.querySelectorAll('.itensCarrinho').forEach(e => {
                        if (nome === e.children[1].innerHTML) {
                            let valorCarrin = Number($('.CartNotf').text()) - Number(e.children[2].innerHTML.replaceAll('Quant: ',' '));
                            if(valorCarrin === 0){
                                $('.CartNotf').text(' ');
                                $('.CartNotf').addClass('hide');
                            } else { $('.CartNotf').text(valorCarrin); }
                            e.remove();
                        }
                    });

                    document.querySelectorAll('.itenCarrinho').forEach(e => {
                        if (nome === e.children[1].innerHTML) {
                            e.remove();
                        }
                    });

                    let i=0;
                    CookieToArray.every(item => {
                        if (item.nomeProd === nome){
                            return false;
                        } 
                        else{
                            i++;
                            return true;
                        } 
                    });

                    CookieToArray.splice(i, 1);

                    let CarrinhoToString = CookieToArray.map(function (obj) {
                        return 'idProd:' + obj.idProd + '_quant:' + obj.quant + '_imgProd:' + obj.imgProd + '_nomeProd:' + obj.nomeProd + '_codigo:' + obj.codigo;
                    }).join('&');

                    Cookies.set('Carrinho', CarrinhoToString, {
                        expires: 1
                    });

                });
            });
        });

        function updateCart(event, increment) {
            let CarrinhoCookie = Cookies.get('Carrinho');
            let CookieToArray = [];
            if (CarrinhoCookie) {
                CookieToArray = CarrinhoCookie.split("&").map(function (item) {
                    let obj = {};
                    item.split("_").forEach(function (pair) {
                        let parts = pair.split(":");
                        obj[parts[0]] = parts[1];
                    });
                    return obj;
                });
            }

            let pai = event.target.parentNode;
            let avo = pai.parentNode;
            let valor = Number(pai.children[1].innerHTML);
            let nome = avo.children[1].innerHTML;

            if (increment) {
                valor++;
            } else {
                if (valor > 0) {
                    valor--;
                }
            }

            pai.children[1].innerHTML = valor;

            CookieToArray.forEach(item => {
                if (nome === item.nomeProd) {
                    item.quant = valor;
                    document.querySelectorAll('.itensCarrinho').forEach(e => {
                        if (nome === e.children[1].innerHTML) {
                            e.children[2].innerHTML = "Quant: " + valor;
                        }
                    });
                }
            });

            let spanCarrin = $('.CartNotf').text();
            if (increment) {
                spanCarrin++;
            } else {
                if (spanCarrin > 0) {
                    spanCarrin--;
                }
            }
            $('.CartNotf').text(spanCarrin);

            let CarrinhoToString = CookieToArray.map(function (obj) {
                return 'idProd:' + obj.idProd + '_quant:' + obj.quant + '_imgProd:' + obj.imgProd + '_nomeProd:' + obj.nomeProd + '_codigo:' + obj.codigo;
            }).join('&');

            Cookies.set('Carrinho', CarrinhoToString, {
                expires: 1
            });
        }
    </script>
</body>
</html>

<!-- %20 = espaço em branco -->
<!-- ///// = divisoria -->

<!-- https://wa.me/5541998431084?text=teste%20de%20mensagem%20quantidade:2%20/////%20testedeaaaaa%20quantidade:5%20///// -->