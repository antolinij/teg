<?php
/*
*
*	SE LLAMA PARA ENTREGAR TRES TARJETAS Y QUE TE ENTREGUEN LAS FICHAS QUE CORRESPONDE
*
*Se reciben por guet las cinco posiciones donde pueden haber tarjetas, si el usuario previo al llamado las selecciono
*el get de dicha tarjeta trae un 1 de lo contrario un 0,
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
	require_once '../../clases/incorporar.php';	

if(isset($_SESSION['rol'])){
	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
		$cambio=array(1);
	
			//comprueba que el que ejecuta el script se el usuario que tiene el turno
		if($partida->turno_usuario->getId() == $_SESSION['id']){
				//comprueba que este en estado de  incorporar ejercitos
			if($partida->estado_usuario_turno == 3){
			//si es igual a uno es que esta para cmabiar
				$cambio[0]=$partida->turno_usuario->setCambiarTarjetas($_GET['tarjeta1'],$_GET['tarjeta2'],$_GET['tarjeta3'],$_GET['tarjeta4'],$_GET['tarjeta5'],$partida);
				crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
	
				echo json_encode($cambio);			
			
			}
		}
	}
}

?>