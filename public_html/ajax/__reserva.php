<?php
/*
*
*	RESERVA UN LUGAR Y COLOR DE UN SUARIO EN UNA PARTIDA, LO HACE POR ALGUNOS SEGUNDOS, SI EN ESE TIEMPO
*	NO SE INGRESA, SE PIERDE EL TURNO, SI NO PUEDE RESERVAR EL LUGAR DEVUELVE EL ARREGLO CON NULL
*
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
	
	//esperar jugadores
	//include 'esperar_jugadores.php';
	
	//abro partida
if(isset($_SESSION['usuario'])){

	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);		
	if($partida->clave == $_SESSION['clave']){
	
		//print_r($partida->objetos_usuarios_temporales);
			//COMPROBAR SI ALGUNA DE LAS RESERVAS ESTAN VENCIDAS, SI ESTA VENCIDA, LA IGUALO A NULL
		for($i=0; $i< sizeof($partida->objetos_usuarios_temporales) ;$i++){
			if(isset($partida->objetos_usuarios_temporales[$i])){
					$tiempo = time() - ((int)$partida->objetos_usuarios_temporales[$i]['tiempo'] + 30);
				if( $tiempo > 0 ){
					$partida->objetos_usuarios_temporales[$i]['id']=NULL;
					$partida->objetos_usuarios_temporales[$i]['tiempo']=NULL;
					$partida->objetos_usuarios_temporales[$i]['color']=NULL;
				}
			}
			else{
					$partida->objetos_usuarios_temporales[$i]['id']=NULL;
					$partida->objetos_usuarios_temporales[$i]['tiempo']=NULL;
					$partida->objetos_usuarios_temporales[$i]['color']=NULL;
			}
		}
			
			
		$respuesta=array('id'=>NULL,'tiempo'=>NULL,'color'=>NULL);
		


		
			//CUENTA LA CANTIDAD DE LUGARES RESERVADOS
		$temporales_utilizados=0;
		for($i=0;$i<sizeof($partida->objetos_usuarios_temporales);$i++)
			if($partida->objetos_usuarios_temporales[$i]['id'] != NULL )
				$temporales_utilizados++;
				
			//SI QUEDA UN LUGAR LIBRE, EN LA PARTIDA REAL Y ESE LUGAR NO ESTA RESERVADO, LO RESERVA
		if( ($partida->usuarios_efectivos + $temporales_utilizados) <= sizeof($partida->objetos_usuarios) ){
				//RECORRO EL ARREGLO DE USUARIOS TEMPORALES, HASTA ENCONTRAR UN LUGAR LIBRE
			for( $i=0; $i <= sizeof($partida->objetos_usuarios_temporales); $i++  ){
				if($partida->objetos_usuarios_temporales[$i]['id'] == NULL){
						//LE ASIGNO LOS VALORES DEL USUARIO QUE RESERVO
						
					$partida->objetos_usuarios_temporales[$i]=array('id'=>$_SESSION['id'],'tiempo'=>time(),'color'=>$_GET['color'],'nombre'=>$_SESSION['usuario']);

					$respuesta = $partida->objetos_usuarios_temporales[$i];

						//FUERZO LA SALIDA EL FOR
					$i=sizeof($partida->objetos_usuarios_temporales)+1;
				}
			}
		}
		crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
		echo json_encode($respuesta);
		
	}
}	
	
?>