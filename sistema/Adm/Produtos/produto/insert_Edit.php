<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    

    $nome = $_POST['nome_Produto'];


    

    // ===== SCRIPTS PARA SUBIR BANNER WEB E MOBILE PARA O BANCO =====
    function uploadImage($inputName, $targetDir, $defaultImage) {
        $uploadedFile = @$_FILES[$inputName];
        $imageName = preg_replace('/[ -]+/' , '-' , $uploadedFile['name']);
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
    $img_categ_Diret = '../../../../assets/produtos/';
    $default_img_categ = 'placeholder.jpg';

    $img_categ = uploadImage('img_Produto_Input', $img_categ_Diret, $default_img_categ);

    
    // ===== VERIFICAÇÃO DE INPUTS VAZIOS + VERIFICAÇÃO DE POSSIVEIS ERROS =====
    


    //ATUALIZAÇÕES DE VARIAVEIS
    if($date_criacao_categ_edit == "" && $date_atual_categ_edit == ""){
        $data_criacao = date('d/m/Y');
        $data_atual = "";
    }
    if($date_criacao_categ_edit !== "" && $date_atual_categ_edit == ""){
        $data_criacao = $date_criacao_categ_edit;
        $data_atual = date('d/m/Y');
    }
    if($date_criacao_categ_edit !== "" && $date_atual_categ_edit !== ""){
        $data_criacao = $date_criacao_categ_edit;
        $data_atual = date('d/m/Y');
    }
    
    if($status_categ_edit == "" || $status_categ_edit == null || $status_categ_edit == "ativo"){
        $status_categ_edit = 'ativo';
    }else{
        $status_categ_edit = 'desativado';
    }


    // ===== INSERÇÃO DE DADOS NO BANCO =====
    if($nome_categ != $nome_categ_edit){
        $query = $pdo->query("SELECT * FROM sub_categorias WHERE categ_Atrelada = '$nome_categ_edit'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($dados); $i++) { 
            $id_subcateg = $dados[$i]['id'];

            $res2 = $pdo->prepare("UPDATE sub_categorias SET categ_Atrelada = :categ_Atrelada WHERE id = :id");
            $res2->bindValue(":categ_Atrelada", $nome_categ);
            $res2->bindValue(":id", $id_subcateg);
            $res2->execute();
        }
    }
    if($id_categ_edit == ""){
        $res = $pdo->prepare("INSERT INTO categorias (img, nome, data_criacao, data_atual, status_categ) VALUES (:img, :nome, :data_criacao, :data_atual, :status_categ)");
        $res->bindValue(":img", $img_categ);
    }
    else{
        if($img_categ === "placeholder.svg"){
            $res = $pdo->prepare("UPDATE categorias SET nome = :nome, data_criacao = :data_criacao, data_atual = :data_atual, status_categ = :status_categ WHERE id = :id");
        }
        else if($img_categ !== "placeholder.svg"){
            $res = $pdo->prepare("UPDATE categorias SET img = :img, nome = :nome, data_criacao = :data_criacao, data_atual = :data_atual, status_categ = :status_categ WHERE id = :id");
            $res->bindValue(":img", $img_categ);
        }
        $res->bindValue(":id", $id_categ_edit);
    }

    $res->bindValue(":nome", $nome_categ);
    $res->bindValue(":data_criacao", $data_criacao);
    $res->bindValue(":data_atual", $data_atual);
    $res->bindValue(":status_categ", $status_categ_edit);
    $res->execute();

    if($id_categ_edit == ""){
        echo 'Categoria adicionada com Sucesso!!';
    }
    else{
        echo 'Categoria Atualizada com Sucesso!!';
    }
?>