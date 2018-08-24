<?php 
include('config.php');
include('respostas.php');


$email = $_GET['email'];
$nome = "";
    $data = $conn->query("SELECT * FROM tb_pesquisa_emporio_google_peg WHERE email=" . $conn->quote($email));
 
    foreach($data as $row) {
    $nome = $row['nome'];
    }
    
if(!empty($nome))
echo'
{
 "messages": [
   {"text": "Welcome to our store!"},
   {"text": "'.$nome.'"}
 ]
}';
else
echo $encaminha_para_questionario;

?>



