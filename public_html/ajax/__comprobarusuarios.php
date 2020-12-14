<?php
session_start();
/*
*
*	DEVUELVE EL NOMBRE DE LOS JUGADORES QUE INGRESARON HASTA EL MOMENTO
*
*
*/

	require_once '../../clases/pais.php';
	require_once '../../clases/continente.php';
	require_once '../../clases/usuarios.php';
	require_once '../../clases/tarjeta.php';
	require_once '../../clases/objetivos.php';
	require_once '../../clases/partida.php';
	require_once '../../clases/ataque.php';
	require_once '../../includes/funciones_archivo.php';

	if(isset($_SESSION['usuario'])){//Si existe sesion 
			//esta funcion guarda en la variable $partida el objeto que esta guardado en el archivo cuyo nombre esta en $_SESSION['id_partida']
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
		
		
		if($partida->usuarios_efectivos==sizeof($partida->objetos_usuarios))//Analiza si ya ingresaron todos los jugadores
			echo '1';
		else
		{
			if($partida->usuarios_efectivos > 1){ //si ingreso al menos un jugador mas aparte del anfitrion
				$usr_tmp=$partida->objetos_usuarios;//traigo el arreglo de objeto_jugador
				$valor = array($partida->usuarios_efectivos);
				for($i=0;$i<$partida->usuarios_efectivos;$i++){//gira tantas veces como cantidad de usarios efectivos haya hasta el momento
					
						
						$valor [$i] = $usr_tmp[$i]->getNombre();
	
				}
				echo json_encode($valor);
			}
			else //si no ingreso al menos un jugador mas
				echo '0';
		}
	
	}
	else//si no existe session
		header('Location: index.php');
?>