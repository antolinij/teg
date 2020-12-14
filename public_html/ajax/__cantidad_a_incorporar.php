<?php
/*
*
*	ENVIA LA CANTIDAD DE FICHAS QUE PUEDE INCORPORAR POR CONTINENTES, CAMBIO Y LIBRES
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
	require_once '../../clases/incorporar.php';
	require_once '../../includes/funciones_archivo.php';
	require_once '../../clases/reagrupar.php';
	
	
	if(isset($_SESSION['usuario'])){
		
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
			//indico las fichas libres a poner por el usuario
		$cantidadIncorporar[0]=$partida->turno_usuario->getObjetoIncorporar()->getLibres();
			//indico las fichas que pone por el el cambio, si es que lo realizo
		$cantidadIncorporar[1]=$partida->turno_usuario->getObjetoIncorporar()->getPorCambio();
			//traigo en un arreglo las fichas que debe poner por cambio, en 0 cuantas fichas poner por america del norte, si es que lo tiene, de lo contrario 0
			//en 1 cuantas para america del sur y asi para cada uno
		$continentes=$partida->turno_usuario->getObjetoIncorporar()->getFichasPorContinentes();
			//sumo todas las fichas que pone por continente, 
		$cantidadIncorporar[2]=$continentes[0]+$continentes[1]+$continentes[2]+$continentes[3]+$continentes[4]+$continentes[5];
			//la suma de todas las fichas que pone por continente
		$cantidadIncorporar[3]=$partida->turno_usuario->getObjetoIncorporar()->getFichasTotales();
			//entre cuantas fichas pone por cada continente de forma discriminada en la posicion 4 esta america del norte en la 5 america del sur y asi....
		$cantidadIncorporar[4]=$continentes[0];
		$cantidadIncorporar[5]=$continentes[1];
		$cantidadIncorporar[6]=$continentes[2];
		$cantidadIncorporar[7]=$continentes[3];
		$cantidadIncorporar[8]=$continentes[4];
		$cantidadIncorporar[9]=$continentes[5];
		
	echo json_encode($cantidadIncorporar);
	}
?>