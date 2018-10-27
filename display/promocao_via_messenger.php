<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>KIOSK DISPLAY</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="cache-control" content="no-cache" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript"> 

var slide = 1;
var ultima_img = "";
var contar_rand_background = 0;
var max_rand_background = 1000;
var randomico = 0;
var setinterval = 0;

$(document).ready(function(){
	carregar_imagens();
})

function carregar_imagens()
{
	$.ajax({
	url : 'listar_display.php',
	type : 'json',
	success: function(data){            
		var obj = JSON.parse(data);   
		if(ultima_img != obj[0]['url'])
		{
			mostra_div_principal();
			$("#img_principal").css('background-image', 'url('+obj[0]['url']+')');
			$("#img_principal").fadeOut(1);
			$("#img_principal").fadeIn(1000);
			$('#txt_principal').html(obj[0]['nome']); 
			$("#imagem1").css('background-image', 'url('+obj[1]['url']+')');
			$("#imagem1").fadeOut(450);
			$("#imagem1").fadeIn();
			$('#txt1').html(obj[1]['nome']);  
			$("#imagem2").css('background-image', 'url('+obj[2]['url']+')');
			$("#imagem2").fadeOut(250);
			$("#imagem2").fadeIn();
			$('#txt2').html(obj[2]['nome']);
			$("#imagem3").css('background-image', 'url('+obj[3]['url']+')');
			$("#imagem3").fadeOut(300);
			$("#imagem3").fadeIn();
			$('#txt3').html(obj[3]['nome']);
			$("#imagem4").css('background-image', 'url('+obj[4]['url']+')');
			$("#imagem4").fadeOut(285);
			$("#imagem4").fadeIn();
			$('#txt4').html(obj[4]['nome']);
			$("#imagem5").css('background-image', 'url('+obj[5]['url']+')');
			$("#imagem5").fadeOut(350);
			$("#imagem5").fadeIn();
			$('#txt5').html(obj[5]['nome']);
			$("#imagem6").css('background-image', 'url('+obj[6]['url']+')');
			$("#imagem6").fadeOut(540);
			$("#imagem6").fadeIn();
			$('#txt6').html(obj[6]['nome']);
			ultima_img = obj[0]['url'];
		}
	}
	});
}

function add_slide(){
	slide = slide + 1;
	if(slide > 4)
		slide = 2;
}

//Intervalo para atualizar as passagens promocionais

	switch (slide) {
	        case 1:
	            setinterval = 10000;
	            break;
	        case 2:
	            setinterval = 10000;
	            break;
	        default:
	            setinterval = 10000;
	}

    	
setInterval(function() 
{ 

	switch (slide) {
        case 1:
            mostra_div_principal();
            break;
        case 2:
            mostra_div_promo01();
            break;
        case 3:
            mostra_div_promo02();
            break;
		case 4:
            mostra_div_promo03();
            break;
        default:
            carregar_imagens();
    	}
	add_slide();
}, setinterval);


//intervalo para atualizar as promoções validadas
setInterval(function() 
{ 
     carregar_imagens();
}, 10000);

function mostra_div_principal(){
	slide = 1;
	$("#img_facebook").fadeIn();
	fadeout_divs('img_facebook');
};
	
function mostra_div_promo01(){
	randomico = gerar_randomico();	
	$("#promo01").css('background-image', 'url(promocoes/promo01.jpg?'+randomico+')');
	$("#promo01").fadeIn();
	fadeout_divs('promo01');	
};

function mostra_div_promo02(){
	randomico = gerar_randomico();	
	$("#promo02").css('background-image', 'url(promocoes/promo02.jpg?'+randomico+')');
	$("#promo02").fadeIn();
	fadeout_divs('promo02');	
};

function mostra_div_promo03(){
	randomico = gerar_randomico();	
	$("#promo03").css('background-image', 'url(promocoes/promo03.jpg?'+randomico+')');
	$("#promo03").fadeIn();
	fadeout_divs('promo03');	
};

function fadeout_divs(promo){
	if(promo != 'img_facebook') $("#img_facebook").fadeOut();
	if(promo != 'promo01') $("#promo01").fadeOut();
	if(promo != 'promo02') $("#promo02").fadeOut();
	if(promo != 'promo03') $("#promo03").fadeOut();
	//if(promo != 'promo04') $("#promo04").fadeOut();
}

function gerar_randomico()
{
	if(contar_rand_background >= max_rand_background)
	{
		randomico = Math.random();
		contar_rand_background = 0;
	}
	if(contar_rand_background == 0)
		randomico = Math.random();
		
	contar_rand_background = contar_rand_background +1;
	
	return randomico;
}

</script>
<style>
body {margin:0; padding:0}
.container-principal {
	position:relative;
	display: block; 
	float:left; 
	border: 0px solid #0F0; 
	width: auto; 
	height: 100%; 
	margin-right:5px;
	text-align:center;
}
.img_principal {
	text-align:center;
	background-size:100% 100%;
	background-repeat:no-repeat;
}

#assinatura{
	position: absolute;
	top: 80%; 
	left: 0; 
	width: 100%; 
}
#assinatura span { 
   color: white; 
   font: bold 24px/45px Helvetica, Sans-Serif; 
   letter-spacing: -1px;  
   background: rgb(0, 0, 0); /* fallback color */
   background: rgba(0, 0, 0, 0.7);
   padding: 9px; 
   
}

.container-lateral {display: block; border: 0px solid #F00; width: 100%;}
.fotos_chamadas{display: block; float: left; margin: 5px; border: 1px solid #c9c9c9; height: calc(96%/3);}
.modura {
	display: block;
	float: left;
	margin-top: 5px;
	margin-right: 5px;
	border: 1px solid #dadada;
	border-radius:9px
}
.imagem{
	position:relative;
	text-align: center;
	margin: 4px; 
	background-size:100% 100%;
	background-repeat:no-repeat;
	border-radius:7px
}
.imagem span { 
    color: white;
    font: bold 17px/27px Helvetica, Sans-Serif;
    letter-spacing: -1px;
    /* background: rgb(0, 0, 0); */
    background: rgba(0, 0, 0, 0.5);
    text-align: center;
    padding: 4px 9px 2px 10px;
}
.promo{
	display:none;
	position:absolute
}

//html {cursor: none;}
</style>
</head>

<body>

<div id="img_facebook">
	<div class="container-principal">
		<div id="img_principal" class="img_principal"></div>
		<span id="assinatura">
			<img width="310px" src="http://veicula.com.br/emporiodobolo/imagens/Promocao2Xmais/Promocao2Xmais_retangula.jpg"><br>
			<span id="txt_principal"></span>
		</span>
	</div>
	<div class="container-lateral">
		<div class="modura">
			<div id="imagem1"class="imagem">
				<span id="txt1"></span>
			</div>
		</div>	
		<div class="modura">
			<div id="imagem2"class="imagem">
				<span id="txt2"></span>
			</div>
		</div>	
		<div class="modura">
			<div id="imagem3"class="imagem">
				<span id="txt3"></span>
			</div>
		</div>	
		<div class="modura">
			<div id="imagem4"class="imagem">
				<span id="txt4"></span>
			</div>
		</div>	
		<div class="modura">
			<div id="imagem5"class="imagem">
				<span id="txt5"></span>
			</div>
		</div>	
		<div class="modura">
			<div id="imagem6"class="imagem">
				<span id="txt6"></span>
			</div>
		</div>	
		
	</div>


</div>

<div id="promo01" class="promo"></div>
<div id="promo02" class="promo"></div>
<div id="promo03" class="promo"></div>
<div id="promo04" class="promo"></div>

<script type="text/javascript">

function ajustar_video()
{
	var winH = $(window).height();//screen.height
	var winW = $(window).width();//screen.width	
	//Definir imagem principal
	var img_principal = (winH);
	$(".img_principal").height(img_principal);
	$(".img_principal").width(img_principal);
	//Definição da modura imagens
	var tamanho_modura = (((winH -6)/3)-7);
	$(".modura").height(tamanho_modura);
	$(".modura").width(tamanho_modura);
	//definição da imagem imagens
	var tamanho_imagem = (((winH -6)/3)-15);
	$(".imagem").height(tamanho_imagem);
	$(".imagem").width(tamanho_imagem);
	sobra = ((winW - img_principal - (tamanho_modura*2))/3)-7;
	$(".container-principal").css('margin-right',sobra);
	$(".modura").css('margin-right',sobra);	
	
	//ajusta a div das promoções para ocupar tela cheia
	$(".promo").height(winH);
	$(".promo").width(winW);
}

ajustar_video();

$(function(){
    $(window).resize(function(){
		 ajustar_video();
    });
});

$("#fadeIn").click(function(){
        $("#img_principal").fadeIn();
	$("#promo01").fadeOut();
});
	
$("#fadeOut").click(function(){
	$("#img_principal").fadeOut();
	$("#promo01").fadeIn();
});

</script>

</body>
</html>