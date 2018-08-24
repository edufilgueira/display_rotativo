<?php 
include('config.php');
$userid = $_GET['userid'];
$nome = $_GET['nome'];
$whatsapp = $_GET['whatsapp'];
$email= $_GET['email'];
$rua = $_GET['rua'];
$bairro = $_GET['bairro'];
$tempo_de_conhecimento = $_GET['tempo_de_conhecimento'];
$frequencia_de_compra = $_GET['frequencia_de_compra'];
$qualidade_de_produtos = $_GET['qualidade_de_produtos'];
$entrega = $_GET['entrega'];
$entrega_custo = $_GET['entrega_custo'];
$satisfacao = $_GET['satisfacao'];
$avaliacao = $_GET['avaliacao'];
$nascimento = $_GET['nascimento'];

switch ($tempo_de_conhecimento){
  case 1:
    $tempo_de_conhecimento_txt= 'Esta é a primeira vez que entro na loja';
    break;
  case 2:
    $tempo_de_conhecimento_txt= 'Menos de 1 mês';
    break;
  case 3:
    $tempo_de_conhecimento_txt= '1-6 meses';
    break;
  case 4:
    $tempo_de_conhecimento_txt= '6-12 meses';
    break;
  case 5:
    $tempo_de_conhecimento_txt= '1-2 anos';
    break;
  case 6:
    $tempo_de_conhecimento_txt= '2 anos ou mais';
    break;
  default:
    $tempo_de_conhecimento_txt=$tempo_de_conhecimento;
}

switch ($frequencia_de_compra){
  case 1:
    $frequencia_de_compra_txt= 'Diariamente';
    break;
  case 2:
    $frequencia_de_compra_txt= 'Mais de 1 vez por semana';
    break;
  case 3:
    $frequencia_de_compra_txt= '1 vez por semana';
    break;
  case 4:
    $frequencia_de_compra_txt= 'Cada duas semanas';
    break;
  case 5:
    $frequencia_de_compra_txt= '1 vez por mês';
    break;
  case 6:
    $frequencia_de_compra_txt= '1 vez por ano ou mais';
    break;
  case 7:
    $frequencia_de_compra_txt= 'Menos de 1 vez por ano';
    break;
  default:
    $frequencia_de_compra_txt=$frequencia_de_compra;
}

switch ($qualidade_de_produtos){
  case 1:
    $qualidade_de_produtos_txt= 'Muito pior';
    break;
  case 2:
    $qualidade_de_produtos_txt= 'Pior';
    break;
  case 3:
    $qualidade_de_produtos_txt= 'Quase igual';
    break;
  case 4:
    $qualidade_de_produtos_txt= 'Melhor';
    break;
  case 5:
    $qualidade_de_produtos_txt= 'Muito melhor';
    break;
  default:
    $qualidade_de_produtos_txt=$qualidade_de_produtos;
}

switch ($entrega){
  case 1:
    $entrega_txt= 'Sim';
    break;
  case 2:
    $entrega_txt= 'Não';
    break;
  default:
    $entrega_txt=$entrega;
}

switch ($entrega_custo){
  case 1:
    $entrega_custo_txt= 'R$ 0,00';
    break;
  case 2:
    $entrega_custo_txt= 'R$ 1,00';
    break;
  case 3:
    $entrega_custo_txt= 'R$ 2,00';
    break;
  case 4:
    $entrega_custo_txt= 'R$ 3,00';
    break;
  case 5:
    $entrega_custo_txt= 'R$ 4,00';
    break;
  default:
    $entrega_custo_txt=$entrega_custo;
}

switch ($satisfacao){
  case 1:
    $satisfacao_txt= 'Muito satisfeito';
    break;
  case 2:
    $satisfacao_txt= 'Satisfeito';
    break;
  case 3:
    $satisfacao_txt= 'Insatisfeito';
    break;
  case 4:
    $satisfacao_txt= 'Muito insatisfeito';
    break;
  default:
    $satisfacao_txt=$satisfacao;
}

switch ($avaliacao){
  case 1:
    $avaliacao_txt= 'Discordo completamente';
    break;
  case 2:
    $avaliacao_txt= 'Discordo parcialmente';
    break;
  case 3:
    $avaliacao_txt= 'Não concordo nem discordo';
    break;
  case 4:
    $avaliacao_txt= 'Concordo parcialmente';
    break;
  case 5:
    $avaliacao_txt= 'Concordo completamente';
    break;
  default:
    $avaliacao_txt=$avaliacao;
}

  $query = "INSERT INTO `tb_pesquisa_emporio_google_peg`(`userid`,`nome`, `whatsapp`, `email`, `rua`, `bairro`, `tempo_de_conhecimento`, `frequencia_de_compra`, `qualidade_de_produtos`, `entrega`, `entrega_custo`, `satisfacao`, `avaliacao`, `data`, `data_cad`, `nascimento`) VALUES (:userid,:nome,:whatsapp,:email,:rua,:bairro,:tempo_de_conhecimento,:frequencia_de_compra,:qualidade_de_produtos,:entrega,:entrega_custo,:satisfacao,:avaliacao,:data,:data_cad,:nascimento)";
 
  $statement = $conn->prepare($query);
  $statement->bindValue(":userid",$userid);
  $statement->bindValue(":nome",$nome);
  $statement->bindValue(":whatsapp",$whatsapp);
  $statement->bindValue(":email",$email);
  $statement->bindValue(":rua",$rua);
  $statement->bindValue(":bairro",$bairro);
  $statement->bindValue(":tempo_de_conhecimento",$tempo_de_conhecimento_txt);
  $statement->bindValue(":frequencia_de_compra",$frequencia_de_compra_txt);
  $statement->bindValue(":qualidade_de_produtos",$qualidade_de_produtos_txt);
  $statement->bindValue(":entrega",$entrega_txt);
  $statement->bindValue(":entrega_custo",$entrega_custo_txt);
  $statement->bindValue(":satisfacao",$satisfacao_txt);
  $statement->bindValue(":avaliacao",$avaliacao_txt);
  $statement->bindValue(":data",date('Y-m-d H:i'));
  $statement->bindValue(":data_cad", date('Y-m-d H:i'));
  $statement->bindValue(":nascimento",$nascimento);
  $ok = $statement->execute();


$codigo = $conn->lastInsertId();

if($ok) 
echo'
{
 "messages": [
   {"text": "Obrigado por participar de nossa pesquisa!"}
 ],
 "redirect_to_blocks": ["INFO PROMO PARTICIPA"]
}';
else
echo'
{
 "messages": [
   {"text": "Ocorreu um Erro ao preencher a pesquisa"}
 ]
}';
?>
