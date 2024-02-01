<?php
    session_start();
    require_once("./sistema/configs/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universo Farol | Página de links</title>
    <link rel="icon" href="assets/icon_Logo.png" />
    <link rel="canonical" href="https://www.universofarol.com.br/links" />

    <meta name="author" content="Universo Farol || MHBorges || Julia Vitoria">
    <meta name="description" content="Pagina com os links para todas as redes sociais do universo farol junto do nosso portfólio e servições">
    <meta name="keywords" content="Universo Farol, UniversoFarol, Universo Farol Links, Universo Farol redes sociais, Universo Farol serviços, Universo Farol portfolio, Links, redes sociais, serviços, portfolio, criar logo, criar site, branding de marca, renovar marca, site profissional, logo profissional">
    
    <meta property="og:locale" content="pt_BR">
    <meta name="og:title" property="og:title" content="Universo Farol - Em meio a tempestade, uma luz guia para o seu negócio.">
    <meta name="og:type" property="og:type" content="website">
    <meta name="og:image" property="og:image" content="assets/Ilust_Farol.jpg">

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- SVGInject -->
    <script src="js/svg-inject.min.js"></script>
    <!-- Swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Main files -->
    <link rel="stylesheet" href="css/style_Links.css">
    <script src="js/script.js"></script>
    
</head>

<!-- COLOCAR LINKS CORRETOS NOS ICONS DE REDIRECIONAMENTO -->

<body class="linksPage">
    <div class="BackgroundLinks">
        <img class="BackPadrao" src="assets/estrelas.png" alt="Fundo estrelado">
        <img class="BackMetade" src="assets/estrelas_Metade.png" alt="Fundo estrelado">
    </div>
    <main class="main">
        <a class="LogoLinks" href="index.php">
            <img src="assets/logo_Bola.png" alt="Logo Universo farol">
        </a>
        <h1>UNIVERSO FAROL</h1>
        <h2>@universofarol</h2>
        <div class="icons_Links">
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/Instagram.svg" onload="SVGInject(this)">
            </a>
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/Behance.svg" onload="SVGInject(this)">
            </a>
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/E-mail.svg" onload="SVGInject(this)">
            </a>
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/WhatsApp.svg" onload="SVGInject(this)">
            </a>
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/Youtube.svg" onload="SVGInject(this)">
            </a>
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/Tiktok.svg" onload="SVGInject(this)">
            </a>
            <a href="https://google.com" target="_blank">
                <img src="assets/icones/Linkedin.svg" onload="SVGInject(this)">
            </a>
        </div>
        <h4>Agência de criação com foco em extrair a essência da sua marca e com personalidade trazê-la para o meio digital!</h4>

        <!-- <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                    $query = $pdo->query("SELECT * FROM links where ativo = 'sim' ORDER BY id ASC");
                    $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i=0; $i < count($dados); $i++) {
                        $img_Web = $dados[$i]['img_Web'];
                        $nome = $dados[$i]['nome'];
                        $categoria = $dados[$i]['categoria'];
                        $link_Banner = $dados[$i]['link'];

                        if($img_Web == "Default_Banner_Web.webp" || @$img_Web == ""){
                            $img_Web = "<img src='./assets/Banner_Links/Default_Banner_Web.webp' alt='link: $nome | Categoria: $categoria'>";
                        }else{
                            $img_Web = "<img src='./assets/Banner_Links/Web/$img_Web' alt='link: $nome | Categoria: $categoria'>";
                        }

                        echo "
                            <div class='swiper-slide'>
                                <a href='https://$link_Banner' target='_blank'>
                                    $img_Web    
                                </a>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="mobileBanner">
            <?php
                $query = $pdo->query("SELECT * FROM categoria_links ORDER BY id ASC");
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
                for ($i=0; $i < count($dados); $i++) {
                    $nomeCateg = $dados[$i]['nome'];

                    echo "
                        <div class='block_Categoria'>
                            <h3>$nomeCateg</h3>";
                            $query2 = $pdo->query("SELECT * FROM links where categoria = '$nomeCateg' ORDER BY id ASC");
                            $dados2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            for ($j=0; $j < count($dados2); $j++) {
                                $img_Mobile = $dados2[$j]['img_Mobile'];
                                $nome = $dados2[$j]['nome'];
                                $categoria = $dados2[$j]['categoria'];
                                $link_Banner = $dados2[$j]['link'];
                                $ativo = $dados2[$j]['ativo'];

                                if($ativo !== 'nao'){
                                    if($img_Mobile == "Default_Banner_Mobile.webp" || $img_Mobile == ""){
                                        $img_Mobile = "<img src='./assets/Banner_Links/Default_Banner_Mobile.webp' alt='link: $nome | Categoria: $categoria'>";
                                    }
                                    else{
                                        $img_Mobile = "<img src='./assets/Banner_Links/Mobile/$img_Mobile' alt='link: $nome | Categoria: $categoria'>";
                                    }
                                    echo "
                                        <a href='https://$link_Banner' target='_blank'>
                                            $img_Mobile
                                        </a>
                                    ";
                                }
                            }
                    echo "</div>";
                }
            ?>
        </div> -->
    </main>
    
    <footer>
        <a href="https://google.com" target="_blank">
            Contato@universofarol.com.br
        </a>
        <p>
            © <?php echo date("Y"); ?> | Universo Farol
        </p>
    </footer>

</body>
</html>