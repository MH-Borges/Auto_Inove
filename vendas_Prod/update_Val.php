<?php
@session_start();
require_once("../sistema/configs/conexao.php");

$id = $_POST['id_prod'];
$quantidade = $_POST["quant_prod"];

$res = $pdo->query("SELECT * FROM produtos where id = '$id'"); 
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

$estoque = $dados[0]['estoque'];
$vendas = $dados[0]['Vendas'];
$nome = $dados[0]['nome'];
$data = date('d/m/Y');

if($estoque === '5'){
    $acao = 'estoqueBaixo';
    $mensagem = 'O produto '.$nome.' está com 5 itens no estoque!';

    $to = "contato@autoinove.com.br";
    $subject = "Teste de email";
    $body = ("ALerta!! -- Mensagem: $mensagem  Data: $data");
    $header = "From:contato@autoinove.com.br"."\r\n"."X=Mailer:PHP/".phpversion();
    mail($to,$subject,$body,$header);

    $res = $pdo->prepare("INSERT INTO notificacoes (acao, mensagem, data_) VALUES (:acao, :mensagem, :data_)");
    $res->bindValue(":acao", $acao);
    $res->bindValue(":mensagem", $mensagem);
    $res->bindValue(":data_", $data);
    $res->execute();
}
    
if($estoque !== 0){
    $estoque = $estoque - $quantidade;
}
$vendas = $vendas + $quantidade;

$res = $pdo->prepare("UPDATE produtos SET estoque = :estoque, Vendas = :Vendas, data_venda = :data_venda WHERE id = :id");
$res->bindValue(":estoque", $estoque);
$res->bindValue(":Vendas", $vendas);
$res->bindValue(":data_venda", $data);

$res->bindValue(":id", $id);
$res->execute();

echo 'Atualizado com sucesso!'

?>