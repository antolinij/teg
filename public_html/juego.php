<?php
	session_start();
	require_once "../clases/pais.php";
	require_once "../clases/continente.php";
	require_once "../clases/usuarios.php";
	require_once "../clases/tarjeta.php";
	require_once "../clases/objetivos.php";
	require_once "../clases/partida.php";
	require_once "../clases/ataque.php";
	require_once "../includes/funciones_archivo.php";
	require_once "../clases/incorporar.php";	
	require_once "../includes/funcion_area.php";
	require_once "../database.php";

	if(!isset($_SESSION['usuario'])) //si el usuario no ingreso enviando por un post y no tiene session lo envia de nuevo al index
		header("Location: index.php");
		

	
//inicializar juego
	
	
	
//si el que ingresa no tiene session la creo. Y si el usuario nuevo es el anfitrion tambien crea la partida
//El nombre con el que esta guardada La serializacion del objeto partida es el id del anfitrion
//cuando se incorpora el ultimo jugador tambien se sortean los paises y las posiciones de comienzo
//todo esto ocurre en el script crear_sesion.php
	require_once "../includes/crear_sesion.php";
	
		//si fue correcta la creacion continua sino lo envio al index notificando el error(hay que seguir viendo las formas como ccomprueba si fue correcta)
			if(!isset($_SESSION['usuario']))
				header("Location: index.php");
	
	
	//abro el archiv, y lo guardo en partida
	if(isset($_SESSION['id_partida'])){
		$partida = abrir_archivo("../partidas/".$_SESSION['id_partida']);
		if($partida->clave != $_SESSION['clave'])
			header("Location: logout.php");
			
	}
	else
		header("Location: logout.php");
	//tengo el arreglo con los paises en arreglo_paises
	$arreglo_paises = $partida->paises;
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="image/x-icon" href="fondos/favicon.png" rel="icon" />
<link type="text/css" rel="stylesheet" href="css/juego.css" />
<link type="text/css" rel="stylesheet" href="css/barra.css" />
<link type="text/css" rel="stylesheet" href="css/chat.css" />
<link type="text/css" rel="stylesheet" href="css/info_usuarios.css" />
<link type="text/css" rel="stylesheet" href="css/desarrollo.css" />

<link type="text/css" rel="stylesheet" href="jquery/css/custom-theme/jquery-ui-1.8.18.custom.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/jquery.timer.js"></script>
<script type="text/javascript" src="/js/jugador.js"></script>
<script type="text/javascript" src="/js/comienzo.js"></script>
<script type="text/javascript" src="js/dado.js"></script>
<script type="text/javascript" src="js/plugin.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript">
    $(document).ready(function() {
    	$("#opciones").click(function(){
    		window.location="partidas.php";
    	});

    });
</script>

<script type="text/javascript">

       FB.init({
         appId  : '316798408348316',
         status : true,
         cookie : false,
         xfbml  : true
       });
       


     

function streamPublish(){      
    FB.ui({ method: 'feed',
    	name: 'TEGame.com.ar',
    	link: 'http://tegame.com.ar',
    	picture: 'http://tegame.com.ar/fondos/logo_pagina.png',
    	caption: 'TEGame.com.ar',
    	description: 'Esta jugando una partida'
     });             
}
</script>

<title>TEGame.com.ar</title>
<script>
    $(document).ready(function() {
		$( "#accordion" ).accordion();
		$('#abrir_instrucciones').click(function(){
			$('#instrucciones').css('visibility','visible');
			$('#abrir_instrucciones').css('visibility','hidden');
			$('#instrucciones').animate({'opacity':'1'},700);
		})
		$('#instrucciones input').click(function(){
			$('#instrucciones').css('visibility','hidden');	
			$('#abrir_instrucciones').css('visibility','visible');	
			$('#instrucciones').css('opacity','0');		
		})
	});
</script>

</head>
<body>








<select id="incorporar_varias" multiple="multiple" style="position:absolute;height:80px;z-index:1;visibility:hidden;width:30px;border:1px solid #000;box-shadow: inset 0px 0px 3px 1px #000;background-color:#D2DACD">

</select>
<div id="barra_superior">
<?php
	if($_SESSION['id_partida'] == $_SESSION['id']){
		echo '<div style="position:absolute;z-index:110;bottom:5px;" class="fb-send" data-href="http://tegame.com.ar/?id_partida='.$_SESSION['id_partida'].'&clave='.$_SESSION['clave'].'" data-send="true" data-width="600" data-show-faces="false" data-font="arial"></div>';
				}
?>
                    	
                    	<div style="z-index:100" class="fb-like" data-href="http://facebook.com/tegenlinea" data-send="false" data-width="600" data-show-faces="false" data-font="arial" style="position:absolute"></div>
                    	<?php
                    		if($_SESSION['id_partida'] == $_SESSION['id'])
                    		echo "<a onclick='return false' id='referencia_partida' href='/?id_partida=".$_SESSION['id_partida']."&clave=".$_SESSION['clave']." "."' style='position:absolute;left:550px;cursor:text'><span style='color:red;'>URL Partida ----> </span>tegame.com.ar/?id_partida=".$_SESSION['id_partida']."&clave=".$_SESSION['clave']."<a>";
                    	?>
    					<div id="opciones"></div>
    					<div id="color_fondo">
                        	<p>Color de Fondo</p>
                        	<input type="button" value="Original" >
                        	<div id="slider_rojo"></div>
                        	<div id="slider_verde"></div>
                        	<div id="slider_azul"></div>
                        </div>
    </div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=316798408348316";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script>
$(document).ready(function() {


//centra el cuerpo
var left =((1500-window.innerWidth)/2);
if(left < 0)
	left=0;
left+=10;
$('.fb-like').css('left',left+80+'px');
$('.fb-send').css('left',left+'px');
$('#opciones').css('right',left+'px');
$('#color_fondo').css('right',(left + 50)+'px');
$('#barra_superior a').css('left',(left )+'px');
$('#donacion').css('right',(left + 200)+'px');
$('#donacion').css('top','4px');

});
</script>
<html xmlns:fb="http://ogp.me/ns/fb#">
<div id="nombre_pais" class="ui-corner-all"><a></a></div>
	<table  width="100%">
	    	<tr>
        	<td align="center">
        	
   	
        	




            	<table width="1490px">
                	<tr >
                    	<td align="center">
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
?>
</div>
                    	<div id="cuerpo" align="left">
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	
                    	<!-- INSTRUCCIONES -->
<div id="instrucciones" class="ui-corner-all">
<input type="button" value="Cerrar" class="ui-corner-bottom">
<div id="accordion" >
												<h3><a href="#">Comenzar a jugar</a></h3>
													<div class="contenedor">
													
													<!-- Invitar jugadores -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Invitar Jugadores: <span style="color:red;font-size:15px">(si no podes enviar el mensaje recarga la pagina)</span></h4>
															<img src="/fondos/instrucciones/inicio/invitar_jugador.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Después de crear la partida, arriba a su izquierda (solo al que la creo), le aparece la dirección que debe enviarle a los jugadores que quiere invitar.</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;">Puede presionar el botón derecho del mouse sobre el link y seleccionar "copiar dirección del enlace" y posteriormente pegarla en el medio por el cual desee invitar usuarios. También puede arrastrarlo directamente.</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;color:red">una forma practica es presionar el botón Enviar que esta debajo de la url de la partida(arriba a su izquierda), escojer los amigos o grupos de facebook a los que desee invitar, si quiere puede agregar un mensaje y por ultimo presione enviar.</p>
													</div>
													<!-- Unirse a una partida -->
													<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Unirme a una Partida:</h4>
															<img src="/fondos/instrucciones/inicio/elegir_color.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Si usted fue invitado a unirse a una partida, después de ingresar al link que le enviaron. Debe iniciar sesión.</p><br>
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
															<h4 style="border-bottom:1px solid #000" align="left">Incorporaci—n Simple:</h4>
															<img src="/fondos/instrucciones/incorporar/fichas_incorporar.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando está en turno y en la fase incorporar ejércitos haciendo click sobre un país o ficha suya incorporará un ejército. Verá en la parte inferior izquierda la cantidad de fichas que dispone y su procedencia. </p>
														</div>	
														<!-- incorporacion multiple -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Incorporación Multiple:</h4>
															<img src="/fondos/instrucciones/incorporar/incorporacion_multiple.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando está en turno y en la fase incorporar ejércitos haciendo click por lo menos 1 segundo sobre una ficha suya, se desplegará una lista, en esta usted puede elegir el numero de ejércitos que desea incorporar en ese país.</p>
														</div>	
													
													</div>
												<h3><a href="#">Atacar</a></h3>
													<div class="contenedor">
														<!-- seleccionar paises -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Seleccionar Paises:</h4>
															<img src="/fondos/instrucciones/atacar/seleccionar.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando está en turno y en la fase atacar, seleccione un país suyo desde donde desee hacer el ataque y posteriormente el país al que desea atacar</p>
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
															<p dir="ltr" style="display:inline;margin-left:20px;">Una vez que tenga seleccionado el país desde el que desea atacar y el país al que desea atacar, haga click en el cubilete.</p>
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
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando está en turno y en la fase reagrupar, seleccione un país suyo desde donde desee enviar fichas, y posteriormente el país al que desee enviarselas.</p>
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
															<p dir="ltr" style="display:inline;margin-left:20px;">Cuando está en turno y en la fase Tarjeta, al pasar el mouse por el botón Opciones se desplegaran las acciones que puede realizar</p>
														</div>
														<!-- opciones -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Acción:</h4>
															<img src="/fondos/instrucciones/tarjetas/accion.png" width="50%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Al haber hecho el paso anterior aparecerán las siguientes opciones:</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;"><span style="color:red">Retirar tarjeta:</span> Esta opción le permite retirar una tarjeta.</p><br>
															<p dir="ltr" style="display:inline;margin-left:20px;"><span style="color:red">Cobrar tarjeta:</span> Después de haber seleccionado una tarjeta que corresponda a un pais suyo, al hacer click en cobrar se incorporaran 2 fichas en su país.</p>
														<br>
															<p dir="ltr" style="display:inline;margin-left:20px;"><span style="color:red">Cambiar tarjetas:</span> Después de haber seleccionado tres tarjetas tuyas (iguales o distintas) al presionar este botón se le entregaran fichas para incorporar, esto se debe hacer en la fase incorporación y antes de poner todas las fichas, de lo contrario entregará el turno al siguiente jugador.</p>
													
														</div>
												</div>
											<h3><a href="#">Objetivos</a></h3>
													<div class="contenedor">
														
														<!-- objetivos -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Objetivo:</h4>
															<img src="/fondos/instrucciones/objetivo/objetivo.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Al hacer click en su nombre, (a la derecha de la pantalla) se despliega toda su información, entre esta está su objetivo, una vez completado el que le haya tocado esta misma ventana tiene el botón Gane, presionando este se convierte en el ganador de la partida y notifica su triunfo a los demás jugadores. Recuerde que puede informar de su triunfo cuando este en cualquier fase de su turno menos la de incorporar ejercito</p>
														</div>
														<!-- tipo de objetivos -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Tipo de Objetivos:</h4>
															<img src="/fondos/instrucciones/objetivo/gane.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Hay dos grupos de objetivos, los que consisten en ocupar ciertos sectores del mapa, o los que consisten en destruir a un ejército, recuerde que para cumplir este ultimo, usted debe ser el que elimine el ultimo ejército del jugador en cuestión. El objetivo matar al jugador de la derecha existe, si le toca este, su objetivo dirá destruir al ejército del color que tiene el jugador de su derecha, esto es para evitar confusiones con cual es la derecha.</p>
														</div>
														<!-- Objetivo comun -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Objetivo Común:</h4>
															<img src="/fondos/instrucciones/objetivo/objetivo.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Si usted esta jugando una partida de dos jugadores, el objetivo para ambos es único y consiste en conquistar el mundo. Si esta jugando una partida de mas de dos jugadores cada uno tiene un objetivo en particular, pero aparte todos tienen un objetivo común, que es tener conquistar 30 países, un usuario gana cuando cumple su objetivo particular o el objetivo en común.</p>
														</div>
												</div>
												
												<!-- inicio novedades -->
											<h3><a href="#" style="color:green">Novedades</a></h3>
													<div class="contenedor">									
														<!-- objetivos -->
														<div style="width:100%;height:100%" align="left">
															<h4 style="border-bottom:1px solid #000" align="left">Transferir Partida:</h4>
															<img src="/fondos/instrucciones/distribucion/salir.png" width="20%" style="position:relative;display:inline;float:left; border:3px solid #000;margin-right:10px">
															<p dir="ltr" style="display:inline;margin-left:20px;">Si un jugador debe o desea abandonar la partida, este puede hacer que los que queden jugando inviten a otro en su reemplazarlo. Forma de hacerlo: el jugador que abandonará la partida debe presionar el botón salir que esta arriba a la derecha, en la pagina nueva que se abre debe elegir la opción <span style="color:red">Transferir y Abandonar Partida</span>, al presionar este botón el abandona la partida y en el chat aparecerá un link el que se debe seleccionar con doble click y posteriormente copiar. Finalmente enviar este link a la persona que quieran que lo reemplace. El reemplazante después de ingresar al link debe presionar el botón connect y será directamente direccionado a la partida. <span style="color:red">El único usuario que no puede realizar una transferencia es el que creo la partida</span></p>
														</div>

												</div>
											<!-- fin novedades -->

										</div>
						</div>
									
							<!-- FIN INSTRUCCIONES -->		
									
									
									
									
									
									
									
									
									
									
									
									
									
                    	<input	type="button" value="Instrucciones" id="abrir_instrucciones" class="ui-corner-bottom">
                    	
 						<div id="fondo_info_usuario" class="ui-corner-br">  
 						</div>
 						<div id="juego_terminado" class="ui-corner-all">
 							<h2 style="position:absolute;left:250px;border-bottom:1px solid #000">Partida Finalizada</h2>
 							<h2 id="usuario_ganador" style="position:absolute;top:80px;left:30px;border-bottom:1px solid #000">Usuario ganador:</h2>
 							
 								<div style="position:absolute;top:80px;left:250px;border-bottom:1px solid #000" id="ganador" class="usuario ui-corner-all">
                                 	<a class="nombre_usuario"></a>
                                	<div class="foto_usuario"></div>
                                </div>
                                
 							<img id="objetivo_ganador" style="position:absolute;bottom:80px;left:100px;border:1px solid #000;background-color:#FFF" class="ui-corner-all" src="">
 							<a href="logout.php" style="position:absolute;top:20px;right:20px;font-size:20px">Salir</a>

 						</div>             	
                    		<!-- en info usuario esta toda la informacion de los distintos usuarios, se abre haciendo click en el div que tiene la foto y el nombre-->
                    		<div id="info_usuarios" class="ui-corner-all">
                    			<div id="contenedor_tarjetas" class="ui-corner-all">                 			
                    				<div id="info_tarjeta0" class="info_tarjetas">
                           	        	<marquee behavior="scroll" scrolldelay="200" width="80px">
                           	        	</marquee>
                    				</div>
                    				<div id="info_tarjeta1" class="info_tarjetas">
                           	        	<marquee behavior="scroll" scrolldelay="200" width="80px">
                           	        	</marquee>
                    				</div>
                    				<div id="info_tarjeta2" class="info_tarjetas">
                                   		<marquee behavior="scroll" scrolldelay="200" width="80px">
                                   		</marquee>
                    				</div>
                    				<div id="info_tarjeta3" class="info_tarjetas">
                                   		<marquee behavior="scroll" scrolldelay="200" width="80px">
                                    	</marquee>
                    				</div>
                    				<div id="info_tarjeta4" class="info_tarjetas">
                                    	<marquee behavior="scroll" scrolldelay="200" width="80px">
                                    	</marquee>
                    				</div>
                    			</div>
                    			<a id="info_usuarios_ronda">Ronda #: </a>
                    			<a id="info_usuarios_cantidad_paises">Cantidad de paises: 0</a>
                    			<a id="info_usuarios_cantidad_cambios">Cambios realizados: </a>
                    			<a id="info_usuarios_taerjetas">Tarjetas</a>
                    			<a id="info_usuarios_objetivo">Objetivo</a>
                    			<div id="info_usuarios_contenedor_objetivo" class="ui-corner-all">
                    			</div>
                    			<input type="button" id="info_usuarios_gane" class="ui-corner-all" value="Gane">
                    		</div>
                    	
                    		
                        	
                        		
                        		
                        	
                        	<div id="slider" value="50"></div>
                        	
                        		<div id="mapa" align="center">
                        		<img id="mapa_sin_nombre"src="/fondos/mapa.png" usemap="#mapas">
                        		<MAP NAME="mapas">	
                        			
                        		
                        		<img id="mapa_nombres"src="/fondos/mapa_nombres.png">
                                <?php
										//genero las fichas
										for($i=0;$i<50;$i++){
		
			
											if($partida->inicializada==1){
					//ESTA LINEA DEFINE EL AREA DE LOS PAISES							¡
				echo '<AREA style="cursor:pointer" id="area-'.$i.'" SHAPE="POLY" coords="'.areaPais($i).'" name="'.$partida->paises[$i]->getPropietario()->getId().'">';
												//en value coloco la cantidad de fichas que tiene ese pais
												//en name el id del propiestario
												//en id el numero de ficha que es(este puede llegar a estar mal)
												if($arreglo_paises[$i]->getPropietario()->getColor()==1)
													echo'<input type="button" nombre="'.$partida->paises[$i]->getNombre().'" name="'.$partida->paises[$i]->getPropietario()->getId().
													'" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:black;color:#FFF; cursor:pointer;"/>';
												if($arreglo_paises[$i]->getPropietario()->getColor()==2)
													echo'<input type="button" nombre="'.$partida->paises[$i]->getNombre().'" name="'.$partida->paises[$i]->getPropietario()->getId().
													'" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:red;color:#FFF; cursor:pointer;"/>';
												if($arreglo_paises[$i]->getPropietario()->getColor()==3)
													echo'<input type="button" nombre="'.$partida->paises[$i]->getNombre().'" name="'.$partida->paises[$i]->getPropietario()->getId().
													'" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:yellow;color:#000; cursor:pointer;"/>';
												if($arreglo_paises[$i]->getPropietario()->getColor()==4)
													echo'<input type="button" nombre="'.$partida->paises[$i]->getNombre().'" name="'.$partida->paises[$i]->getPropietario()->getId().
													'" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:magenta;color:#000; cursor:pointer;"/>';
												if($arreglo_paises[$i]->getPropietario()->getColor()==5)
													echo'<input type="button" nombre="'.$partida->paises[$i]->getNombre().'" name="'.$partida->paises[$i]->getPropietario()->getId().
													'" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:green;color:#FFF; cursor:pointer;"/>';
												if($arreglo_paises[$i]->getPropietario()->getColor()==6)
													echo'<input type="button" nombre="'.$partida->paises[$i]->getNombre().'" name="'.$partida->paises[$i]->getPropietario()->getId().
													'" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:blue;color:#FFF; cursor:pointer;"/>';				
											}
											else{
												echo '<AREA style="cursor:pointer" id="area-'.$i.'" SHAPE="POLY" coords="'.areaPais($i).'" name="">';
													echo'<input type="button" value="0" id="ficha'.$i.'" class="ficha ui-corner-all2" style="background-color:white;"/>';		
											}
										}
								?>
                                </MAP> 
                                </div>
                                
                                <div id="partida">
                                
                                	
                                	<!-- la clase lista_usuario indica que es de la lista que esta a la derecha, es para agarrar todos los jugadores -->
                                	<div id="jugador1" class="usuario ui-corner-all lista_usuario">
                                 	  	<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                        <input type="hidden" name="hidden1" class="hidden" value=""/>
                                    </div>
                                    <div id="jugador2" class="usuario ui-corner-all lista_usuario">
                                    	<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                        <input type="hidden" name="hidden2" class="hidden" value=""/>
                                    </div>
                                    <div id="jugador3" class="usuario ui-corner-all lista_usuario">
                                    	<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                        <input type="hidden" name="hidden3" class="hidden" value=""/>
                                    </div>
                                    <div id="jugador4" class="usuario ui-corner-all lista_usuario">
                                   		<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                        <input type="hidden" name="hidden4" class="hidden" value=""/>
                                    </div>
                                    <div id="jugador5" class="usuario ui-corner-all lista_usuario">
                                    	<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                        <input type="hidden" name="hidden5" class="hidden" value=""/>
                                    </div>
                                    <div id="jugador6" class="usuario ui-corner-all lista_usuario">
                                    	<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                        <input type="hidden" name="hidden6" class="hidden" value=""/>
                                    </div>
                                    <div id="selector_jugador" class="ui-corner-all">

                                    </div>
                                    <a id="numero_ronda">Ronda #: </a>
                                    <hr>
                                  <div id="secuencia_juego" class="ui-corner-all">
                                	<ul class="ui-corner-all" id="estado_turno">
                                    	<li id="selector_incorporar" class="ui-corner-all"><img src="fondos/incorporar.png"><a>Incorporar</a></li>
                                        <li id="selector_ataque" class="ui-corner-all"><img src="fondos/atacar.png"><a>Atacar</a></li>
                                        <li id="selector_reagrupar" class="ui-corner-all"><img src="fondos/reagrupar.png"><a>Reagrupar</a></li>
                                        <li id="selector_tarjeta" class="ui-corner-all"><img src="fondos/tarjeta.png"><a>Tarjeta</a></li>
                                        <li id="finalizar" class="ui-corner-all"><img src="fondos/fin_turno.png"><a>Finalizar</a></li>
                                    </ul>
                                </div>
                                </div>
                                <div id="desarrollo">
                                	<div id="desarrollo_otros">
                                		<div id="usuario_de" class="usuario ui-corner-all">
                                   			<a class="nombre_usuario"></a>
                                   			<div class="foto_usuario"></div>
                                   		</div>
                                    	<div id="usuario_a" class="usuario ui-corner-all">
                                    		<a class="nombre_usuario"></a>
                                   		<div class="foto_usuario"></div>
                                   		</div>
                                    	<div id="pais_de" class="pais ui-corner-all">
                                    		<a style="font-family:Arial, Helvetica, sans-serif; font-size:20"></a>
                                    	</div>
                                    	<div id="pais_a" class="pais ui-corner-all">
                                   			<a></a>
                                    	</div>
                                    </div>
                                    <div id="desarrollo_incorporar" class="ui-corner-all">
                                    <h3>Incorporar</h3>
                                    <div id="desarrollo_incorporar_izquierda">
                                    	<a>Libres: </a>
                                    	<a>cambio: </a>
                                    	<a>Continentes: </a>
                                    	<hr>
                                    	<a>Total: </a>
                                    </div>
                                    <div id="desarrollo_incorporar_derecha">
                                    	<a>America del norte: </a>
                                    	<a>America del sur: </a>
                                    	<a>Africa: </a>
                                    	<a>Europa: </a>
                                    	<a>Asia: </a>
                                    	<a>Oceania: </a>
                                    </div>
                                    </div>
                                    <div id="accion" class="ui-corner-all">
                                    	<div id="ataque" class="accion">
                                        	<div id="dados_atacante">
                                            	<div class="dado ui-corner-all" ></div>
                                                <div class="dado ui-corner-all" ></div>
                                                <div class="dado ui-corner-all" ></div>
                                            </div>
                                            <div id="dados_defensa">
                                            	<div class="dado ui-corner-all" ></div>
                                                <div class="dado ui-corner-all"></div>
                                                <div class="dado ui-corner-all" ></div>
                                            </div>
                                           <img src="fondos/lanzar_dados.png">
                                        </div>
                                        <div id="reagrupar" class="accion ui-corner-all">
                                        	<a style="position:absolute; top:50px; left:90px">Enviar: </a>
                                            <select style="position:absolute; top:50px; left:150px">
                                            </select>
                                            <input type="button" class="ui-corner-all" value="Aceptar" style="position:absolute; top:100px; left:105px;border: 1px solid #82C0F4;height: 20px;width:100px;" />
                                            	
	
	
                                        </div>
                                        <div id="informacion" class="accion ui-corner-all">
                                        	<div id="tarjeta1" class="tarjeta" seleccionada="no">
                                            	<div></div>
                                                <marquee behavior="scroll" scrolldelay="200" width="80px"></marquee>
                                            </div>
                                            <div id="tarjeta2" class="tarjeta" seleccionada="no">
                                           		<div></div>
                                                <marquee behavior="scroll" scrolldelay="200" width="80px"></marquee>
                                            </div>
                                            <div id="tarjeta3" class="tarjeta" seleccionada="no">
                                           		<div></div>
                                                <marquee behavior="scroll" scrolldelay="200" width="80px"></marquee>
                                           </div>
                                            <div id="tarjeta4" class="tarjeta" seleccionada="no">
                                           		<div></div>
                                                <marquee behavior="scroll" scrolldelay="200" width="80px"></marquee>
                                           </div>
                                            <div id="tarjeta5" class="tarjeta" seleccionada="no">
                                           		<div></div>
                                                <marquee behavior="scroll" scrolldelay="200" width="80px"></marquee>
                                           </div>
                                           <ul class="ui-corner-all"><img src="fondos/tarjeta.png" id="opciones_tarjeta">
                                            	<li class="ui-corner-all">
                                            		<img src="fondos/retirar_tarjeta.png" name="tarjeta" class="ui-corner-all" id="retirar_tarjeta"/><a>Retirar Tarjeta</a>
												</li>
												<li class="ui-corner-all">
                                            		<img src="fondos/cobrar_tarjeta.png" name="cobrar" id="cobrar_tarjeta"><a>Cobrar Tarjeta</a>
                                            	</li>
                                            	<li class="ui-corner-all">
                                            		<img src="fondos/cambiar_tarjetas.png" id="cambiar_tarjeta" id="cambiar_tarjetas"><a>Cambiar Tarjetas</a>
                                      			</li>
                                       		</ul>
                                        </div>
                                    </div>
                                </div>
                               <!-- <input type="button" value="Finalizar Turno" id="finalizar" class="ui-corner-all"/> -->
                                <input value="Publica algo en tu muro" type="button" onclick="streamPublish(); return false;" style="position:absolute;bottom:85px;right:80px;height:30px;width:150px;border:1px solid #000; cursor:pointer;background-color:#ddd" class="ui-corner-all">
                                <div id="chat" class="ui-corner-all">
                                	<textarea></textarea>
                                	<div id="ultimo_mensaje" class="ui-corner-all"><div></div><a>.::Enviar Mensaje::.</a></div>
                                	<div id="todos_los_mensajes" class="ui-corner-top"></div>
                                </div>
                            </div>
                        </td>
                        
					</tr>       
					                
                </table>
        <div id="anuncio-bottom" style="margin-top:35px">

</div>
            </td>
            
        </tr>

    </table>
 
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
<input style="position:absolute;width:130px;right:200px;top:-8px;z-index:10" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" id="donacion" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>


</body>
</html>
