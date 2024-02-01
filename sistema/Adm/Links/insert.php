<?php
@session_start();
require_once("../../configs/conexao.php"); 

$idEdit = $_POST['idEditLink'];
$CategoriaLink = $_POST['categorias'];
$NomeLink = $_POST['nomeLink'];
$Link = $_POST['link'];
$LinkAtivo = isset($_POST['linkAtivo']) ? 'sim' : 'nao';


// ===== VERIFICAÇÃO DE INPUTS VAZIOS =====
if($CategoriaLink == "" || $CategoriaLink == NULL || $CategoriaLink == "categoria_null"){
	echo 'Selecione uma categoria';
	exit();
}

if($NomeLink == ""){
	echo 'Preencha o Campo Nome do Link!';
	exit();
}

if($Link == ""){
	echo 'Preencha o Campo de Link!';
	exit();
}

if($idEdit == ""){
    $res = $pdo->query("SELECT * FROM links where nome = '$NomeLink'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    if(@count($dados) != 0){
        echo 'Link já Cadastrado no Banco de dados!';
        exit();
    }
}

if($Link !== "" && $Link !== null){
    if($Link[0] == 'h' && $Link[1] == 't' && $Link[2] == 't' && $Link[4] == 's' ){
        $Link = ltrim($Link, 'https://');
    }
    
    if($Link[0] == 'h' && $Link[1] == 't' && $Link[2] == 't' && $Link[4] == ':' ){
        $Link = ltrim($Link, 'http://');
    }
}


// ===== SCRIPTS PARA SUBIR BANNER WEB E MOBILE PARA O BANCO =====
function uploadImage($inputName, $targetDir, $defaultImage) {
    $uploadedFile = @$_FILES[$inputName];
    $imageName = preg_replace('/[ -]+/' , '-' , $uploadedFile['name']);
    $targetPath = $targetDir . $imageName;

    if (empty($uploadedFile['name'])) { return $defaultImage; }

    $imageTemp = $uploadedFile['tmp_name'];
    $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];

    if (in_array($imageExt, $allowedExtensions)) {
        move_uploaded_file($imageTemp, $targetPath);
        return $imageName;
    } else {
        echo "Extensão da imagem não permitida!";
        exit();
    }
}
// Diretórios e imagens padrão
$webBannerDir = '../../../assets/Banner_Links/Web/';
$defaultWebBanner = 'Default_Banner_Web.webp';

$mobileBannerDir = '../../../assets/Banner_Links/Mobile/';
$defaultMobileBanner = 'Default_Banner_Mobile.webp';

$webBanner = uploadImage('Banner_Web', $webBannerDir, $defaultWebBanner);
$mobileBanner = uploadImage('Banner_Mobile', $mobileBannerDir, $defaultMobileBanner);



// ===== INSERÇÃO DE DADOS NO BANCO =====
if($idEdit == ""){
    $res = $pdo->prepare("INSERT INTO links (img_Web, img_Mobile, nome, categoria, link, ativo) VALUES (:img_Web, :img_Mobile, :nome, :categoria, :link, :ativo)");
    $res->bindValue(":img_Web", $webBanner);
    $res->bindValue(":img_Mobile", $mobileBanner);
}
else{
    if($webBanner === "Default_Banner_Web.webp" && $mobileBanner === "Default_Banner_Mobile.webp"){
        $res = $pdo->prepare("UPDATE links SET nome = :nome, categoria = :categoria, link = :link, ativo = :ativo WHERE id = :id");
    }
    else if($webBanner !== "Default_Banner_Web.webp" && $mobileBanner === "Default_Banner_Mobile.webp"){
        $res = $pdo->prepare("UPDATE links SET img_Web = :img_Web, nome = :nome, categoria = :categoria, link = :link, ativo = :ativo WHERE id = :id");
        $res->bindValue(":img_Web", $webBanner);
    }
    else if($webBanner === "Default_Banner_Web.webp" && $mobileBanner !== "Default_Banner_Mobile.webp"){
        $res = $pdo->prepare("UPDATE links SET img_Mobile = :img_Mobile, nome = :nome, categoria = :categoria, link = :link, ativo = :ativo WHERE id = :id");
        $res->bindValue(":img_Mobile", $mobileBanner);
    }
    else if($webBanner !== "Default_Banner_Web.webp" && $mobileBanner !== "Default_Banner_Mobile.webp"){
        $res = $pdo->prepare("UPDATE links SET img_Web = :img_Web, img_Mobile = :img_Mobile, nome = :nome, categoria = :categoria, link = :link, ativo = :ativo WHERE id = :id");
        $res->bindValue(":img_Web", $webBanner);
        $res->bindValue(":img_Mobile", $mobileBanner);
    }

    $res->bindValue(":id", $idEdit);
}

$res->bindValue(":categoria", $CategoriaLink);
$res->bindValue(":nome", $NomeLink);
$res->bindValue(":link", $Link);
$res->bindValue(":ativo", $LinkAtivo);
$res->execute();


if($idEdit == ""){
    echo 'Link adicionado com Sucesso!!';
}
else{
    echo 'Link atualizado com Sucesso!!';
}
    

?>