<?php 
include('config.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql  = 'SELECT `id`, `nascimento` FROM `tb_pesquisa_emporio_google_peg` WHERE `migra_nascimento` is null';
//$sql  = 'SELECT * FROM tb_pesquisa_emporio_google_peg';
$statement = $conn->prepare($sql);
$result = $statement->execute();
$result = $statement->fetchAll();

foreach ($result as &$row) {
    if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $row["nascimento"]) === 0) {
    list($dd,$mm,$yyyy) = explode('/', $row["nascimento"]);
	if (!checkdate($mm,$dd,$yyyy)) {   		
   		$nova_data = "1100-10-10";
   		
   		$data = $conn->prepare("UPDATE `tb_pesquisa_emporio_google_peg` SET `migra_nascimento` = :migra_nascimento WHERE `id` = :id");
		$data->bindValue(':migra_nascimento', $nova_data);
		$data->bindValue(':id', $row["id"]);
		$data->execute();
		
		echo "id: " . $row["id"]. " - Nascimento: " . $row["nascimento"]. " DATA INVALIDA. Gravando: 1100-10-10 <br>";
   		
	}
    }
    else {
    	list($dd,$mm,$yyyy) = explode('/', $row["nascimento"]);
    	   	$nova_data = $yyyy . "-" . $mm . "-" . $dd;
   		
   		$data = $conn->prepare("UPDATE `tb_pesquisa_emporio_google_peg` SET `migra_nascimento` = :migra_nascimento WHERE `id` = :id");
		$data->bindValue(':migra_nascimento', $nova_data);
		$data->bindValue(':id', $row["id"]);
		$data->execute(); 

	    	echo "id: " . $row["id"]. " - Nascimento: " . $row["nascimento"]. " - Data Migração: " . $nova_data . "<br>";
    }
}

?>
