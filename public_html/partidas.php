<?php
session_start();

require_once '../clases/pais.php';
require_once '../clases/continente.php';
require_once '../clases/usuarios.php';
require_once '../clases/tarjeta.php';
require_once '../clases/objetivos.php';
require_once '../clases/partida.php';
require_once '../clases/ataque.php';
require_once '../includes/funciones_archivo.php';

if(!isset($_SESSION['usuario'])){
	header("Location: index.php");
}
if(isset($_SESSION['id_entrega'])){
	header("Location: ajax/__recibir_partida.php");
}
//abro la partida
if(isset($_SESSION['id_partida']))
	$partida = abrir_archivo('../partidas/'.$_SESSION['id_partida']);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta content="text/html;" http-equiv="content-type" charset="utf-8">
<link rel="stylesheet" href="css/partidas.css" type="text/css" media="screen,projection,print">
<link rel="stylesheet" href="jquery/css/custom-theme/jquery-ui-1.8.18.custom.css" type="text/css" media="screen,projection,print">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<?php
	///este javascript es el que actualiza los jugadores mientrsa se van uniendo a la partida, por eso solamente tiene qeu aparecer
	///si el jugador llega aca porque quiere unirse a una partida, y no cuando la quiere crear, o cuando apreto en salir, y tiene la opcion
	//de continuar partida o la de abandonar partida
if(isset($_SESSION['id_partida']) && !(isset($_SESSION['rol'])) && ($partida->clave == $_SESSION['clave']) )
	echo '<script type="text/javascript" src="js/partidas.js"></script>';
?>
<script type="text/javascript" src="js/plugin.js"></script>
<script type="text/javascript" src="js/jquery.timer.js"></script>

<title>Opciones | TEGame.com.ar</title>
</head>
<body>
<div id="barra_superior">
<div class="fb-like" data-href="http://facebook.com/tegenlinea" data-send="false" data-width="600" data-show-faces="false" data-font="arial" style="position:absolute"></div>
<div id="opciones" onclick="window.location='logout.php'"></div>
</div>
<div id="fb-root"></div>

<?php 
if(isset($_SESSION['id_partida']))
	echo '<script>var id_partida='.$_SESSION['id_partida'].'</script>';
?>

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
		$('#barra_superior a').css('left',(left + 600)+'px');
		$('#opciones').css('right',left+'px');
		});
</script>
<html xmlns:fb="http://ogp.me/ns/fb#">
<table  width="1490px" align="center">

<tr align="center">
<td>
<table align="center">
<tr>
<td align="center">
<div id="cuerpo" class="ui-corner-all">
<h1 style="position:absolute;left:200px;top:20px;">TEGame.com.ar</h1>
<div id="datos_usuario" class="ui-corner-all datos_usuario">
<img src="<?php echo $_SESSION['url_img'];?>">
<a><?php echo $_SESSION['usuario'];?></a>
</div>
<?php



//SI EXISTE ROL ES QUE YA ESTA EN UNA PARTIDA, ENTONCES LE DOY A ELEGIR ENTRE
//REANUDAR PARTIDA ACTUAL, CREAR O UNIRSE A UNA PARTIDA NUEVA, O TRANSFERIR PARTIDA ACTUAL
if(isset($_SESSION['rol'])){

	echo'
		<h2>Escoja una opcion</h2>
		<div id="reanudar" class="boton ui-corner-all" onclick="window.location=\'juego.php\'">
		<a>Continuar Partida</a>
		</div>';
		if($_SESSION['id'] != $_SESSION['id_partida'])
			echo '<div id="abandonar" class="boton ui-corner-all" onclick="window.location=\'ajax/__transferir_partida.php\'">
		<a>Transferir y Abandonar Partida</a>
		</div>';
		else
			echo '<div id="abandonar" class="boton ui-corner-all" onclick="window.location=\'logout.php\'">
		<a>Abandonar Partida Clavando a todos</a>
		</div>';
}


//si vino a unirse, no tiene un rol, tiene id_partida y clave
if(isset($_SESSION['id_partida']) && !(isset($_SESSION['rol'])) && ($partida->clave == $_SESSION['clave']) ){
		
			//RECUPERA LA PARTIDA, ES POR SI SE CIERRA EL NAVEGADOR. SI EL USUARIO INTETA, VOLVER A UNIRSE A UNA PARTIDA, EN LA QUE YA ESTA REGISTRADO, LO ENVIA 
			//DIRECTAMENTE A LA PARTIDA
		for($i=0;$i<$partida->usuarios_efectivos;$i++)
			if($partida->objetos_usuarios[$i]->getId() == $_SESSION['id'] && $partida->clave == $_SESSION['clave']){	
					//SI EL USUARIO ESTA EN LA PARITDA, COMPRUEBO POR EL ID, LE CREO DE NUEVO LA SESSION Y LO MANDO A JUGAR
				$_SESSION['color'] = $partida->objetos_usuarios[$i]->getColor();
					//CON ESTO DETERMINO EL ROL, 
				if($_SESSION['id'] == $_SESSION['id_partida'])
					$_SESSION['rol']=1;
				else
					$_SESSION['rol']=0;
					

				header("Location: juego.php");
			}
			
		//SI LA PARTIDA NO ESTA COMPLETA
	if($partida->inicializada == 0){
			//RECORRE TODOS LOS POSIBLES USUARIOS, DIGO POSIBLES, PORQUE EL ARREGLO TIENE EL TAMA„O DE LA PARTIDA, PERO PUEDE QUE NO TODOS HAYAN ENTRADO
		for($i=0;$i<sizeof($partida->objetos_usuarios);$i++){
				//GUARDA EL NOMBRES DEL QUE CREO LA PARITA, SIEMPRE ES EL PIRMER USUARIO DEL ARREGLO, POR ENDE PODRIA TOMAR EL PRIMER ELEMENTO Y LISTO(A CAMBIAR)
			if($partida->objetos_usuarios[$i]->getId() == $_SESSION['id_partida']){

				$nombre_creador_partida =$partida->objetos_usuarios[$i]->getNombre();
				$i=sizeof($partida->objetos_usuarios);
			}		
		}

		
		echo '<form method="get" action="juego.php" enctype="multipart/form-data">
			<div id="unirse_partida" class="ui-corner-all" >
			<h3 style="border-bottom:1px solid ">Escoja un color libre y luego pulse Unirse</h3>';

		echo'<div id="lista_usuarios" style=" position:absolute;background-color:#F0FFF0; border:1px solid #ccc; height:430px;" class="ui-corner-all"><p style="position:relative;border-bottom:1px solid #000; ">Estado de la partida</p>';


		//obtengo la cantidad de usuarios que debe tener la partida

		for($i=0;$i<sizeof($partida->objetos_usuarios);$i++){
			//ya ingreso un usuario
			if($i < $partida->usuarios_efectivos){
				//devuelve el id de los jugadores incorporados
				/*$respuesta=$partida->objetos_usuarios[$i]->getId();
				$usuario = array('nombre'=>$partida->objetos_usuarios[$i]->getNombre(),
						'url_img'=>$partida->objetos_usuarios[$i]->getUrlImg(),
						'color'=>$partida->objetos_usuarios[$i]->getColor());*/

				echo'<div referencia_color="" id="jugador'.($i+1).'" class="ui-corner-all datos_usuario jugador" style="position:relative;margin-left:50px; margin-top:10px;border:3px solid #000">
					
					<img>
					<a></a>
					<input type="hidden" name="hidden'.($i+1).'" class="hidden"/>
					</div>';	
			}
			//e un lugar sin usuario
			else{
				echo'<div referencia_color="" class="ui-corner-all datos_usuario jugador" style="position:relative;margin-left:50px; margin-top:10px;border:1px dashed #000;">
					<a>Libre</a>
					<img>
					<input type="hidden" name="hidden'.($i+1).'" class="hidden"/>
					</div>';					
			}
		}



			
			
			//COMPROBAR SI ALGUNA DE LAS RESERVAS ESTAN VENCIDAS, SI ESTA VENCIDA, LA IGUALO A NULL
		for($i=0; $i< sizeof($partida->objetos_usuarios_temporales) ;$i++){
			if(isset($partida->objetos_usuarios_temporales[$i])){
					$tiempo = time() - ((int)$partida->objetos_usuarios_temporales[$i]['tiempo'] + 30);
				if( $tiempo > 0 ){
					$partida->objetos_usuarios_temporales[$i]['id']=NULL;
					$partida->objetos_usuarios_temporales[$i]['tiempo']=NULL;
					$partida->objetos_usuarios_temporales[$i]['color']=NULL;
				}
			}
			else{
					$partida->objetos_usuarios_temporales[$i]['id']=NULL;
					$partida->objetos_usuarios_temporales[$i]['tiempo']=NULL;
					$partida->objetos_usuarios_temporales[$i]['color']=NULL;
			}
		}
			
			
			$reserva=0;
				//COMPRUEBO SI EL ID QUE LO CORRE YA RESERVO ALGUNA PATIDA
			for($j=0;$j<sizeof($partida->objetos_usuarios_temporales);$j++)
				if($partida->objetos_usuarios_temporales[$j]['id'] == $_SESSION['id'] ){
					$reserva=1;
						//FUERZO LA SALIDA DEL FOR
					$j=sizeof($partida->objetos_usuarios_temporales);
				}
				//SI NO TIENE NINGUNA RESERVA LE DA LA OPCINO DE ELEGIR UN COLOR, SI TIENE UNA RESERVA, POR JAVASCRIPT LE DA LA OPCION DE UNIRSE
			if($reserva == 0){
					echo'<div id="ingresar" class="ui-corner-all" style="position:absolute;top:40px;left:350;width:300px;height:100px;border:1px solid #000"><input type="hidden" value="'.$_SESSION['id_partida'].'" name="id_partida"> 
			<input type="hidden" value="'.$_SESSION['clave'].'" name="clave">		
			<a style=" position:absolute; top:20px; left:30px">Color de fichas</a>';
				echo '<select name="color" style=" position:absolute; top:20px; left:180px" disabled="disabled">
			<option value="0">Colores</option>
			<option value="1">Negro</option>
			<option value="2">Rojo</option>
			<option value="3">Amarillo</option>
			<option value="4">Magenta</option>
			<option value="5">Verde</option>
			<option value="6">Azul</option>
			</select>';
			
			echo '<input type="submit" value="Unirse" name="accion" disabled="true"  style=" position:absolute; bottom:20px; left:75px" class="ui-corner-all" id="unirse"/>
			<a id="tiempo"style="position:absolute;bottom:2px;left:5px;"></a>
			</form>
			</div></div>';
		echo '</div>';
		
		}
		else{
				echo '<input type="submit" value="Unirse" name="accion"  style=" position:absolute; top:100px; left:400px" class="ui-corner-all" id="unirse"/>';
				echo '</form>';
		}

	}
	///ya no queda lugares libres en la 
	else
		echo '<h1 style="position:absolute;top:300px;left:400px">Partida completa</h1><br><a href="logout.php"style="position:absolute;top:400px;font-size:20px;left:420px;">Crear una nueva partida</a>';
		



}    

//entra aca cuando no tiene un id de partida al que unirse y no esta en juego en ninguna partida existe, o sea no tiene asignado rol
if(!(isset($_SESSION['id_partida'])) && !(isset($_SESSION['rol'])) ){

	echo '
		<div id="crear_partida" class="ui-corner-all" >
		<h3 style="border-bottom:1px solid #000">Administrar Partidas</h3>
		<div id="partida_nueva" class="ui-corner-all">
		<p style="position:absolute;left:10px; border-bottom:1px solid #000">Crear nueva Partida</p>
		<form method="get" action="juego.php" enctype="multipart/form-data">

		<a style=" position:absolute; top:50px; left:40px">Cantidad de jugadores</a><select name="numero_jugadores" style=" position:absolute; top:50px; right:40px">
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		</select>


		<a style=" position:absolute; top:90px; left:40px">Color de fichas</a> <select name="color" style=" position:absolute; top:90px; right:40px">
		<option value="1">Negro</option>
		<option value="2">Rojo</option>
		<option value="3">Amarillo</option>
		<option value="4">Magenta</option>
		<option value="5">Verde</option>
		<option value="6">Azul</option>
		</select>

		<input type="submit" id="crear" value="crear" name="accion" class="ui-corner-all" style="position:absolute; left:80px; bottom:20px;height:30px" />
		</form>
		</div>';
			//DA LA OPCION DE RECUPERAR UNA PARTIDA EXISTENTE
	$partida = abrir_archivo('../partidas/'.$_SESSION['id']);
		if($partida != 0 && $partida->usuario_ganador == NULL){
			echo '<p style="position:absolute;left:240px;bottom:100px">Usted tiene una partida sin finalizar</p>';
			echo '<form method="get" action="index.php?permiso=1" enctype="multipart/form-data">';
			echo'<input type="submit" class="ui-corner-all" value="Reanudar Partida Existente" style="position:absolute; bottom:80px; left:250px;height: 30px;width:200px;">';
			echo '<input type="hidden" name="id_partida" value="'.$_SESSION['id'].'">';
			echo '<input type="hidden" name="clave" value="'.$partida->clave.'">';
			echo'</form>';

		}
		echo '</div>';



}
?>

</div>
</td>
</tr>                       
<table>
</td>
</tr>
</table>

</body>
</html>
