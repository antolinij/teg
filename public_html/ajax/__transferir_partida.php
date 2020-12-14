<?php
/*
*
* EL USUARIO TRANSFIERE SU PARTIDA A OTRO USUARIO QUE INGRESA AL LINK QUE GENERO EN ESTA FUNCION EL ENTREGADOR
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
	
	
	
	$respuesta="no";
	if(isset($_SESSION['rol'])){	
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);	
			//PREGUNTA PRIMERO SI LA CLAVE ES LA CORRECTA ES PARA FRENAR A GENTE QUE QUIERA HACER DA„O
			//DESPUES PREGUNTA SI LA PARTIDA NO ESTA FINALIZADA
			//SI SE CUMPLEN ESTAS DOS CONDICIONES PUEDE TRANSFERIR LA PARTIDA
		if($_SESSION['clave'] == $partida->clave && $partida->usuario_ganador == NULL){
		
			//ENVIO EL ID DEL USUARIO PARA VER SI PUEDO GENERAR UNA TRANSFERENCIA
			$clave = $partida->setTransferirPartida($_SESSION['id']);
			if($clave != 0){
				$respuesta= 'tegame.com.ar/?id_entrega='.$_SESSION['id'].'&id_partida='.$_SESSION['id_partida'].'&clave='.$clave;
					//ESCRIBO LA URL EN EL CHAT
				if(sizeof($partida->chat) == 100){
					for($i=0;$i<99;$i++)
						$partida->chat[$i]=$partida->chat[$i+1];
					$partida->chat[99] = new Mensaje($_SESSION['id'],'tegame.com.ar/?id_entrega='.$_SESSION['id'].'&id_partida='.$_SESSION['id_partida'].'&clave='.$clave);
					$partida->numero_mensaje++;
				}
				else{
					for($i=0;$i<100;$i++){
						if($partida->chat[$i]== NULL){
							$partida->chat[$i] = new Mensaje($_SESSION['id'],'tegame.com.ar/?id_entrega='.$_SESSION['id'].'&id_partida='.$_SESSION['id_partida'].'&clave='.$clave);	
							$partida->numero_mensaje++;
							$i=100;
						}
					}
				}	

			
				session_destroy();
				crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);	
			}
	
		}
	}
	if($respuesta="no")
		header("Location: ../juego.php");
	else
		header("Location: ../logout.php");

?>