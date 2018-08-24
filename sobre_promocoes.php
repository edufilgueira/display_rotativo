<?php
include ('funcoes.php');
include ('respostas.php');

$name_promo = $_GET['name_promo'];
$validade_limite = $_GET['validade_limite'];
$max_resgate_por_dia = $_GET['max_resgate_por_dia'];
$validade_limite = $_GET['validade_limite'];
$validade_limite_dia = $_GET['validade_limite_dia'];



echo sobre_a_promocao($name_promo, $validade_limite_dia, $max_resgate_por_dia, $validade_limite);


?>