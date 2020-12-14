<?php
/*
*/
session_start();

	require_once '../../clases/pais.php';
	require_once '../../clases/continente.php';
	require_once '../../clases/usuarios.php';
	require_once '../../clases/tarjeta.php';
	require_once '../../clases/objetivos.php';
	require_once '../../clases/partida.php';
	require_once '../../clases/ataque.php';
	require_once '../../includes/funciones_archivo.php';

if(isset($_SESSION['rol'])){

	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
	
		//EMPIEZO DICIENDO QUE EL USUARIO GANO, PERO SI NO SE CUMPLE AL MENOS UNA DE LAS CONDICIONES DE SU OBJETIVO, PASO A DECIR QUE NO GANO
	$respuesta='si';
	
		//TRAE EL USUARIO QUE DIJO HABER GANADO
	$usuario=$partida->getJugadorPorId($_SESSION['id']);
		//TRAE EL OBJETIVO DEL USUARIO
	$objetivo = $usuario->getObjetivo();
	
	
	

//COMO HAY DOS USUARIOS JUGANDO, EL OBJETIVO ES CONQUISTAR EL MUNDO
if(sizeof($partida->objetos_usuarios) == 2){
		//SI NO TIENE 50 PAISES EL USUARIO QUE LLAMO, PONGO LA VARIABLE RESPUESTA EN no
	if($usuario->getCantidadPaises() != 50)
		$respuesta='no';
	
}
//HAY MAS DE DOS JUGADORES
else{



	
//////////////INICIO CONTROL PAISES Y CONTINENTES	
	
//PREGUNTA SI TIENE QUE GANAR ALGUN PAIS DE AMERICA DEL NORTE
	if($objetivo->getAmericaNorte() != 0){
			//SI ES IGUAL A 1 ES QUE TIENE QUE GANAR EL CONTINENTE
		if($objetivo->getAmericaNorte() == 1){
				//PREGUNTA SI LA CANTIDAD DE PAISES QUE TIENE EN AMERICA DEL NORTE ES DISTINTA DE 10, SI ES DISTINTA, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL NO
				//CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[0]->getCantidadPaisesUsuario($_SESSION['id']) != 10)
				$respuesta='no';
		}
		else{
				//PREGUNTA SI TIENE EN AMERICA DEL NORTE MENOS DE LAS FICHAS QUE LE PIDE EL OBJETIVO, SI TIENE MENOS, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 				//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[0]->getCantidadPaisesUsuario($_SESSION['id']) < $objetivo->getAmericaNorte())
				$respuesta='no';
		}
	}
		
	
//PREGUNTA SI TIENE QUE GANAR ALGUN PAIS DE AMERICA DEL SUR
	if($objetivo->getAmericaSur() != 0){
			//SI ES IGUAL A 1 ES QUE TIENE QUE GANAR EL CONTINENTE
		if($objetivo->getAmericaSur() == 1){
				//PREGUNTA SI LA CANTIDAD DE PAISES QUE TIENE EN AMERICA DEL SUR ES DISTINTA DE 6, SI ES DISTINTA, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL NO
				//CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[1]->getCantidadPaisesUsuario($_SESSION['id']) != 6)
				$respuesta='no';
		}
		else{
				//PREGUNTA SI TIENE EN AMERICA DEL SUR MENOS DE LAS FICHAS QUE LE PIDE EL OBJETIVO, SI TIENE MENOS, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 				//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[1]->getCantidadPaisesUsuario($_SESSION['id']) < $objetivo->getAmericaSur())
				$respuesta='no';
		}
	}		
			
			

//PREGUNTA SI TIENE QUE GANAR ALGUN PAIS DE AFRICA
	if($objetivo->getAfrica() != 0){
			//SI ES IGUAL A 1 ES QUE TIENE QUE GANAR EL CONTINENTE
		if($objetivo->getAfrica() == 1){
				//PREGUNTA SI LA CANTIDAD DE PAISES QUE TIENE EN AFRICA ES DISTINTA DE 6, SI ES DISTINTA, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL NO
				//CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[2]->getCantidadPaisesUsuario($_SESSION['id']) != 6)
				$respuesta='no';
		}
		else{
				//PREGUNTA SI TIENE EN AFRICA MENOS DE LAS FICHAS QUE LE PIDE EL OBJETIVO, SI TIENE MENOS, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 				//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[2]->getCantidadPaisesUsuario($_SESSION['id']) < $objetivo->getAfrica())
				$respuesta='no';
		}
	}	
	
	
//PREGUNTA SI TIENE QUE GANAR ALGUN PAIS DE EUROPA
	if($objetivo->getEuropa() != 0){
			//SI ES IGUAL A 1 ES QUE TIENE QUE GANAR EL CONTINENTE
		if($objetivo->getEuropa() == 1){
				//PREGUNTA SI LA CANTIDAD DE PAISES QUE TIENE EN EUROPA ES DISTINTA DE 9, SI ES DISTINTA, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL NO
				//CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[3]->getCantidadPaisesUsuario($_SESSION['id']) != 9)
				$respuesta='no';
		}
		else{
				//PREGUNTA SI TIENE EN EUROPA MENOS DE LAS FICHAS QUE LE PIDE EL OBJETIVO, SI TIENE MENOS, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 				//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[3]->getCantidadPaisesUsuario($_SESSION['id']) < $objetivo->getEuropa())
				$respuesta='no';
		}
	}	
	
//PREGUNTA SI TIENE QUE GANAR ALGUN PAIS DE ASIA
	if($objetivo->getAsia() != 0){
			//SI ES IGUAL A 1 ES QUE TIENE QUE GANAR EL CONTINENTE
		if($objetivo->getAsia() == 1){
				//PREGUNTA SI LA CANTIDAD DE PAISES QUE TIENE EN ASIA 15 ES DISTINTA DE 9, SI ES DISTINTA, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL NO
				//CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[4]->getCantidadPaisesUsuario($_SESSION['id']) != 15)
				$respuesta='no';
		}
		else{
				//PREGUNTA SI TIENE EN ASIA MENOS DE LAS FICHAS QUE LE PIDE EL OBJETIVO, SI TIENE MENOS, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 				//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[4]->getCantidadPaisesUsuario($_SESSION['id']) < $objetivo->getAsia())
				$respuesta='no';
		}
	}	
			
//PREGUNTA SI TIENE QUE GANAR ALGUN PAIS DE ASIA
	if($objetivo->getOceania() != 0){
			//SI ES IGUAL A 1 ES QUE TIENE QUE GANAR EL CONTINENTE
		if($objetivo->getOceania() == 1){
				//PREGUNTA SI LA CANTIDAD DE PAISES QUE TIENE EN OCEANIA 4 ES DISTINTA DE 9, SI ES DISTINTA, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL NO
				//CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[5]->getCantidadPaisesUsuario($_SESSION['id']) != 4)
				$respuesta='no';
		}
		else{
				//PREGUNTA SI TIENE EN OCEANIA MENOS DE LAS FICHAS QUE LE PIDE EL OBJETIVO, SI TIENE MENOS, SETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 						//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
			if($partida->continentes[5]->getCantidadPaisesUsuario($_SESSION['id']) < $objetivo->getOceania())
				$respuesta='no';
		}
	}				
			
///////////////////FIN CONTROL PAISES Y CONTINENTES


////////////INICIO CONTROLAR DESTRUIR EJERCITO
	if($objetivo->getColor() != 0){
			//RECORRO TODOS LOS USUARIOS, PARA VER EL USUARIO QUE TIENE EL COLOR SIEMPRE VA A COINCIDIR UNA SOLA VEZ
			//PORQUE SIEMPRE SE LE ASIGNA A MATAR ALGUN COLOR DE LOS QUE ESTAN JUGANDO
		for($i=0;$i<$partida->usuarios_efectivos;$i++){
				//COMPRUEBO SI EL USUARIO QUE AGARRO DE OBJETOS_USUARIOS ES AL QUE DEBE MATAR
			if($partida->objetos_usuarios[$i]->getColor() == $objetivo->getColor()){
					//SI EL USUARIO NO FUE ELIMINADO O SI LO ELIMINO OTRO USUARIOSETEA LA VARIABLE RESPUESTA EN no (OBJETIVO PARCIAL 						
					//NO CUMPLIDO, POR ENDE OBJETIVO TOTAL NO CUMPLIDO)
				if($partida->objetos_usuarios[$i]->getEliminado() == NULL || $partida->objetos_usuarios[$i]->getEliminado()->getId() != $_SESSION['id'])
					$respuesta='no';
				$i=	$partida->usuarios_efectivos;
			}
		}
		
	}

/////////////FIN CONTROLAR DESTRUIR EJERCITO

////////////OBJETIVO COMUN PARA MAS DE 2 JUGADORES, OBTENER 30 PAISES
		//ESTA VA AL FINAL DEL SCRIPT DE MAS DE DOS JUGADORES, PORQUE PUEDE QUE EL OBJETIVO NO LO HAYA CUMPLIDO PERO PUEDE CUMPLIR EL OBJETIVO GENERAL
		//QUE ES GANAR 30 PAISES, POR ESO ES LA UNICA QUE NO TRANSFROMA EL SI EN NO, ESTA PONO DIRECTAMENTE UN SI SI EL USUARIO TIENE MAS DE 30 PAISES
	if($usuario->getCantidadPaises() >= 30)
		$respuesta='si';
/////////FIN OBJETIVO COMUN PARA MAS DE 2 JUGADORES
	

	
}

	//COMPRUEBO SI EL USUARIO ESTA EN TURNO, Y SI NO ESTA EN FASE INCORPORAR SI ESTA EN TURNO LE DOY UNA RESPUESTA SINO NO LE DOY RESPUESTA
	//ESTO ES PORQUE SE PUEDE NOTIFICAR HABER GANADO SOLAMENTE CUANDO UNO ESTA EN TURNO
	if($partida->turno_usuario->getId() == $_SESSION['id'] && $partida->estado_usuario_turno != 3){
		if($respuesta == 'si'){
				//GUARDO EL GANADOR
			$partida->usuario_ganador=$usuario;
				//CON ESTO DIGO QUE LA PARTIDA FINALIZO Y MUESTRO QUIEN GANO
			$partida->estado_usuario_turno=5;
			crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
		}
		echo json_encode($respuesta);
		
	}
}
}




?>