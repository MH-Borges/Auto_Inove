<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_Subcateg_edit = $_POST['id_Subcateg_edit'];
    $date_criacao_Subcateg_edit = $_POST['date_criacao_Subcateg_edit'];
    $date_atual_Subcateg_edit = $_POST['date_atual_Subcateg_edit'];

    $nome_Subcateg = $_POST['nome_Subcateg'];
    $categ_atrelada = $_POST['categ_Atreladas'];

    // ===== VERIFICAÇÃO DE INPUTS VAZIOS =====
    if($nome_Subcateg == ""){
        echo 'Preencha o campo de nome da Categoria!';
        exit();
    }

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

    if($id_Subcateg_edit == ""){
        $res = $pdo->query("SELECT * FROM sub_categorias where nome = '$nome_Subcateg'"); 
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        if(@count($dados) != 0){
            echo 'Subcategoria já cadastrada no Banco de dados!';
            exit();
        }
    }

    if($categ_atrelada == "" || $categ_atrelada == NULL || $categ_atrelada == "categ_Atrelada_null"){
        echo 'Selecione uma categoria';
        exit();
    }


    // ===== INSERÇÃO DE DADOS NO BANCO =====
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