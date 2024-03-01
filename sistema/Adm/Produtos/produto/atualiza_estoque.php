<?php
    @session_start();
    require_once("../../../configs/conexao.php"); 

    $id_edit = $_POST['id_Produto_estoque'];
    $estoque = $_POST["estoque_Edit"];

    $res = $pdo->query("SELECT * FROM produtos where id != '$id_edit'"); 
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    for ($i=0; $i < count($dados); $i++) { 
        $status = $dados[$i]['status_prod'];

        if($status === 'ativo'){
            $status = 'ativo';
        }
        if($status === 'inativo'){
            $status = 'inativo';
        }
        else{
            $status = 'sem_estoque';
        }
    }

    //ATUALIZAÇÕES DE VARIAVEIS
    if($estoque <= 0){
        $status = 'sem_estoque';
    }
    else if($estoque > 0){
        if($status === 'sem_estoque' || $status === 'ativo'){
            $status = 'ativo';
        }
        else{
            $status = 'inativo';
        }
    }

    // ===== INSERÇÃO DE DADOS NO BANCO =====
    $res2 = $pdo->prepare("UPDATE produtos SET estoque = :estoque, status_prod = :status_prod WHERE id = :id");

    $res2->bindValue(":id", $id_edit);
    $res2->bindValue(":estoque", $estoque);
    $res2->bindValue(":status_prod", $status);
    
    $res2->execute();

    echo 'Estoque Atualizado com Sucesso!!';
?>