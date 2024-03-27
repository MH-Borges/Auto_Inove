<?php
@session_start();
require_once("../sistema/configs/conexao.php");

$res = $pdo->query("SELECT * FROM produtos where status_prod = 'ativo'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

for ($i=1; $i < count($dados)+1; $i++) {
    $idChamada = 'id_prod_'.$i;
    $QuantChamada = 'quant_prod_'.$i;

    $id = @$_POST[$idChamada];
    $quantidade = @$_POST[$QuantChamada];

    if($id === NULL || $quantidade === NULL){
        exit();
    }

    $res2 = $pdo->query("SELECT * FROM produtos"); 
    $dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
    for ($k=0; $k < count($dados2); $k++) {
        $id_prod = $dados2[$k]['id'];

        if($id === $id_prod){
            $estoque = $dados2[$k]['estoque'];
            $vendas = $dados2[$k]['Vendas'];
            $nome = $dados2[$k]['nome'];
            $data = date('d/m/Y');

            if($estoque !== 0){
                $estoque = $estoque - $quantidade;
            }
            $vendas = $vendas + $quantidade;

            if($estoque === 5){
                $mensagem = 'O produto '.$nome.' está com 5 itens no estoque!';

                $res = $pdo->prepare("INSERT INTO notificacoes (acao, mensagem, data_, status_notif) VALUES (:acao, :mensagem, :data_, :status_notif)");
                $res->bindValue(":acao", 'estoque_baixo');
                $res->bindValue(":mensagem", $mensagem);
                $res->bindValue(":data_", $data);
                $res->bindValue(":status_notif", 'ativa');
                $res->execute();
            
                $to = "contato@autoinove.com.br";
                $subject = "Email de alerta!! - Loja Auto Inove";
                $body = ("ALerta!! -- Mensagem: $mensagem  Data: $data");
                $header = "From:contato@autoinove.com.br"."\r\n"."X=Mailer:PHP/".phpversion();
                mail($to,$subject,$body,$header);
            }

            if($estoque === 3 || $estoque === 2 || $estoque === 1){
                $mensagem = 'O produto '.$nome.' está com '.$estoque.' itens no estoque!';
                
                $res = $pdo->prepare("INSERT INTO notificacoes (acao, mensagem, data_, status_notif) VALUES (:acao, :mensagem, :data_, :status_notif)");
                $res->bindValue(":acao", 'estoque_baixo');
                $res->bindValue(":mensagem", $mensagem);
                $res->bindValue(":data_", $data);
                $res->bindValue(":status_notif", 'ativa');
                $res->execute();
            }

            if($estoque === 0){
                $res2 = $pdo->prepare("UPDATE produtos SET status_prod = :status_prod WHERE nome = :nome");
                $res2->bindValue(":status_prod", 'sem_estoque');
                $res2->bindValue(":nome", $nome);
                $res2->execute();

                $mensagem = 'O produto '.$nome.' ficou sem estoque!';
            
                $to = "contato@autoinove.com.br";
                $subject = "Email de alerta!! - Loja Auto Inove";
                $body = ("ALerta!! -- Mensagem: $mensagem  Data: $data");
                $header = "From:contato@autoinove.com.br"."\r\n"."X=Mailer:PHP/".phpversion();
                mail($to,$subject,$body,$header);
            
                $res = $pdo->prepare("INSERT INTO notificacoes (acao, mensagem, data_, status_notif) VALUES (:acao, :mensagem, :data_, :status_notif)");
                $res->bindValue(":acao", 'sem_estoque');
                $res->bindValue(":mensagem", $mensagem);
                $res->bindValue(":data_", $data);
                $res->bindValue(":status_notif", 'ativa');
            
                $res->execute();
            }

            $mensagem = 'O produto '.$nome.' teve seu processo de finalização de compra iniciado!';
            $res = $pdo->prepare("INSERT INTO notificacoes (acao, mensagem, data_, status_notif) VALUES (:acao, :mensagem, :data_, :status_notif)");
            $res->bindValue(":acao", 'final_compra');
            $res->bindValue(":mensagem", $mensagem);
            $res->bindValue(":data_", $data);
            $res->bindValue(":status_notif", 'ativa');
            $res->execute();

            $res = $pdo->prepare("UPDATE produtos SET estoque = :estoque, Vendas = :Vendas, data_venda = :data_venda WHERE id = :id");
            $res->bindValue(":estoque", $estoque);
            $res->bindValue(":Vendas", $vendas);
            $res->bindValue(":data_venda", $data);
            
            $res->bindValue(":id", $id_prod);
            $res->execute();
        }
    }
}

?>