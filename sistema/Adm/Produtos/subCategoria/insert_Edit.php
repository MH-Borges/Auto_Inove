<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_Subcateg_edit = $_POST['id_Subcateg_edit'];
    $nome_Subcateg_edit = $_POST['nome_Subcateg_edit'];
    $date_criacao_Subcateg_edit = $_POST['date_criacao_Subcateg_edit'];
    $date_atual_Subcateg_edit = $_POST['date_atual_Subcateg_edit'];

    $nome_Subcateg = $_POST['nome_Subcateg'];
    $categ_atrelada = @$_POST['categ_Atreladas'];

    // ===== VERIFICAÇÃO DE INPUTS VAZIOS + VERIFICAÇÃO DE POSSIVEIS ERROS =====
    if($nome_Subcateg == ""){
        echo 'Preencha o campo de nome da Categoria!';
        exit();
    }
    if($id_Subcateg_edit == ""){
        $res = $pdo->query("SELECT * FROM sub_categorias where nome = '$nome_Subcateg'"); 
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        if(@count($dados) != 0){
            echo 'Subcategoria já cadastrada no Banco de dados!';
            exit();
        }
    }
    if($categ_atrelada == ""){
        echo 'Selecione uma categoria para atrelar a essa Subcategoria';
        exit();
    }

    if(str_contains($nome_Subcateg, '_') || str_contains($nome_Subcateg_edit, '_')) {
        echo "O caractere '_' não pode ser utilizado";
        exit();
    }

    //ATUALIZAÇÕES DE VARIAVEIS
    if($date_criacao_Subcateg_edit == "" && $date_atual_Subcateg_edit == ""){
        $data_criacao = date('d/m/Y');
        $data_atual = "";
    }
    if($date_criacao_Subcateg_edit !== "" && $date_atual_Subcateg_edit == ""){
        $data_criacao = $date_criacao_Subcateg_edit;
        $data_atual = date('d/m/Y');
    }
    if($date_criacao_Subcateg_edit !== "" && $date_atual_Subcateg_edit !== ""){
        $data_criacao = $date_criacao_Subcateg_edit;
        $data_atual = date('d/m/Y');
    }


    // ===== INSERÇÃO DE DADOS NO BANCO =====
    if($nome_Subcateg != $nome_Subcateg_edit){
        $query = $pdo->query("SELECT * FROM produtos WHERE sub_categoria = '$nome_Subcateg_edit'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($j=0; $j < count($dados); $j++) { 
            $id_prod = $dados[$j]['id'];

            $res2 = $pdo->prepare("UPDATE produtos SET sub_categoria = :sub_categoria WHERE id = :id");
            $res2->bindValue(":sub_categoria", $nome_Subcateg);
            $res2->bindValue(":id", $id_prod);
            $res2->execute();
        }
    }

    if($id_Subcateg_edit == ""){
        $res = $pdo->prepare("INSERT INTO sub_categorias (nome, categ_Atrelada, data_criacao, data_atual) VALUES (:nome, :categ_Atrelada, :data_criacao, :data_atual)");
    }
    else{
        $res = $pdo->prepare("UPDATE sub_categorias SET nome = :nome, categ_Atrelada = :categ_Atrelada, data_criacao = :data_criacao, data_atual = :data_atual WHERE id = :id");
        $res->bindValue(":id", $id_Subcateg_edit);
    }

    $res->bindValue(":nome", $nome_Subcateg);
    $res->bindValue(":categ_Atrelada", $categ_atrelada);
    $res->bindValue(":data_criacao", $data_criacao);
    $res->bindValue(":data_atual", $data_atual);
    $res->execute();


    if($id_Subcateg_edit == ""){
        echo 'Subcategoria adicionada com Sucesso!!';
    }
    else{
        echo 'Subcategoria Atualizada com Sucesso!!';
    }
?>