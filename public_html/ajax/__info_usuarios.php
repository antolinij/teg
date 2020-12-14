<?php
/*
*	DEVUELVE LAS TARJETAS QUE TIENE EL USUARIO
*
*devuelve un arreglo bidimensional la primer dimension tiene 5 posiciones una por cada posible tarjeta
*si el usuario no tiene cinco tarjetas se completa con NULL
*
*la segunda dimension tiene 3, nombre pais, logo,esta(se cobro o no). En ese orden
*
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
	//ARREGLO EN EL QUE SE CARGAN LAS TARJETAS
	//creo $respueta=0, y si no se modifica, la respuesta es porque ese jugador no tenia tarjeta
	//en 0 trae el nombre del pais en 1 trae el nombre del dibujo y en 2 pone 1 0 si no fue cobrado y un 1 si fue cobrado
	$respuesta=array(
	0=>array(
		0=>array(0=>'',1=>NULL,2=>NULL),
		1=>array(0=>'',1=>NULL,2=>NULL),
		2=>array(0=>'',1=>NULL,2=>NULL),
		3=>array(0=>'',1=>NULL,2=>NULL),
		4=>array(0=>'',1=>NULL,2=>NULL)
		),
	1=>NULL,
	2=>NULL,
	3=>NULL,
	4=>NULL
	);

if(isset($_SESSION['rol'])){

	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
	
	
		//TRAE EL USUARIO SOBRE EL QUE SE QUIERE HACER LA CONSULTA
		$usuario=$partida->getJugadorPorId($_GET['id_usuario']);

		//CARGA LAS TARJETAS EN EL ARREGLO
		$i=0;
		foreach($usuario->getTarjetas() as $tarjeta){
			if($tarjeta != NULL){
					//MANDA EL NOMBRE DE LA TARJETA SOLAMENTE SI EL EL USUARIO QUE LLAMA AL ESCRIPT ESTA PIDIENDO SUS DATOS
					//O SI LA TARJETA FUE COBRADA, DE LO CONTRARIO NO LO ENVIA
				if($_GET['id_usuario'] == $_SESSION['id'] || $tarjeta->getEstado() == 1)
					$respuesta[0][$i][0]=$tarjeta->getNombrePais($partida);
				else
					$respuesta[0][$i][0]=' ';
					
					//MANDA EL LOGO DE LA TARJETA SOLAMENTE SI EL EL USUARIO QUE LLAMA AL ESCRIPT ESTA PIDIENDO SUS DATOS
					//O SI LA TARJETA FUE COBRADA, DE LO CONTRARIO NO LO ENVIA
				if($_GET['id_usuario'] == $_SESSION['id'] || $tarjeta->getEstado() == 1)
					switch($tarjeta->getLogo()){
						case 0:	
							$respuesta[0][$i][1]='canon.png';
						break;
						case 1:	
							$respuesta[0][$i][1]='globo.png';
						break;
						case 2:	
							$respuesta[0][$i][1]='barco.png';
						break;
						case 3:	
							$respuesta[0][$i][1]='comodin.png';
						break;
					}
				else
					$respuesta[0][$i][1]='reverso.png';
					
					//en 2 pongo el estado(cobrada o no)
				$respuesta[0][$i][2]=$tarjeta->getEstado();
				$i++;
			}
		}//foreach($partida->tarjetas as $tarjeta)
		
			//DEVUELVE LA CANTIDAD DE PAISES
		$respuesta[1]=$usuario->getCantidadPaises();
			//DEVUELVE EL NUMERO DE RONDA
		$respuesta[2]=$partida->ronda;
			//DEVUELVE EL NUMERO DE CAMBIOS QUE REALIZO EL USUARIO
		$respuesta[3]=$usuario->getNumeroDeCambio();
			
			//DEVUELVE LOS DATOS DEL OBJETIVO
			//PREGUNTA SI PIDE SUS DATOS O LOS DE OTRO USUARIO
		if($_GET['id_usuario'] == $_SESSION['id']){
			$objetivo = $usuario->getObjetivo();
			
			if($objetivo != NULL)
				$respuesta[4]=$objetivo->getId();
			else
				$respuesta[4]='objetivo_comun';
		}
		else{
				//PREGUNTA SI LA PARTIDA YA TERMINO SI TERMINO LE MUESTRA EL OBJETIVO DE TODOS
			if($partida->usuario_ganador != NULL){
				$objetivo = $usuario->getObjetivo();
				
				if($objetivo != NULL)
					$respuesta[4]=$objetivo->getId();
				else
					$respuesta[4]='objetivo_comun';
			}
			else{
				$objetivo = $usuario->getObjetivo();
				
				if($objetivo != NULL)
					$respuesta[4]="secreto";
				else
					$respuesta[4]='objetivo_comun';
			}
				
		}
			
	echo json_encode($respuesta);
}
}


?>