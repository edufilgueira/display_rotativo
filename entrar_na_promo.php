<?php
include('config.php');
include('funcoes.php');
include('respostas.php');

//Carregar variaveis via GET
$fbuser = $_GET['userid'];

$first_name = $_GET['first_name'];
$name_promo = $_GET['name_promo'];
$validade_limite = $_GET['validade_limite'];
$prazo_resgate = $_GET['prazo_resgate'];
$max_resgate_por_dia = $_GET['max_resgate_por_dia'];
$data_ini = date('d/m/Y'); 
//$data_fim = date('d/m/Y', strtotime("+".$prazo_resgate." days",strtotime($data_ini))); 
$data_fim = date('d/m/Y', strtotime("+".$prazo_resgate." days"));


//Cariar JSON da promoção
$json = '{
	"'.$fbuser.'": {
		"first-name": "'.$first_name.'",
		"promos": {
			"'.$name_promo.'": {
				"validade-limite": "'.$validade_limite.'",
				"data-ini": "'.$data_ini.'",
				"data-fim": "'.$data_fim.'",
				"max-resgate-por-dia": '.$max_resgate_por_dia.',
				"datas-resgates": [],
				"total-resgate-ticket": 0
			}
		}
	}
}';	


if(!controle_existe($fbuser))
{
	if(adicionar_controle($fbuser, $json))
		echo adicionar_controle_fb($fbuser, $name_promo, $data_fim, $prazo_resgate, $max_resgate_por_dia);
	else
		echo $erro_adicionar_controle_fb;
}
else
	echo $controle_fb_ja_existente;


?>