<?php
/*
*
*	CALCULA CUANTAS FICHAS SE PUEDEN ENVIAR A UN PAIS YA SEA POR HABERLO GANADO O POR REAGRUPARSE (ESTA FUNCION PARECE QUE TIENE UN ERROR PORQUE CADA TANTO FALLA SOBRE
*	TODO FALLA CUANDO HAY QUE REAGRUPARSE)
*
*	devuelve un json con el numero maximo de fichas qeu se pueden usar, en el cliente se usa ese numro para armar un select
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
	require_once '../../clases/reagrupar.php';
	
	if(isset($_SESSION['usuario'])){
		
		$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
		
			//compruebo que sea el usuario que esta en turno el que la llama
		if($partida->turno_usuario->getId() == $_SESSION['id'])
				//compruebo que el usuario tenga el estado de que gano un pais
			if($partida->estado_usuario_turno==4){
				//calculo cuantas fichas tiene y le resto una porque si o si tiene que dejar una en el pais que ataco
				$enviar=$partida->objeto_ataque->getPaisAtaque()->getFichas()-1;
				 //calculo si la cuaenta anterior da mas que tres ya que no se puede enviar mas de tres a un pais ganado
				
				if($enviar >= 2)
					$enviar=array(0=>'2');
				else{
					//
					$tmp_enviar=$enviar;
					$enviar=array(0=>$tmp_enviar);
				}
				
				echo json_encode($enviar);
			}
				//compruebo que el usuario tenga el estado reagrupar
			if($partida->estado_usuario_turno==1 && $partida->objeto_reagrupar!= NULL){
				//calculo cuantas fichas tiene y le resto una porque si o si tiene que dejar una en el pais desde el que envia
				$tmp_enviar=$partida->objeto_reagrupar->getPaisDe()->getFichas()-1;
					//a la cantidad que tiene le resto la cantidad que puede haber recibido de otros paises
					//esto es porque no se puede hacer una cadena en el reagrupado
				$tmp_enviar-=$partida->objeto_reagrupar->getPaisDe()->getRecibido();
				 //calculo si la cuaenta anterior da mas que tres ya que no se puede enviar mas de tres a un pais ganado				
				$enviar=array(0=>$tmp_enviar);
				echo json_encode($enviar);
			}
			
	}

?>