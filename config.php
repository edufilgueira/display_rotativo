<?php

$conn = new PDO('mysql:host=localhost;dbname=veicula4_emporio;charset=utf8', 'veicula4_emporio', 'v03admin%');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$conn->exec("SET NAMES utf8");


 


?>