<?php
/*
*
*	ENVIA LAS FICHAS DESDE UN PAIS COLONIZADOR A UNO COLONIZADO
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
	require_once '../../clases/reagrupar.php';
	
	$respuesta=array(0=>'0');
	
if(isset($_SESSION['rol'])){

	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
		
			//compruebo que sea el usuario que esta en turno el que la llama
		if($partida->turno_usuario->getId() == $_SESSION['id']){
				//compruebo que el usuario tenga el estado de que gano un pais
			if($partida->estado_usuario_turno==4){
				
				//saco fichas del pais de origen y las pongo en destino
					//comprueba que no quiera sacar mas fichas de las que se puede, si bien ya el select no deja enviar mas de las posibles, esto evita que se pueda
					//hacer llamando al script directamente si es mayor lo igualo al maximo posible
						//traigo la cantidad de fichas que tiene le pais atacante
						$cant_fichas=$partida->objeto_ataque->getPaisAtaque()->getFichas()-1;
				
						//hace que can_fichas no pueda tener mas de tres
					if($cant_fichas > 3)
						$cant_fichas=3;	
						
						//si las fichas que intento mover son menor o igual cantidad de las que puedo lo hago 
					if($_GET['cantidad']<= $cant_fichas )	{	
				
					$partida->objeto_ataque->getPaisAtaque()->setFichas(-$_GET['cantidad']);
						//las pongo en el pais nuevo
					$partida->objeto_ataque->getPaisDefensa()->setFichas($_GET['cantidad']);
						//rompo el objeto ataque
						
					$partida->objeto_ataque=NULL; 
						//vuevlo al usuario a estado de atacante
					$partida->estado_usuario_turno=0;
					
					crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					$respuesta=array(0=>'1');
					}

			//llave del if que comprueba que invoca el script porque gano un pais	
			}
			
				///pregunta si esta en estado reagrupar
			if($partida->estado_usuario_turno==1){
				
				//saco fichas del pais de origen y las pongo en destino
					//comprueba que no quiera sacar mas fichas de las que se puede, si bien ya el select no deja enviar mas de las posibles, esto evita que se pueda
					//hacer llamando al script directamente si es mayor lo igualo al maximo posible
						//traigo la cantidad de fichas que tiene el pais de pero le 
						//saco las que puede haber llegado a recibir de otro pais
						$cant_fichas=$partida->objeto_reagrupar->getPaisDe()->getFichas()-1;
						$cant_fichas-=$partida->objeto_reagrupar->getPaisDe()->getRecibido();

						
						//si las fichas que intento mover son menor o igual cantidad de las que puedo lo hago 
					if($_GET['cantidad']<= $cant_fichas )	{	
				
					$partida->objeto_reagrupar->getPaisDe()->setFichas(-$_GET['cantidad']);
						//las pongo en el pais nuevo
					$partida->objeto_reagrupar->getPaisA()->setFichas($_GET['cantidad']);
						///tambien cargo recibio aca pongo el numero de fichas que fuer recibiendo durante toda una reagrupada
						///este numero se pone de nuevo a cero cuando finaliza el turno
					$partida->objeto_reagrupar->getPaisA()->setRecibido($_GET['cantidad']);
						//rompo el objeto ataque
						
					$partida->objeto_reagrupar=NULL; 
					
					crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					$respuesta=array(0=>'1');
					}
			//llave del if que comprueba que invoca el script porque esta reagrupando
			}
			
			
			
			
			
		//////////fin llave usuario que esta en turno es el que la llame	
		}
	}	
}
		//envia un 1 si se pudo hacer el envio y un cero si no se pudo enviar
	echo json_encode($respuesta);

?>