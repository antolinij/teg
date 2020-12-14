<?php
/*
*
*	METE UN MENSAJE EN LA COLA DEL CHAT
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
	require_once '../../database.php';

if(isset($_SESSION['rol'])){
	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
		
		if(sizeof($partida->chat) == 100){
			for($i=0;$i<99;$i++)
				$partida->chat[$i]=$partida->chat[$i+1];
			$partida->chat[99] = new Mensaje($_SESSION['id'],$_POST['mensaje']);
			$partida->numero_mensaje++;
		}
		else{
			for($i=0;$i<100;$i++){
				if($partida->chat[$i]== NULL){
					$partida->chat[$i] = new Mensaje($_SESSION['id'],$_POST['mensaje']);	
					$partida->numero_mensaje++;
					$i=100;
				}
			}
		}	

		crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
	 
		save_msg($_SESSION['id'], $_POST['mensaje']);
	}
}

?>
