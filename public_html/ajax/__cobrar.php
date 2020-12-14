<?php
/*
*
*		ENTREGA DOS FICHAS AL PAIS AL QUE HAGA REFERENCIA LA TARJETA SACADA
*
*Puede cambiar por cualquiera de las tarjetas que tenga, la condiciones son
*un solo cobro por vuelta, el pais al que hace referencia la tarjeta es del usuario,
*y no se puede cobrar mas de una vez una tarjeta al menos que se haya devuelvo y vuelto a sacar 
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
				$cobrar=array(0=>0);
				//comprueba que este en estado de sacar tarjeta
			if($partida->estado_usuario_turno == 2){
					//si devuelve un 1 es que se pudo hacer el cambio
				$cobrar[0]=$partida->turno_usuario->setCobrar($_GET['tarjeta1'],$_GET['tarjeta2'],$_GET['tarjeta3'],$_GET['tarjeta4'],$_GET['tarjeta5'],$partida);
				crear_archivo('../../partidas/'.$_SESSION['id_partida'],$partida);
				
				echo json_encode($cobrar);			
			}
		}
	}	
}

?>