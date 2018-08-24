<?php 
include('config.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$mes = 00;
$dia = 00;
if(isset($_GET['mes']) && isset($_GET['dia']))
{
	$mes = $_GET['mes'];
	$dia = $_GET['dia'];
	
	$sql  = 'SELECT * FROM `tb_pesquisa_emporio_google_peg` WHERE MONTH(migra_nascimento) = '.$mes.' and DAY(migra_nascimento) >= '.$dia.' and year(migra_nascimento) != 1100 group by nome, email, migra_nascimento order by migra_nascimento';
	
	$statement = $conn->prepare($sql);
	$result = $statement->execute();
	$result = $statement->fetchAll();
	echo "A partir do dia ".$dia." do mes ".$mes."<hr>";
	echo "<table width='100%'>";
	echo "<tr><td>USERID</td><td>NOME</td><td>WHATSAPP</td><td>EMAIL</td><td>DATA</td></tr>";
	foreach ($result as &$row) {
		echo "<tr><td>".$row["userid"]."</td><td>".$row["nome"]."</td><td>".$row["whatsapp"]."</td><td>".$row["email"]."</td><td>".date( 'd/m/Y' , strtotime( $row["migra_nascimento"] ))."</td></tr>";
	
	}
	echo "</table>";
}
else
	echo "Escreva os parametros dia e mes";
?>

<p>Parabéns XXXX, esta é a sua semana.<br>
Que Deus ilumine sua vida, te abençoe com sabedoria e muitos anos de vida. É o que desejamos a você.<br>
Para comemorar esta data tão especial o Empório do Bolo quer te fazer um preço especial para esta comemoração. Queremos te oferecer uma torta que custa em média R$98 por R$70 e comemore com até 30 pessoas.<br>
Passe no Empório do Bolo no Quintino Cunha e escolha o sabor de sua preferência, informe que é seu aniversário esta semana e leve sua torta com este benefício.<br>
Parabéns para você!!!<br>
São os votos do Empório do Bolo Quintino Cunha
</p>