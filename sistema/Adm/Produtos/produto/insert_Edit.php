<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_edit = $_POST['id_produto_edit'];

    $nome = $_POST['nome_Produto'];
    $valor = $_POST['valor_Produto'];
    $descricao = $_POST["descri_Produto"];

    $categoria = $_POST["categoria_Produto"];
    @$subcategoria = $_POST["SubCategoria_Produto"];
    @$codigo = $_POST["codigo_Produto"];

    $marca = $_POST["marca_Produto"];
    $estoque = $_POST["estoque_Produto"];
    $litros = $_POST["litros_Produto"];
    $mercado_livre = $_POST["mercadoLivre_Produto"];


    @$ItemAtr1 = $_POST["ItemAtr1_Produto"];
    @$ItemAtr2 = $_POST["ItemAtr2_Produto"];
    @$ItemAtr3 = $_POST["ItemAtr3_Produto"];
    @$ItemAtr4 = $_POST["ItemAtr4_Produto"];


    $date_criacao_Produto = $_POST['date_criacao_Produto'];
    $date_atual_Produto = $_POST['date_atual_Produto'];

    $status = $_POST['status_Produto_edit'];

    // ===== SCRIPTS PARA SUBIR BANNER WEB E MOBILE PARA O BANCO =====
    function uploadImage($inputName, $targetDir, $defaultImage) {
        $uploadedFile = @$_FILES[$inputName];
        $imageName = preg_replace('/[ -]+/' , '-' , $uploadedFile['name']);
        $imageName = preg_replace('/_/' , '-' , $uploadedFile['name']);

        $targetPath = $targetDir . $imageName;

        if (empty($uploadedFile['name'])) { return $defaultImage; }

        $imageTemp = $uploadedFile['tmp_name'];
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp', 'svg'];

        if (in_array($imageExt, $allowedExtensions)) {
            move_uploaded_file($imageTemp, $targetPath);
            return $imageName;
        } else {
            echo "Extensão da imagem não permitida!";
            exit();
        }
    }
    // Diretórios e imagens padrão
    $img_prod_Diret = '../../../../assets/produtos/';
    $default_img_prod = 'placeholder.jpg';

    $img_prod = uploadImage('img_Produto_Input', $img_prod_Diret, $default_img_prod);

    
    // ===== VERIFICAÇÃO DE INPUTS VAZIOS + VERIFICAÇÃO DE POSSIVEIS ERROS =====
    if($id_edit !== ""){
        $res = $pdo->query("SELECT * FROM produtos where id != '$id_edit'"); 
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0; $i < count($dados); $i++) { 
            $nomes_prods = $dados[$i]['nome'];

            if($nome === $nomes_prods){
                echo 'Produto já cadastrado!';
                exit();
            }
        }
    }
    if($nome == ""){
        echo 'Preencha o campo de nome do produto!';
        exit();
    }
    if($valor == ""){
        echo 'Preencha o campo de valor do produto!';
        exit();
    }
    if($categoria == ""){
        echo 'Selecione uma categoria!';
        exit();
    }
    if($codigo == ""){
        echo 'Selecione um codigo para este produto!';
        exit();
    }
    if($estoque == ""){
        echo 'Insira uma quantidade no estoque!';
        exit();
    }
    if($ItemAtr1 == "" || $ItemAtr1 == null ){
        $ItemAtr1 = '';
    }
    if($ItemAtr2 == "" || $ItemAtr2 == null ){
        $ItemAtr2 = '';
    }
    if($ItemAtr3 == "" || $ItemAtr3 == null ){
        $ItemAtr3 = '';
    }
    if($ItemAtr4 == "" || $ItemAtr4 == null ){
        $ItemAtr4 = '';
    }

    if(str_contains($nome, '_')) {
        echo "O caractere '_' não pode ser utilizado";
        exit();
    }

    //ATUALIZAÇÕES DE VARIAVEIS
    if($mercado_livre !== "" && $mercado_livre !== null){
        if($mercado_livre[0] == 'h' && $mercado_livre[1] == 't' && $mercado_livre[2] == 't' && $mercado_livre[4] == 's' ){
            $mercado_livre = ltrim($mercado_livre, 'https://');
        }
        
        if($mercado_livre[0] == 'h' && $mercado_livre[1] == 't' && $mercado_livre[2] == 't' && $mercado_livre[4] == ':' ){
            $mercado_livre = ltrim($mercado_livre, 'http://');
        }
    }
    if($date_criacao_Produto == "" && $date_atual_Produto == ""){
        $data_criacao = date('d/m/Y');
        $data_atual = "";
    }
    if($date_criacao_Produto !== "" && $date_atual_Produto == ""){
        $data_criacao = $date_criacao_Produto;
        $data_atual = date('d/m/Y');
    }
    if($date_criacao_Produto !== "" && $date_atual_Produto !== ""){
        $data_criacao = $date_criacao_Produto;
        $data_atual = date('d/m/Y');
    }
    if($estoque <= 0){
        $status = 'sem_estoque';
    }
    if($estoque > 0){
        if($status === 'sem_estoque' || $status === 'ativo'){
            $status = 'ativo';
        }
        else{
            $status = 'inativo';
        }
    }

    // ===== INSERÇÃO DE DADOS NO BANCO =====
    if($id_edit === ""){
        $res = $pdo->prepare("INSERT INTO produtos (img, nome, valor, descricao, categoria, sub_categoria, codigo, marca, estoque, litros, mercado_livre, data_criacao, data_atual, status_prod, Item_Relac_1, Item_Relac_2, Item_Relac_3, Item_Relac_4) VALUES (:img, :nome, :valor, :descricao, :categoria, :sub_categoria, :codigo, :marca, :estoque, :litros, :mercado_livre, :data_criacao, :data_atual, :status_prod, :Item_Relac_1, :Item_Relac_2, :Item_Relac_3, :Item_Relac_4)");
        $res->bindValue(":img", $img_prod);
    }

    else{
        if($img_prod === "placeholder.jpg"){
            $res = $pdo->prepare("UPDATE produtos SET nome = :nome, valor = :valor, descricao = :descricao, categoria = :categoria, sub_categoria = :sub_categoria, codigo = :codigo, marca = :marca, estoque = :estoque, litros = :litros, mercado_livre = :mercado_livre, data_criacao = :data_criacao, data_atual = :data_atual, status_prod = :status_prod, Item_Relac_1 = :Item_Relac_1, Item_Relac_2 = :Item_Relac_2, Item_Relac_3 = :Item_Relac_3, Item_Relac_4 = :Item_Relac_4 WHERE id = :id");
        }
        else if($img_prod !== "placeholder.jpg"){
            $res = $pdo->prepare("UPDATE produtos SET img = :img, nome = :nome, valor = :valor, descricao = :descricao, categoria = :categoria, sub_categoria = :sub_categoria, codigo = :codigo, marca = :marca, estoque = :estoque, litros = :litros, mercado_livre = :mercado_livre, data_criacao = :data_criacao, data_atual = :data_atual, status_prod = :status_prod, Item_Relac_1 = :Item_Relac_1, Item_Relac_2 = :Item_Relac_2, Item_Relac_3 = :Item_Relac_3, Item_Relac_4 = :Item_Relac_4 WHERE id = :id");
            $res->bindValue(":img", $img_prod);
        }
        $res->bindValue(":id", $id_edit);
    }

    $res->bindValue(":nome", $nome);
    $res->bindValue(":valor", $valor);
    $res->bindValue(":descricao", $descricao);
    $res->bindValue(":categoria", $categoria);
    $res->bindValue(":sub_categoria", $subcategoria);
    $res->bindValue(":codigo", $codigo);
    $res->bindValue(":marca", $marca);
    $res->bindValue(":estoque", $estoque);
    $res->bindValue(":litros", $litros);
    $res->bindValue(":mercado_livre", $mercado_livre);
    $res->bindValue(":data_criacao", $data_criacao);
    $res->bindValue(":data_atual", $data_atual);
    $res->bindValue(":status_prod", $status);
    $res->bindValue(":Item_Relac_1", $ItemAtr1);
    $res->bindValue(":Item_Relac_2", $ItemAtr2);
    $res->bindValue(":Item_Relac_3", $ItemAtr3);
    $res->bindValue(":Item_Relac_4", $ItemAtr4);

    $res->execute();

    if($id_edit == ""){
        echo 'Produto adicionado com Sucesso!!';
    }
    else{
        echo 'Produto Atualizado com Sucesso!!';
    }
?>