<?php
/*
*
*	DEVUELVE EL NUMERO DE RONDA
*
*
*/
session_start();

	require_once '../../clases/partida.php';

	require_once '../../includes/funciones_archivo.php';

	
	if(isset($_SESSION['rol'])){
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
		$ronda = $partida->ronda;
		echo json_encode($ronda);
	}
	
?>