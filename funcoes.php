<?php 

include('config.php');


function carrega_controle_json($fbuser)
{
 global $conn;
  $data = $conn->query("SELECT * FROM tb_controle_fbuser_cfb WHERE fbuser=" . $conn->quote($fbuser)." LIMIT 1");

  $ok = $data->execute(); 
  $row = $data->fetch();
  $json=json_decode($row["value"]);
  return $json;
}


function atualiza_controle_json($fbuser, $json)
{
  global $conn;
  $json_text = json_encode($json);
 
  $data = $conn->query("UPDATE `tb_controle_fbuser_cfb` SET `value` = '".$json_text."' WHERE `fbuser` = '".$fbuser."'");
  $ok = $data->execute(); 
  return $ok;
}


function pesquisa_existe($fbuser){
  global $conn;
  $data = $conn->query("SELECT * FROM tb_pesquisa_emporio_google_peg WHERE userid=" . $conn->quote($fbuser)." LIMIT 1");

  $ok = $data->execute(); 
  $row = $data->fetch();
  if($row == false)
    return false;
  else
    return true;
}

function adicionar_controle($fbuser, $json){
  global $conn;
  $query = "INSERT INTO `tb_controle_fbuser_cfb`(`fbuser`, `value`) VALUES (:fbuser,:value)";
  $statement = $conn->prepare($query);
  $statement->bindValue(":fbuser",$fbuser);
  $statement->bindValue(":value",$json);
  $ok = $statement->execute();
  return $ok;
}


function adicionar_display($fbuser, $nome, $url){
  global $conn;
  $query = "INSERT INTO `tb_display_dis` (`fbuser`, `nome`, `url`) VALUES (:fbuser,:nome,:url)";
  $statement = $conn->prepare($query);
  $statement->bindValue(":fbuser",$fbuser);
  $statement->bindValue(":nome",$nome);
  $statement->bindValue(":url",$url);
  $ok = $statement->execute();
  return $ok;
}

function listar_display(){
  global $conn;
  $data = $conn->query("SELECT * FROM tb_display_dis order by id desc LIMIT 7");
  $resultado = $data ->fetchAll(PDO::FETCH_ASSOC);
  $json = json_encode($resultado);
  return $json;
}


function controle_existe($fbuser)
{
  global $conn;
  $data = $conn->query("SELECT * FROM `tb_controle_fbuser_cfb` WHERE fbuser=" . $conn->quote($fbuser)." LIMIT 1");

  $ok = $data->execute(); 
  $row = $data->fetch();
  if($row == false)
    return false;
  else
    return true;
}

function promocao_cadastrada($fbuser,$name_promo){
  $json = carrega_controle_json($fbuser);
  if( isset( $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""} ) )
    return true;
  else
    return false;
  
}

//Resgata Promoção. Não valida quantidades!
function resgatar_promocao($fbuser,$name_promo, $hoje = null){

  date_default_timezone_set('America/Sao_Paulo');
  $json = carrega_controle_json($fbuser);
  if($hoje==null) $hoje = Date('d/m/Y');
  
  //incrementar o resgate
  //atualizar o json e persistir
  
  $total_resgate_ticket = $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"total-resgate-ticket"};
  $total_resgate_ticket++;
  $datas_resgates = $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"datas-resgates"};
  // [{"data": "10/10/2017","resgates":0}]
  $data_hash = end($datas_resgates);
  if(isset($data_hash))
      {
	      $data = $data_hash->{"data"};
	      $resgates = $data_hash->{"resgates"};
	      
	      //verifica se a data gravada é hoje
	      if($data==$hoje)
	      {
	        $resgates++;
	        //atualiza o json
	        $i = count($datas_resgates)-1;
	        $datas_resgates[$i] = array('data' => $data, 'resgates' => $resgates);
	        $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"datas-resgates"} = $datas_resgates;
	        $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"total-resgate-ticket"} = $total_resgate_ticket;
	      }
	      else
	      { // retira o primeiro resgate desta data
	        $data = $hoje;
	        $resgates = 1;
	        // cria o registro no json
	        $resgate_hash = array('data' => $data, 'resgates' => $resgates);
	        array_push($json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"datas-resgates"}, $resgate_hash);
	        $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"total-resgate-ticket"} = $total_resgate_ticket;
	      }
      }
      else
      { // Cria a primeira data de resgate no json
       		$data = $hoje;
	        $resgates = 1;
	        $resgate_hash = '[{"data":'.$data.',"resgates":'.$resgates.'}]';
	        $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"datas-resgates"} = $resgate_hash;
	        $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"total-resgate-ticket"} = $total_resgate_ticket;
      }

  return atualiza_controle_json($fbuser, $json);

}

//Quantidade diaria de resgate disponivel
function qtd_diaria_promo_disponivel($fbuser, $name_promo, $hoje = null)
{
if($hoje==null) $hoje = Date('d/m/Y');
$json = carrega_controle_json($fbuser);
// [{"data": "10/10/2017","resgates":0}]
  if(isset($json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"datas-resgates"}))
    {
      $max_resgate_por_dia = $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"max-resgate-por-dia"};
      $datas_resgates = $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"datas-resgates"};
      $data_hash = end($datas_resgates);
      if(isset($data_hash))
      {
	      $data = $data_hash->{"data"};
	      $resgates = $data_hash->{"resgates"};
	      
	      //verifica se a data gravada é hoje
	      if($data==$hoje)
	      {
	        return $max_resgate_por_dia - $resgates;
	      }
	      else
	      {
	      //Se a data gravada não é hoje entao ele pode levar a qtd max do dia
	        return $max_resgate_por_dia;
	      }
      }
      else
      {
       		return 0;
      }
      
    }
  else
    {
      return 0;
    }
   
}

//Verifica se esta dentro do prazo
function esta_dentro_do_prazo($fbuser, $name_promo)
{
  $json = carrega_controle_json($fbuser);
  $data_fim = $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"data-fim"};
  $hoje = Date('d/m/Y');

  if(strtotime($hoje)<=strtotime($data_fim))
    return true;
  else
    return false;
}

function get_data_final($fbuser, $name_promo)
{
  $json = carrega_controle_json($fbuser);
  $data_fim = $json->{"".$fbuser.""}->{"promos"}->{"".$name_promo.""}->{"data-fim"};
  return $data_fim;
}

//Verifica se pode resgatar
function pode_resgatar()
{
  return true;
}

function strtodata($strdata)
{
  $strdata = str_replace('/', '-', $strdata);
  if (($data = date('d-m-Y', strtotime($strdata))) === false) {
    return false;
  } else {
    return str_replace('-', '/', $data);
  }
}

function remover_acentos($string){
    return preg_replace(array("/ç/","/Ç/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c C a A e E i I o O u U n N"),$string);
}


?>
