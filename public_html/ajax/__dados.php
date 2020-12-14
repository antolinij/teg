<?php
/*
*
*	DEVUELVE EL RESULTADO DE LOS DADOS
*
*Se la llama con un get si el get'de' es igual a dados_atacante entrega los valores del pais atacnate
*Si dice dados_defensa entrega los dados de la defensa
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
	
	require_once '../../includes/dados.php';
	require_once '../../includes/limitrofes.php';
	
	if(isset($_SESSION['usuario'])){

		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
			
			if($_GET['de']=='dados_atacante'){
				if(isset($partida->objeto_ataque))
					echo json_encode($partida->objeto_ataque->getDatosTmpAtaque());
			}
				
			if($_GET['de']=='dados_defensa'){
				if(isset($partida->objeto_ataque))
					echo json_encode($partida->objeto_ataque->getDadosTmpDefensa());
			}
		}
			
		
?>