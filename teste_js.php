<?php
include ('funcoes.php');
$json = '{
	"1710031955698188": {
		"first-name": "",
		"promos": {
			"Promocao2Xmais": {
				"validade-limite": "10/10/2017",
				"data-ini": "25/08/2017",
				"data-fim": "28/08/2017",
				"max-resgate-por-dia": 1,
				"datas-resgates": [""],
				"total-resgate-ticket": 0
			}
		}
	}
}}';




//var_dump(json_decode($json, true));
//print_r(json_decode($json, true));
$aa = json_decode($json);
 print_r($aa->{'555536555'}->{"promos"}->{"promo2xMais"}->{"validade-promo"});
 $aa->{'555536555'}->{"promos"}->{"promo2xMais"}->{"validade-promo"} = "18/12/2018";
 
 
 if( isset( $aa->{'555536555'}->{"promos"}->{"promo2xMais"}->{"validade-promo"} ) ){
   print_r ("\nexiste");
    print_r($aa->{'555536555'}->{"promos"}->{"promo2xMais"}->{"validade-promo"});
   } else {
   print_r ("\n nao existe");
}

 print_r(json_encode($aa));
 listar_existe();
?>