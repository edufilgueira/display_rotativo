<?php

//===============ENTRAR NA PROMOÇÃO===============
function adicionar_controle_fb($fbuser, $name_promo, $data_fim, $prazo_resgate, $max_resgate_por_dia)
{
$preecheu_pesquisa = null ;
if(!pesquisa_existe($fbuser))
	$preecheu_pesquisa = "4. Responda o questionário";

$tmp = '{
	      "attachment": {
	        "type": "image",
	        "payload": {
	          "url": "http://veicula.com.br/emporiodobolo/imagens/'.remover_acentos($name_promo).'/'.remover_acentos($name_promo).'_retangula.jpg"
	        }
	      }
	   },
	   {"text": "Parabéns {{first name}}! Você entrou na promoção '.$name_promo.'. Agora é só retirar seu benefício na loja participante. Você tem '.$prazo_resgate.' dia(s) para usar sua promoção."}';

$tmp .= ', {"text": "INSTRUÇÕES:\n1. Ticket valido até '.$data_fim.'\n2. Use '.$max_resgate_por_dia.' vez(es) por dia\n3. Leve seu celular e valide no atendimento da loja do Quintino Cunha\n'.$preecheu_pesquisa.'\n"}';
$tmp .= ', {"text": "Ótimo, agora basta que você vá até a loja participante (Quintino Cunha) e informe ao atendente que esta participando. Lembre-se de levar seu celular para validar a promoção.\nATENÇÃO: Não valide seu ticket fora da loja para não perder o benefício."}';


if (!$preecheu_pesquisa == null)
	$tmp .= ', {
	      "attachment": {
	        "type": "template",
	        "payload": {
	          "template_type": "button",
	          "text": "É necessário preencher um curto questionário. Você pode fazer isso agora ou no momento do resgate!",
	          "buttons": [
	            {
	              "type": "show_block",
	              "block_name": "questionario mensege",
	              "title": "Responder AGORA!"
	            }
	          ]
	        }
	      }
	   }';

return '{
	 "messages": ['.$tmp.']
	}';
}

$erro_adicionar_controle_fb = '{
	 "messages": [
	   {"text": "Ops! Tive algum problema aqui. Por favor tente mais tarde :("}
	 ]
	}';
	
$controle_fb_ja_existente = '{
 "messages": [
   {"text": "Você já é participante da promoção '.$name_promo.'"}
 ],
  "redirect_to_blocks": ["INFO PROMO PARTICIPA"]
}
';


//===============SOBRE A PROMOÇÃO===============
function sobre_a_promocao($name_promo, $validade_limite_dia, $max_resgate_por_dia, $validade_limite)
{
if($validade_limite_dia == 1)
  $conjugacao1 = "dia";
else if ($validade_limite_dia > 1)
  $conjugacao1 = "dias";

if($max_resgate_por_dia == 1)
  $conjugacao2 = "vez";
else if ($max_resgate_por_dia > 1)
  $conjugacao2 = "vezes";
  
$msg = '{
	 "messages": [
	 {
	      "attachment": {
	        "type": "image",
	        "payload": {
	          "url": "http://veicula.com.br/emporiodobolo/imagens/'.remover_acentos($name_promo).'/'.remover_acentos($name_promo).'_quadrada.jpg"
	        }
	      }
	   },
	   {"text": "Ok {{first name}}!!!\nVocê esta prestes a participar da promoção '.$name_promo.'\n\nCom ela você compra um bolo e com apenas R$2,00 a mais LEVA outro bolo para o seu amigo 👫.\n\nVocê pode levar sabores variados\n\nEla é válida por '.$validade_limite_dia.' '.$conjugacao1.', e você pode resgatar '.$max_resgate_por_dia.' '.$conjugacao2.' por dia na loja do Quintino Cunha.\nVocê pode aderir esta promoção até '. $validade_limite .'"},
	       {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "Quer participar da promoção?!",
          "buttons": [
            {
              "type": "show_block",
              "block_name": "Quero a promo 2X mais",
              "title": "Sim"
            },
            {
              "type": "show_block",
              "block_name": "Bolos da promo2Xmais",
              "title": "Não"
            }
          ]
        }
      }
    }
	 ]
	}';

return $msg;

}


//===============VALIDAR PROMOÇÃO===============

function validacao_exibicao_do_ticket_no_caixa($name_promo) 
{
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y H:i');
$msg = '{
 "messages": [
   {
        "attachment": {
	  "type": "image",
	    "payload": {
	      "url": "http://veicula.com.br/emporiodobolo/imagens/'.remover_acentos($name_promo).'_ticket.jpg"
	    }
	}
   },
   {"text": "Mostre o ticket para o atendete da Quintino Cunha."},
   {"text": "Data: '.$data.'"}
 ]
}';
return $msg;
}

$encaminha_para_questionario = '{
  "messages": [
    {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "Não encontrei sua pesquisa para validar seu ticket. Preencha agora a pesquisa e obtenha seu ticket promocional!",
          "buttons": [
            {
              "type": "show_block",
              "block_name": "questionario mensege",
              "title": "Responder AGORA"
            }
          ]
        }
      }
    }
  ]
}';

$quantidade_resgates_diarios_excedidos = '{
	 "messages": [
	   {"text": "Quantidade de resgates diarios excedidos"}
	 ]
	}';

function promocao_finalizada($fbuser, $name_promo){
	$datafinal = get_data_final($fbuser, $name_promo);
 return '{
	 "messages": [
	   {"text": "Esta promoção finalizou no dia '.$datafinal.'. Em breve teremos novas promoções!"}
	 ]
	}';
}

$cadastrar_na_promocao = '{
  "messages": [
    {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "Você ainda não respondeu o questionário. Deseja responder agora?",
          "buttons": [
            {
              "type": "show_block",
              "block_name": "Quero Promoção",
              "title": "SIM"
            }
          ]
        }
      }
    }
  ]
}';





?>