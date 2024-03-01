<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_prod_stats = $_POST['id_prod_stats'];
    $status_prod = $_POST['status_prod'];
    $status_date_criacao_prod = $_POST['status_date_criacao_prod'];
    $status_date_atual_prod = $_POST['status_date_atual_prod'];


    if($status_date_criacao_prod == "" && $status_date_atual_prod == ""){
        $data_criacao = date('d/m/Y');
        $data_atual = "";
    }
    if($status_date_criacao_prod !== "" && $status_date_atual_prod == ""){
        $data_criacao = $status_date_criacao_prod;
        $data_atual = date('d/m/Y');
    }
    if($status_date_criacao_prod !== "" && $status_date_atual_prod !== ""){
        $data_criacao = $status_date_criacao_prod;
        $data_atual = date('d/m/Y');
    }


    if($status_prod == "" || $status_prod == null){
        $status_prod = 'ativo';
    } 
    if($status_prod === "ativo"){
        $status_prod = 'inativo';
    }else{
        $status_prod = 'ativo';
    }


    // ===== INSERÇÃO DE DADOS NO BANCO =====
    $res = $pdo->prepare("UPDATE produtos SET data_criacao = :data_criacao, data_atual = :data_atual, status_prod = :status_prod WHERE id = :id");
        
    $res->bindValue(":id", $id_prod_stats);
    $res->bindValue(":data_criacao", $data_criacao);
    $res->bindValue(":data_atual", $data_atual);
    $res->bindValue(":status_prod", $status_prod);
    $res->execute();
    
    echo 'Status atualizado com sucesso!!';
?>