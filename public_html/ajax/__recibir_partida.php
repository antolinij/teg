<?php
/*
*
* EL USUARIO RECIBE LA PARTIDA MEDIANTE UN LINK GENERADO POR EL QUE SE LA TRANSFIERE
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
	
	$existe_usuario = 0;
		//PREGUNTO SI TIENE TODAS LAS VARIABLES DE SESSION NECESSARIAS PARA RECIBIR UNA PARTIDA
	if(isset($_SESSION['id']) && isset($_SESSION['id_entrega']) && isset($_SESSION['id_partida']) && isset($_SESSION['clave'])){	
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);	
		
			//COMPRUEBO QUE NO SEA PARTE YA DE LA PARTIDA, SI ES PARTE DEJA LA VARIABLE EXISTE_USUARIO EN 1
		for($i=0;$i<sizeof($partida->objetos_usuarios);$i++){
			if($partida->objetos_usuarios[$i]->getId() == $_SESSION['id'])
				$existe_usuario = 1;
		}
		
		//COMPRUEBO QUE PUEDO TRANSFERIR LA PARTIDA LLEGA UN 0 SI ES POSIBLE LA TRANSFERENCIA Y SINO UN 1
		if($partida->getTransferirPartida($_SESSION['id_entrega'],$_SESSION['clave']) == 0 && $existe_usuario ==0)	{	
				//OBTENGO EL OBJETO JUGADOR (ES EL QUE ENTREGO LA PARTIDA) Y LE TENGO QUE CAMBIAR 
				//EL ID LA URL DE LA IMAGEN Y EL NOMBRE

			$partida->getJugadorPorId($_SESSION['id_entrega'])->setModificarJugador($_SESSION['id'],$_SESSION['usuario'],$_SESSION['url_img']);
			

				//CARGO VARIABLES DE SESSION
			$_SESSION['rol'] = 0;
			$_SESSION['color'] = $partida->getJugadorPorId($_SESSION['id'])->getColor();
			$_SESSION['clave']= $partida->clave;
			
				//ELIMINIO LA VARIABLE DE SESSION ID_ENTREGA ESTO ES FUNDAMENTAL
			unset($_SESSION['id_entrega']);
			//GUARDO EL ARCHIVO Y LO DIRECCIONO A JUGAR
		crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
		header("Location: ../juego.php");
			
		}
		else{
				//SI NO PUEDE RECIBIR LA PARTIDA LO ENVIO AL INDEX
			$_SESSION['clave']= $partida->clave;
			unset($_SESSION['id_entrega']);
			header("Location: ../index.php");
		}

			


	}
	else
		header("Location: ../index.php");

?>