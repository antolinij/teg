<?php
/*
*
*	INCORPORA FICHAS EN EL PAIS QUE SE HAGA CLICK
*
*El pais debe ser del usuario que llama el script, este tiene que estar en turno y en estado de incorporacion
*si este usuario tiene fichas por contienente hace que solamente se puedan poner esas en el continente
*si tiene fichas por cambio se pueden poner en cualquier pais(son libres)
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
	
	if(isset($_SESSION['usuario'])){
		$enviar=array(0=>0);
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
			//compruebo que el qwue ejecuta el script sea el usuario en turno
			//y que  este en fase de incorporacion.
			if($partida->turno_usuario->getId() == $_SESSION['id'] && $partida->estado_usuario_turno == 3){	
					//compruebo que el pais en el que quiera incorporar sea del que llama al script
				if($partida->paises[$_GET['id_pais']]->getPropietario()->getId() == $_SESSION['id']){
						//cargo un 1 en el arreglo para informar que se pudo incorporar con exito
					
						$respuesta=$partida->turno_usuario->getObjetoIncorporar()->setAgregar($partida->paises[$_GET['id_pais']],$partida);
					
						if($respuesta==5)
							$enviar=array(0=>5);
						else
							$enviar=array(0=>0);
						
						crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
						
						echo json_encode($enviar);
						
				}

			}
	}
?>