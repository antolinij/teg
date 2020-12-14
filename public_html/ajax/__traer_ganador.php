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
	if($partida->usuario_ganador != NULL){
		$respuesta[0] = $partida->usuario_ganador->getId();
		
		if($partida->usuario_ganador->getObjetivo() != NULL)
			$respuesta[1] = $partida->usuario_ganador->getObjetivo()->getId();
		else
			$respuesta[1] = '_comun';

		echo json_encode($respuesta);
	}

	}
?>