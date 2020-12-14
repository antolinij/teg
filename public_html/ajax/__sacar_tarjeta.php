<?php
/*
*
*	ENTREGO AL USUARIO UNA TARJETA (LA INGRESO DIRECTAMENTTE EN EL ARREGLO DE LA INSTANCIA DE USUARIO)
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
	
	
if(isset($_SESSION['rol'])){

	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
	
			//comprueba que el que ejecuta el script se el usuario que tiene el turno
		if($partida->turno_usuario->getId() == $_SESSION['id']){
				//comprueba que este en estado de sacar tarjeta
			if($partida->estado_usuario_turno == 2){
					//pregunta si el usuario gano los paises necesarios para sacar tarjeta
				if($partida->turno_usuario->getMerezcoTarjeta()){
				
						//le entrego al jugador la tarjeta
					$partida->turno_usuario->setTarjeta($partida->tarjetas[0]);
				
						//avanzo todo el arreglo y dejo en NULL el ultimo elemento, es como si saco el primero y avanza toda la cola dejando el ultimo lugar libre
					for($i=0;$i<sizeof($partida->tarjetas)-1;$i++){
						$partida->tarjetas[$i]=$partida->tarjetas[$i+1];
					}
					$partida->tarjetas[$i]=NULL;
						
						//avanzo el contador de tarjetas sacadas
					$partida->tarjetas_sacadas++;
					
						//me parece que el comentario de abajo no va, que esto lo que hace es decir que el usuario 'no gano ningun pais', es para la proxima vuelta tambien hay que hacerlo al principio de la ronda
						//como ya cambio el pais pongo el sacar tarjetas en 0 para que no pueda volver a cobrar
					$partida->turno_usuario->setGanePaisReset();
						
						//dice que el usuario saco una tarjeta 
					$partida->turno_usuario->setSaqueTarjeta();
						
						//si se sacaron todas las tarjetas mezclo las que se devolvieron(el arreglo solamente tiene tarjetas devueltas)
					if(sizeof($partida->tarjetas)-$partida->tarjetas_devueltas == 0){
						
							//mezclo el arreglo
						shuffle($partida->tarjetas);
						
							//reseteo el contador de tarjetas devueltas
						$partida->tarjetas_devueltas=0;
						$partida->tarjetas_sacadas=0;
						

						
					}//f($partida->tarjetas_sacadas!=50)
		
		
				}//if($partida->turno_usuario->getGanePais() == 1)
		}//if($partida->estado_usuario_turno == 2)
			
				crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
		}//if($partida->turno_usuario->getId() == $_SESSION['id'])
	
	}
}

?>