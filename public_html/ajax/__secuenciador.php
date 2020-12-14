<?php
/*
*
*	DEVUELVE EL ESTADO DEL JUEGO, INFORMADO EL USUARIO EN TURNO Y EN EL QUE ESTE ESTA
*	TAMBIEN INFORMA EL USUARIO QUE SE TIENE QUE DEFENDER, SI ES QUE SE HIZO UN ATAQUE
*
*retorna un arreglo de 4 dimensiones en la primera esta el id del usuario en turno
*en la segunda el estado del turno del usuario (es un numero entre(0 y 4) haciendo referencia a si se esta en 
*atacando,reagrupando,tarjeta,incorporando ejercito o enviando tropas. Respectivamente
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
	
	
	if(isset($_SESSION['usuario'])){
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
		
		$secuenciador[0]=$partida->turno_usuario->getId();
		$secuenciador[1]=$partida->estado_usuario_turno;
		$secuenciador[2]=$_SESSION['id'];
		
		//envia el id del usuario que se debe defender
			//si existe el objeto ataque
		if($partida->objeto_ataque != NULL)
				//si ya esta seteado el pais que debe defenderse
			if($partida->objeto_ataque->getPaisDefensa() !=NULL)
					//pregunta si los dados del ataque son distintos de NULL(es para evitar llamar a un metodo que no esta definido)
				if($partida->objeto_ataque->getBloquear() == 1)
						//si ya tiro los dados el atacante					
					//COMENTE EL IF PORQUE NO ES NECESARIO ESPERAR
					//if(sizeof($partida->objeto_ataque->getDadosAtaque())>0)
						$secuenciador[3]=$partida->objeto_ataque->getPaisDefensa()->getPropietario()->getId();

		
		
			
		echo json_encode($secuenciador);

	
	}

?>