<?php
/*
*
*	HACE QUE EL USUARIO EN TURNO PUEDA AVANZAR SU PROCESO
*
* cuando se la llama se le pasa el estado al que se quiere pasar, supongamos si esta atacando puede pasar a reagrupar a tarjetas o a finalizar
* no se puede retroceder una vez que se avanzo tampoco se puede saltear el estado incorporar ese se avanza solo cuando incorporo todo lo que debe incorporar
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
			//compruebo que el qwue ejecuta el script sea el usuario en turno
			//y que no este en fase de incorporacion. la incorporacion no se puede avanzar, termina cuando el usuario ingresa todas las fichas 
			///y tampoco en fase de enviar tropas a un pais ganado
			//y tampoco se haya creado el objeto ataque, o sea (mientras no haya tirado los dados el usuario en turno)
		if($partida->turno_usuario->getId() == $_SESSION['id'] &&( $partida->estado_usuario_turno !=3) && ( $partida->estado_usuario_turno !=4)  && ( $partida->objeto_ataque == NULL) && ( $partida->objeto_reagrupar == NULL)){	
			
				//avanzo al estado reagrupar
			if($_GET['accion'] == 'selector_reagrupar'){
				if($partida->estado_usuario_turno!=2)
						//pongo el estado del turno en 1 que es reagrupar
					$partida->estado_usuario_turno=1;
						//rompo el objeto ataque para que no queden seleccionadas fichas
					$partida->objeto_ataque=NULL;
					
			}
	
			if($_GET['accion'] == 'selector_tarjeta'){
				
				$partida->estado_usuario_turno=2;
				
					//rompo el objeto ataque para que no queden seleccionadas fichas
				$partida->objeto_ataque=NULL;
					//rompo el objeto reagrupar para que no queden seleccionadas fichas
				$partida->objeto_reagrupar=NULL;				
				
			}
			
			if($_GET['accion'] == 'finalizar'){
					//si finaliza el usuario hace que juegue el nuevo usuario
				$partida->setAvanzarTurno($partida);
				
			}
			
			
			
			crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
		}
		
	}	
			
}

?>