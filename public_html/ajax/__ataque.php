<?php
/*
*
*	GENERA UN OBJETO ATAQUE Y LE CARGA EL ATACANTE Y EL ATACADO Y TIRA LOS DADOS
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
	
	require_once '../../includes/dados.php';
	require_once '../../includes/limitrofes.php';
	
if(isset($_SESSION['rol'])){

	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
	
			//comprueba que sean distinto los propietarios de los paises
			
		if($partida->objeto_ataque->getPaisAtaque()->getPropietario()->getId() != $partida->objeto_ataque->getPaisDefensa()->getPropietario()->getId())
			//comprueba que el que ejecuta el script se el usuario que tiene el turno
		
			if($partida->turno_usuario->getId() == $_SESSION['id'])
					if($partida->objeto_ataque->setDadosAtaque()==0){
						$partida->objeto_ataque->setBloquear('0');
						$partida->objeto_ataque=NULL;
					
						crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					}
					else{
					
					//NO ESTA ANDANDO BIEN EL QUE BLOQUEA
					$partida->objeto_ataque->setBloquear('1');
					//$dados_ataque=$partida->objeto_ataque->getDatosAtaque();
					
					crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
	
					}
				else{
					//comprueba si el que llama al script es el propiestario del pais defensa
					if($partida->objeto_ataque->getPaisDefensa()->getPropietario()->getId() == $_SESSION['id'])
						//comprueba que ya haya tirado el atacante
						if(sizeof($partida->objeto_ataque->getDatosAtaque())>0)
						{
						
						$partida->objeto_ataque->setDadosDefensa();
						
						$dados_defensa=$partida->objeto_ataque->getDadosDefensa();
						//saco fichas de quien corresponda
						$partida->objeto_ataque->setRetirar();
						
							//gano el pais
						if($partida->objeto_ataque->getPaisDefensa()->getFichas() == 0){
								//MODIFICO EL PROPIETARIO DEL PAIS GANADO, PONIENDOLE EL ID DE NUEVO GANADOR
							$partida->objeto_ataque->getPaisDefensa()->setPropietario($partida->objeto_ataque->getPaisAtaque()->getPropietario());		
							
							//esta de mas me parece
							$partida->objeto_ataque->setBloquear(0);
								
								//envio del pais atacante al pais ganado una ficha
							$partida->objeto_ataque->getPaisAtaque()->setFichas(-1);
								//las pongo en el pais nuevo
							$partida->objeto_ataque->getPaisDefensa()->setFichas(1);
							
							
							//digo que el usuario atacante esta en el turno enviar tropas al pais ganado	
							$partida->estado_usuario_turno=4;
							
							
							//digo qeu el usuario gano un pais
							$partida->turno_usuario->setGanePais(1);
							
								
						}
						else{
						//Desbloqueo el objeto ataque
						$partida->objeto_ataque->setBloquear(0);
							//if($partida->objeto_ataque->getPaisAtaque()->getFichas() == 1)
							//	$partida->objeto_ataque=NULL;
						}
						
						
						crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					
						
					}
				
			}
	}
}
	
?>