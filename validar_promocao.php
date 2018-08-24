<?php 
include('config.php');
include('respostas.php');
include('funcoes.php');

$fbuser = $_GET['fbuser'];
$name_promo = $_GET['name_promo'];
$foto_url = $_GET['foto_url'];
$first_name = $_GET['first_name'];

  //verifica se cadastrou na promocao promocao_cadastrada
  //verificar se respondeu a pesquisa pesquisa_existe($fbuser)
  //verificar se ta dentro do prazo esta_dentro_do_prazo($fbuser, $name_promo)
  //verificar Se ultrapassou a qtd diaria qtd_diaria_promo_disponivel($fbuser, $name_promo, $data = Date('d/m/Y'))
  //resgatar resgatar_promocao($fbuser,$name_promo)
  
  if(promocao_cadastrada($fbuser, $name_promo))
  {
  	if(pesquisa_existe($fbuser))
  	{
  		if(esta_dentro_do_prazo($fbuser, $name_promo))
  		{
  			if(qtd_diaria_promo_disponivel($fbuser, $name_promo))
  			{
  				if(resgatar_promocao($fbuser,$name_promo))
  				{
	  				echo validacao_exibicao_do_ticket_no_caixa($name_promo);
	  				adicionar_display($fbuser, $first_name, $foto_url);			
	  			}
	  		}
  			else
  			{
  				echo $quantidade_resgates_diarios_excedidos;
  			}
  		}
  		else
  		{
  			echo promocao_finalizada($fbuser, $name_promo);
  		}
  	}
  	else
  	{
  	 	echo $encaminha_para_questionario;
  	}
  }
  else
  {
  	echo $cadastrar_na_promocao;
  }
  
  

?>


