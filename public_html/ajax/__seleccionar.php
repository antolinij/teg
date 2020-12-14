<?php
/*
*
*	CREA EL OBJETO ATAQUE Y LE CARGA EL PAIS DE Y EL PAIS A
*
*Introduce dentro de ataque el pais que ataca y el pais que es atacado
*
*/

	session_start();

	require_once '../../clases/reagrupar.php';
	
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
			//si es el turno del usuario que la llama y esta en estado de ataque 
			//TAMBIEN TENGO QUE HACER ESTO MISMO PARA CUANDO EL TURNO DEL USUARIO ESTE EN 1 QUE ES REAGRUPANDO
		if( ($partida->turno_usuario->getId() == $_SESSION['id']) && ($partida->estado_usuario_turno == 0 ) ){
					//si no existe el objeto ataque lo creo y le mando ocmo pais atacante el pais que llego por el id
				if($partida->objeto_ataque==NULL)
				{
							//creo el objeto ataque y le pongo el pais atacante. el menos uno al valor que trae del get es porque en el html los paises empiezan con 1 y en losa arreglos con 0

						$partida->objeto_ataque= new Ataque($partida->paises[$_GET['id_pais']]);
						
						if($partida->objeto_ataque->getPaisAtaque()!=NULL)
							$respuesta[0]=1;
						else{
							$partida->objeto_ataque=NULL;
							//nose si esto esta bien
							$respuesta[0]=0;
						}
							
						crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);

				}
					//si el objeto ataque ya existe
				else
				{
					//Pregunto si no se bloqueo ataque, se bloquea cuando el atacante tira los dados
					if($partida->objeto_ataque->getBloquear() == 0){
						$respuesta[0]=$partida->objeto_ataque->setDefensa($partida->paises[$_GET['id_pais']]);
						
						//si el pais que se intento poner como atacado es el mismo que el atacante se anula el ataque
						if(($partida->objeto_ataque->getPaisAtaque()->getId()) == $partida->paises[$_GET['id_pais']]->getId()){
							$partida->objeto_ataque=NULL;
					}

					
					crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					}

				}				
		echo json_encode($respuesta);
		}
			//es el else del segundo if
		else{
			////////////////////////////////////////////////////////////////////// if para reagrupar
				
			if( ($partida->turno_usuario->getId() == $_SESSION['id']) && ($partida->estado_usuario_turno == 1 ) ){
						//si no existe el objeto ataque lo creo y le mando ocmo pais atacante el pais que llego por el id
					if($partida->objeto_reagrupar == NULL)
					{
							$partida->objeto_reagrupar = new Reagrupar($partida->paises[$_GET['id_pais']]);						
							if($partida->objeto_reagrupar->getPaisDe()!=NULL)
								$respuesta[0]=1;
							else{
								$partida->objeto_reagrupar=NULL;
								//nose si esto esta bien
								$respuesta[0]=0;
							}						
							crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					}
						//si el objeto ataque ya existe
					else
					{
							$respuesta[0]=$partida->objeto_reagrupar->setPaisA($partida->paises[$_GET['id_pais']]);
							//si el pais que se intento poner como atacado es el mismo que el atacante se anula el ataque
							if(($partida->objeto_reagrupar->getPaisDe()->getId()) == $partida->paises[$_GET['id_pais']]->getId()){
								$partida->objeto_reagrupar=NULL;
								crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
							}
							crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
					}				
					echo json_encode($respuesta);			
				
			}
			
			//////////////////////////////////////////////////////////////////// fin reagrupar
		}
	}
}
	

?>