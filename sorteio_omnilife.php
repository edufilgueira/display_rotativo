<?php 
include('config.php');
$userid = $_GET['userid'];
$nome = $_GET['nome'];
$whatsapp = $_GET['whatsapp'];
$aniversario= $_GET['aniversario'];


  $query = "INSERT INTO `tb_omnilife_omn`(`userid`,`nome`, `whatsapp`, `aniversario`) VALUES (:userid,:nome,:whatsapp,:aniversario)";
 
  $statement = $conn->prepare($query);
  $statement->bindValue(":userid",$userid);
  $statement->bindValue(":nome",$nome);
  $statement->bindValue(":whatsapp",$whatsapp);
  $statement->bindValue(":aniversario",$aniversario);
  $ok = $statement->execute();


$codigo = $conn->lastInsertId();

if($ok) 
echo'
{
 "messages": [

 ],
 "redirect_to_blocks": ["cadastro OK"]
}';
else
echo'
{
 "messages": [
   {"text": "Ocorreu um Erro. Tente mais tarde"}
 ]
}';
?>
