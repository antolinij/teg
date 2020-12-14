<?php
	session_start();
	

require '../connect/src/facebook.php';
require_once "../database.php";

cuenta_entradas();
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '316798408348316',
  'secret' => '48fc45fa38aaf273a4390d52fee70c1a',
));

// Get User ID
$user = $facebook->getUser();

$logoutUrl = $facebook->getLogoutUrl();

$loginUrl = $facebook->getLoginUrl();

if(isset($_SESSION['rol'])){
	header("Location: juego.php");
}
    
?>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
    
	<meta name="description" content="El clásico juego de estrategia, para jugar en línea y con amigos. Totalmente gratuito.">
<meta name="keywords" content="TEG, TEGNET, RISK, Estrategia, Guerra, T.E.G., juegos de estrategia, juegos en red, juego gratis, Gratis, Freeware,tegame,tegame.com.ar">


	

    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    
        <meta property="og:title" content="tegame.com.ar" />
	<meta property="og:type" content="game" />
	<meta property="og:image" content="http://tegame.com.ar/fondos/logo_pagina.png" />
	<meta property="fb:admins" content="776454629" />	
	<meta property="og:description" content="Escoja los amigos o grupos a los que desee invitar a la partida, si quiere agregue un mensaje, y luego envielo. Tambien arriba a su izquierda tiene la url de su partida, para enviarla por otro medio" />

    <link rel="stylesheet" href="css/index.css" type="text/css" media="screen,projection,print">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
			<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
			<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
			<script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
			<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
    
    <title>TEGame.com.ar | Inicio</title>
    <script>
    $(document).ready(function() {
		$( "#tabs" ).tabs();
		$( "#accordion" ).accordion();
	});
	</script>
	
	<!-- validacion de publicidad -->
<script src="http://px.smowtion.com/validate?sid=159480" type="text/javascript"></script>	
    </head>
    <body>
    
   
    	<div id="barra_superior">
    	

                    	<div class="fb-like" data-href="http://facebook.com/tegenlinea" data-send="false" data-width="600" data-show-faces="false" data-font="arial" style="position:absolute;"></div>
	</div>
      <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=316798408348316";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
$(document).ready(function() {
//centra el cuerpo

var left =(1500-window.innerWidth)/2;
if(left < 0)
	left=0;
left+=10;
$(window).scrollLeft((1500-window.innerWidth)/2);
$('.fb-like').css('left',left+'px');
});
</script>
<html xmlns:fb="http://ogp.me/ns/fb#">
	<table  width="1490px" align="center">
    	<tr align="center">
        	<td>


<!-- ANUNCIO IZQUIERDA -->
<div id="izquierda">

<?php
/*switch(mt_rand(0,2)){
case 0:
echo '
<!-- Soicos  - tarot -->
<script type="text/javascript">
(function() {var _impid = 145412;var _pieceid = 3205;var _js = (("https:" == document.location.protocol) ? "https://" : "http://") + "soicos.com/srv.php?impid="+_impid+"&pieceid="+_pieceid+"&s=.js";document.write(unescape("%3Cscript src=\'" + _js + "\' type=\'text/javascript\'%3E%3C/script%3E"));})();
</script>';
break;
case 1:
echo '<!-- Soicos  - avisos -->
<script type="text/javascript">
(function() {var _impid = 145415;var _pieceid = 460;var _js = (("https:" == document.location.protocol) ? "https://" : "http://") + "soicos.com/srv.php?impid="+_impid+"&pieceid="+_pieceid+"&s=.js";document.write(unescape("%3Cscript src=\'" + _js + "\' type=\'text/javascript\'%3E%3C/script%3E"));})()
</script>';
break;
case 2:*/
echo'
<!-- BEGIN SMOWTION TAG - 160x600 - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "160x600";
smowtion_section = "3042671";
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js?s=3042671&z=160x600">
</script>
<!-- END SMOWTION TAG - 160x600 - DO NOT MODIFY -->';/*
break;
}
*/
?>
</div>
<!-- ANUNCIO DERECHA -->
<div id="derecha">
<?php
/*switch(mt_rand(0,2)){
case 0:
echo '
<!-- Soicos  - tarot -->
<script type="text/javascript">
(function() {var _impid = 145412;var _pieceid = 3205;var _js = (("https:" == document.location.protocol) ? "https://" : "http://") + "soicos.com/srv.php?impid="+_impid+"&pieceid="+_pieceid+"&s=.js";document.write(unescape("%3Cscript src=\'" + _js + "\' type=\'text/javascript\'%3E%3C/script%3E"));})();
</script>';
break;
case 1:
echo '<!-- Soicos  - avisos -->
<script type="text/javascript">
(function() {var _impid = 145415;var _pieceid = 460;var _js = (("https:" == document.location.protocol) ? "https://" : "http://") + "soicos.com/srv.php?impid="+_impid+"&pieceid="+_pieceid+"&s=.js";document.write(unescape("%3Cscript src=\'" + _js + "\' type=\'text/javascript\'%3E%3C/script%3E"));})()
</script>';
break;
case 2:*/
echo'
<!-- BEGIN SMOWTION TAG - 160x600 - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "160x600";
smowtion_section = "3042671";
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js?s=3042671&z=160x600">
</script>
<!-- END SMOWTION TAG - 160x600 - DO NOT MODIFY -->';/*
break;
}
*/
?></div>



            	<table align="center">
                	<tr>
                    	<td align="center">
                        	<div id="cuerpo" class="ui-corner-bottom">

                        		<a id="logo" style="position:absolute;top:15px"> TEGame.com.ar </a>
								
                        		<div id="tabs">
									<ul>
										<li><a href="#tabs-1">Comenzar a Jugar</a></li>
										<li><a href="#tabs-2">Jugabilidad</a></li>
										<li><a href="#tabs-3"><span style="color:green">Organizar Partidas</span></a></li>
									</ul>
									<div id="tabs-1" class="tabs">	
									                    	                        													 <?php
		//si el usuario tine rol, o sea ya pertenece a alguna partida, lo envía a partidas, donde puede elegir 
		//jugar una nueva o continuar la existente
	//if(isset($_SESSION['rol']))
	//	header("Location: partidas.php");
	
		//si no tiene una session como usuario y no se creo la variable usuario del connect
		//le muestra el botón de facebook connect
	if (!$user){
			 //ESTE IF ES TEMPORAL PARA QUE NO PUEDA ENTRAR CUALQUIERA
			//if($_GET['permiso']==1)
			//Boton del connect de Facebook
    	 echo'<div id="login" class="ui-corner-all" style="height:60px;font-size:14px">
    	 <h2>Se recomienda NO usar Internet Explorer</h2>
    	 <a style="font-size:18px">Haga click en el siguiente boton </a>';  
    	 echo '<a href='.$loginUrl.'><img src="fondos/facebook.gif" cursor= "pointer" ></a> <a style="font-size:18px">para comenzar a Jugar.</a><br><br><br>
    	 <a>Ingrese a nuestra</a>
    	 <a href="http://facebook.com/tegenlinea" target="_blank"><span style="color:blue">PAGINA OFICIAL<span></a>
    	 <a>Para organizar partidas y ayudarnos a mejorar la aplicacion</a><br><br>
    	
    	 
    	 <a>O ingrese a esta </a>
    	 <a href="http://facebook.com/tegonline" target="_blank"><span style="color:blue">COMUNIDAD<span></a>
    	 <a>donde encontrara otros fanáticos del T.E.G. con los que podrás organizar partidas</a>
    	 </div>';
    	 	
	}
	else{
		
		$datos_usuario = $facebook->api('/me');
		$_SESSION['usuario']=$datos_usuario['name'];
		$_SESSION['id']=$datos_usuario['id'];
		$_SESSION['url_img']= "http://graph.facebook.com/".$user."/picture";

		if(isset($_GET['id_partida']))
			$_SESSION['id_partida']=$_GET['id_partida'];
			
		if(isset($_GET['clave']))	
			$_SESSION['clave']=$_GET['clave'];
			
		if(isset($_GET['id_entrega']))	
			$_SESSION['id_entrega']=$_GET['id_entrega'];
				
	}
	if(isset($_SESSION['id']))	
		echo '<script>window.location="partidas.php";</script>';
	
?>
	<br><br><br><br><br><img src="fondos/foto_inicio.png" width="45%" style="background-color:#82C0F4;border:1px solid #000" class="ui-corner-all">
		<img src="fondos/mapa_nombres_portada.png" width="45%" style="background-color:#82C0F4;border:1px solid #000" class="ui-corner-all">
		<br><br><a style="font-size:15px">Contacto: adm.tegame@gmail.com</a>
										</div>
									<div id="tabs-2" class="tabs">
										<div id="accordion">
												<h3><a href="#">Comenzar a jugar</a></h3>
													<div class="contenedor">
													
														<!-- Iniciar sesion -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Iniciar session:</h4>
															<img src="/fondos/instrucciones/inicio/conectarse.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Estando en la pestaña comenzar a jugar haga click en el icono Connect de facebook.</p>
													</div>
														<!-- Crear partida -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Crear Partida:</h4>
															<img src="/fondos/instrucciones/inicio/crear_nueva.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Escoja la cantidad de jugadores que quiera que tenga la partida, el color que desea y luego haga click en Crear.</p>
													</div>
													<!-- Continuar existente -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Continuar Partida existente:</h4>
															<img src="/fondos/instrucciones/inicio/continuar_existente.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Si usted dejo una partida sin finalizar, y desea continuarla haga click en Reanudar partida existente.</p>
													</div>	
													<!-- Invitar jugadores -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Invitar Jugadores:</h4>
															<img src="/fondos/instrucciones/inicio/invitar_jugador.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Después de crear la partida, arriba a su izquierda, aparece la dirección que debe enviarle a los jugadores que quiere invitar.</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Puede presionar el botón derecho del mouse sobre el link y seleccionar "copiar dirección del enlace" y posteriormente pegarla en el medio por el cual desee invitar usuarios. También puede arrastrarlo directamente.</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;color:red">una forma practica es presionar el botón Enviar que esta debajo de la url de la partida(arriba a su izquierda), escojer los amigos o grupos de facebook a los que desee invitar, si quiere puede agregar un mensaje y por ultimo presione enviar.</p>
													</div>
													<!-- Unirse a una partida -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Unirme a una Partida:</h4>
															<img src="/fondos/instrucciones/inicio/elegir_color.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Si usted fue invitado a unirse a una partida, después de ingresar al link que le enviaron. Debe iniciar sesión (paso:1).</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Una vez que haya iniciado sesión escoja un color disponible. Seguido a esto presione el botón Unirse. De esta forma ingresara a la partida. Si usted ocupa el ultimo lugar libre en la partida el juego comenzara, de lo contrario comenzara cuando se ocupen todos los lugares.</p>
													</div>	
													
														
													</div>
												<h3><a href="#">Distribución Del Juego</a></h3>
													<div class="contenedor">
													
														<!-- jugadores -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Lista de Jugadores:</h4>
															<img src="/fondos/instrucciones/distribucion/jugadores.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Esta a la derecha y Muestra la lista de jugadores, y resalta el que esta en turno, si un jugador es eliminado porque se queda sin países lo deja con un color opaco para que sea distinguible. </p>
														</div>	
														<!-- info usuario -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Información del Usuario:</h4>
															<img src="/fondos/instrucciones/distribucion/info_usuario.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Al hacer click en alguno de los jugadores, se despliega toda la información que se pueda mostrar de este (cantidad de países, tarjetas, etc), para cerrarla volver a hacer click en el jugador. </p>
														</div>	
														<!-- estado turno -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Estado del Turno:</h4>
															<img src="/fondos/instrucciones/distribucion/estado_turno.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Muestra el estado en el que está el jugador en turno, también en esta botonera se avanza de fase haciendo click en el botón que corresponda a la fase a la que uno quiere ir, se encuentra abajo a la derecha. </p>
														</div>
														<!-- chat -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Chat:</h4>
															<img src="/fondos/instrucciones/distribucion/chat.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Al pasar el mouse por encima de este, se muestra el chat </p>
														</div>
														
														<!-- nombre mapa -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Nómbre Paises:</h4>
															<img src="/fondos/instrucciones/distribucion/nombres_mapa.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Al mover este se muestra con transparencia el mapa con los nombres, y el mapa con las fichas se utiliza para buscar el nombre de un país, se encuentra abajo del mapa</p>
														</div>
														<!-- gane -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Notificar Triunfo:</h4>
															<img src="/fondos/instrucciones/distribucion/gane.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Este boton es para notificar que gano, esta en Informacion del usuario (este aparece al hacer click sobre su nombre).</p>
														</div>
														<!-- salir -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Salir:</h4>
															<img src="/fondos/instrucciones/distribucion/salir.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Este boton esta en la parte superior derecha, y su fin es sacarlo de la partida.</p>
														</div>
													
													
													
													</div>
													
													
												<h3><a href="#">Incorporar Ejército</a></h3>
													<div class="contenedor">
													
														<!-- incorporacion simple -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Incorporación Simple:</h4>
															<img src="/fondos/instrucciones/incorporar/fichas_incorporar.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando esté en turno y en la fase incorporar ejércitos haciendo click sobre un país o ficha suya incorporará un ejército. Verá en la parte inferior izquierda la cantidad de fichas que dispone y su procedencia. </p>
														</div>	
														<!-- incorporacion multiple -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Incorporación Multiple:</h4>
															<img src="/fondos/instrucciones/incorporar/incorporacion_multiple.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando esté en turno y en la fase incorporar ejércitos haciendo click por lo menos 1 segundo sobre una ficha suya, se desplegará una lista, en esta usted puede elegir el numero de ejércitos que desea incorporar en ese país.</p>
														</div>	
													
													</div>
												<h3><a href="#">Atacar</a></h3>
													<div>
														<!-- seleccionar paises -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Seleccionar Paises:</h4>
															<img src="/fondos/instrucciones/atacar/seleccionar.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando esté en turno y en la fase atacar, seleccione un país suyo desde donde desee hacer el ataque y posteriormente el país al que desea atacar</p>
														</div>
														<!-- informacion de paises -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Paises Seleccionados:</h4>
															<img src="/fondos/instrucciones/atacar/de_a.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando haya seleccionado los países, abajo a la izquierda le aparecerá la información de estos.</p>
														</div>
														<!-- Atacar -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Atacar:</h4>
															<img src="/fondos/instrucciones/atacar/tirar_dados.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Una vez que tenga seleccionado el país desde el que desea atacar y el país al que desea atacar, haga click en Tirar Dado/s.</p>
														</div>
														<!-- Defensa -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Defenderse:</h4>
															<img src="/fondos/instrucciones/atacar/tirar_dados.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Después de que haya tirado los dados el usuario atacante, los debe tirar el usuario que deba defenderse.</p>
														</div>
														
													
													
													</div>
												<h3><a href="#">Reagrupar</a></h3>
													<div class="contenedor">
														<!-- seleccionar -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Seleccionar Paises:</h4>
															<img src="/fondos/instrucciones/reagrupar/seleccionar.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando esté en turno y en la fase reagrupar, seleccione un país suyo desde donde desee enviar fichas, y posteriormente el país al que desee enviarselas.</p>
														</div>
														
														<!-- enviar -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Enviar Fichas:</h4>
															<img src="/fondos/instrucciones/reagrupar/enviar.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Después de haber seleccionado los dos paises, escoja en el selector cuantas fichas desea enviar, y finalmente presione Aceptar</p>
														</div>
													</div>
												<h3><a href="#">Tarjeta</a></h3>
													<div class="contenedor">
														
														<!-- desplegar opciones -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Opciones:</h4>
															<img src="/fondos/instrucciones/tarjetas/opciones.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando esté en turno y en la fase Tarjeta, al pasar el mouse por el botón Opciones se desplegaran las acciones que puede realizar</p>
														</div>
														<!-- opciones -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Acción:</h4>
															<img src="/fondos/instrucciones/tarjetas/accion.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Al haber hecho el paso anterior aparecerán las siguientes opciones:</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;"><span style="color:red">Retirar tarjeta:</span> Esta opción le permite retirar una tarjeta.</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;"><span style="color:red">Cobrar tarjeta:</span> Después de haber seleccionado una tarjeta que corresponda a un pais suyo, al hacer click en cobrar se incorporaran 2 fichas en su país.</p>
														<br>
															<p dir="ltr" style="display:inline;margin-left:20px;"><span style="color:red">Cambiar tarjetas:</span> Después de haber seleccionado tres tarjetas tuyas (iguales o distintas) al presionar este botón se le entregaran fichas para incorporar, esto se debe hacer en la fase incorporación y antes de poner todas las fichas, de lo contrario entregaría el turno al siguiente jugador.</p>
													
														</div>
													</div>
													
													<h3><a href="#">Nombre Paises</a></h3>
													<div class="contenedor">
														<!-- seleccionar -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">America del norte:</h4>
															<p dir="ltr" style="display:inline;margin-left:20px;">Alaska</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Yukon</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Canada</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Groenlandia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Labrador</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Terranova</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Nueva York</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Oregon</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">California</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Mexico</p>
														</div>
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">America del sur:</h4>
															<p dir="ltr" style="display:inline;margin-left:20px;">Colombia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Peru</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Brasil</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">chile</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Argentina</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Uruguay</p>
														</div>	
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Africa:</h4>
															<p dir="ltr" style="display:inline;margin-left:20px;">Sahara</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Egipto</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Etiopia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Zaire</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Sudafrica</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Madagascar</p>
														</div>
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Europa:</h4>
															<p dir="ltr" style="display:inline;margin-left:20px;">Islandia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Gran Bretaña</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Suecia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Rusia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Polonia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Alemania</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Italia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Francia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">España</p><br>
														</div>	
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Asia:</h4>
															<p dir="ltr" style="display:inline;margin-left:20px;">Aral</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Tartaria</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Taimir</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Siberia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Kamchatka</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Japon</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">China</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Mongolia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Iran</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Gobi</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Turquia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Israel</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Arabia</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">India</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Malasia</p>
														</div>																																								<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Oceania:</h4>
															<p dir="ltr" style="display:inline;margin-left:20px;">Sumatra</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Borneo</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Java</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Australia</p>
														</div>															
														
													</div>
										</div>
									</div>
									<div id="tabs-3" class="tabs">
									<a>Organiza partida con distintas personas</a><br><br>
									<div class="fb-live-stream" data-event-app-id="316798408348316" data-width="400" data-height="500" data-via-url="http://tegame.com.ar" data-always-post-to-friends="false"></div>
									</div>
							</div>
							<a>Juego de estragetia basado en T.E.G</a>
                           </div>
                           
                        </td>
					</tr>                       
                <table>
            </td>
      </tr>
	
    </table>
        	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
<input style="position:absolute;width:130px;right:200px;top:-8px;z-index:100" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" id="donacion" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>

<div id="anuncio-bottom" style="width:728px; heigth:90px;margin-top:30px;">
</div>

</body>
</html>
