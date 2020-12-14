<?php
/*
*
*	ENVIA EL ID DE LOS USUARIO QUE FUERON INGRESANDO
*
*crea un arreglo con los usuario que fueron ingresando, cuando ya ingresron todos, en la ultima posicion del arreglo pone un 0
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
	
	//esperar jugadores
	//include 'esperar_jugadores.php';
	
	//abro partida
	if(isset($_SESSION['usuario'])){
	
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
		
		for($i=0;$i<$partida->usuarios_efectivos;$i++){
					//devuelve el id de los jugadores incorporados
					$respuesta[$i]=$partida->objetos_usuarios[$i]->getId();
		}
		//si ya estan todos los usuarios indica que termina la partida enviando un cero al final del arreglo
		if($partida->usuarios_efectivos==sizeof($partida->objetos_usuarios))
			$respuesta[$i]=0;
			
		echo  json_encode($respuesta);

	}	
?>