<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_categ_stats = $_POST['id_categ_stats'];
    $status_categ_stats = $_POST['status_categ_stats'];
    $date_criacao_categ_stats = $_POST['date_criacao_categ_stats'];
    $date_atual_categ_stats = $_POST['date_atual_categ_stats'];


    if($date_criacao_categ_stats == "" && $date_atual_categ_stats == ""){
        $data_criacao = date('d/m/Y');
        $data_atual = "";
    }
    if($date_criacao_categ_stats !== "" && $date_atual_categ_stats == ""){
        $data_criacao = $date_criacao_categ_stats;
        $data_atual = date('d/m/Y');
    }
    if($date_criacao_categ_stats !== "" && $date_atual_categ_stats !== ""){
        $data_criacao = $date_criacao_categ_stats;
        $data_atual = date('d/m/Y');
    }


    if($status_categ_stats == "" || $status_categ_stats == null){
        $status_categ_stats = 'ativo';
    } 
    if($status_categ_stats == "ativo"){
        $status_categ_stats = 'desativado';
    }else{
        $status_categ_stats = 'ativo';
    }


    // ===== INSERÇÃO DE DADOS NO BANCO =====
    $res = $pdo->prepare("UPDATE categorias SET data_criacao = :data_criacao, data_atual = :data_atual, status_categ = :status_categ WHERE id = :id");
        
    $res->bindValue(":id", $id_categ_stats);
    $res->bindValue(":data_criacao", $data_criacao);
    $res->bindValue(":data_atual", $data_atual);
    $res->bindValue(":status_categ", $status_categ_stats);
    $res->execute();
    
    echo 'Status atualizado com sucesso!!';
?>