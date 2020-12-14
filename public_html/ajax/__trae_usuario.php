<?php
/*
*	MEDIANTE UN ID CONSIGUE EL NOMBRE, IMG Y COLOR DE FICHAS DE DICHO JUGADOR
*
*Le llega por GET el id del usuario del que se quieren conocer los datos
*devuelve un arreglo que en la clave 'nombre' tiene el nombre del usuario
*en la clave 'url_img' tiene la url de la imagen del usuario
*y en la clave 'color' tiene el color de la ficha del usuario
*
*Finalmente se envia el json
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
	
	//ESTA TENDRIA QEU BUSCAR EN LA PARTIDA EL USUARIO QUE TENGA EL IDE QUE LLEGA POR GET Y DEVOLVER LOS VALORES DE ESE USUARIO	
	
	//abro partida
		if(isset($_SESSION['usuario'])){
		
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);			
			
			for($i=0;$i<sizeof($partida->objetos_usuarios);$i++){
					if($partida->objetos_usuarios[$i]->getId() == $_GET['id']){
						 $usuario = array('nombre'=>$partida->objetos_usuarios[$i]->getNombre(),
						 'url_img'=>$partida->objetos_usuarios[$i]->getUrlImg(),
						 'color'=>$partida->objetos_usuarios[$i]->getColor());
						 
						 	//PREGUNTO SI EL USUARIO FU ELIMINADO, SI ES ELIMINADO LO INFORMO ENVIANDO eliminado EN LA POSICION ESTADO
						 	//Y DEL LADO DEL CLIENTE LE PONGO TRANSPARENCIA PARA QUE SE NOTE
						 if($partida->objetos_usuarios[$i]->getEliminado() != NULL)
						 	$usuario['estado']='eliminado';
						 else
						 	$usuario['estado']='en_juego';
						 	
 	 					echo json_encode($usuario);
 	 					//Fuerza salida
 	 					$i=sizeof($partida->objetos_usuarios);
					}
						
			}
		}
		
?>