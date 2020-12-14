<?php
/*
*
*	ENVIA UNO O VARIOS MENSAJES
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
	require_once '../../clases/mensaje.php';

	if(isset($_SESSION['usuario'])){
		
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
		
		$cantidad=$partida->numero_mensaje - $_GET['numero_ultimo'];
		
		if($cantidad > 100)
			$cantidad =100;
		
		for($i=0;$i<$cantidad;$i++){
				$mensajes[$i]=$partida->chat[sizeof($partida->chat) - $cantidad+$i]->getMensaje();
		}
		$mensajes[$i]=$partida->numero_mensaje;
		echo json_encode($mensajes);
	}

?>