<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_Codigo_edit = $_POST['id_Codigo_edit'];
    $nome_Codigo_edit = $_POST['nome_Codigo_edit'];
    $date_criacao_Codigo_edit = $_POST['date_criacao_Codigo_edit'];
    $date_atual_Codigo_edit = $_POST['date_atual_Codigo_edit'];

    $nome_Codigo = $_POST['nome_Codigo'];

    // ===== VERIFICAÇÃO DE INPUTS VAZIOS + VERIFICAÇÃO DE POSSIVEIS ERROS =====
    if($nome_Codigo == ""){
        echo 'Preencha o campo de nome com o Código!';
        exit();
    }
    if($id_Codigo_edit == ""){
        $res = $pdo->query("SELECT * FROM codigos where nome = '$nome_Codigo'"); 
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        if(@count($dados) != 0){
            echo 'Código já cadastrado no Banco de dados!';
            exit();
        }
    }


    //ATUALIZAÇÕES DE VARIAVEIS
    if($date_criacao_Codigo_edit == "" && $date_atual_Codigo_edit == ""){
        $data_criacao = date('d/m/Y');
        $data_atual = "";
    }
    if($date_criacao_Codigo_edit !== "" && $date_atual_Codigo_edit == ""){
        $data_criacao = $date_criacao_Codigo_edit;
        $data_atual = date('d/m/Y');
    }
    if($date_criacao_Codigo_edit !== "" && $date_atual_Codigo_edit !== ""){
        $data_criacao = $date_criacao_Codigo_edit;
        $data_atual = date('d/m/Y');
    }

    
    // ===== INSERÇÃO DE DADOS NO BANCO =====
    if($nome_Codigo != $nome_Codigo_edit){
        $query = $pdo->query("SELECT * FROM produtos WHERE codigo = '$nome_Codigo_edit'");
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($j=0; $j < count($dados); $j++) { 
            $id_prod = $dados[$j]['id'];

            $res2 = $pdo->prepare("UPDATE produtos SET codigo = :codigo WHERE id = :id");
            $res2->bindValue(":codigo", $nome_Codigo);
            $res2->bindValue(":id", $id_prod);
            $res2->execute();
        }
    }


    if($id_Codigo_edit == ""){
        $res = $pdo->prepare("INSERT INTO codigos (nome, data_criacao, data_atual) VALUES (:nome, :data_criacao, :data_atual)");
    }
    else{
        $res = $pdo->prepare("UPDATE codigos SET nome = :nome, data_criacao = :data_criacao, data_atual = :data_atual WHERE id = :id");
        $res->bindValue(":id", $id_Codigo_edit);
    }

    $res->bindValue(":nome", $nome_Codigo);
    $res->bindValue(":data_criacao", $data_criacao);
    $res->bindValue(":data_atual", $data_atual);
    $res->execute();


    if($id_Codigo_edit == ""){
        echo 'Código adicionado com Sucesso!!';
    }
    else{
        echo 'Código Atualizado com Sucesso!!';
    }
?>