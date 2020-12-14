<?php
/*
*
*
*	DEVUELVE LAS RESERVAS REALIZADAS
*
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
		//print_r($partida->objetos_usuarios_temporales);
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
			
			
			//RECORRE LAS RESERVAS
			$j=0;
		for($i=0;$i<sizeof($partida->objetos_usuarios_temporales);$i++)
				//SI HAY UNA RESERVA, GUARDA LOS DATOS EN UN ARREGLO
			if($partida->objetos_usuarios_temporales[$i]['id'] != NULL ){
				$respuesta[$j] = $partida->objetos_usuarios_temporales[$i];
				$j++;
			}
				

		echo json_encode($respuesta);
		//crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
	}	
	
?>