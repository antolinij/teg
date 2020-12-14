<?php
/*
*	DEVUELVE LAS TARJETAS QUE TIENE EL USUARIO
*
*devuelve un arreglo bidimensional la primer dimension tiene 5 posiciones una por cada posible tarjeta
*si el usuario no tiene cinco tarjetas se completa con NULL
*
*la segunda dimension tiene 3, nombre pais, logo,esta(se cobro o no). En ese orden
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


if(isset($_SESSION['usuario'])){
	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
	
	//creo $respueta=0, y si no se modifica, la respuesta es porque ese jugador no tenia tarjeta
	//en 0 trae el nombre del pais en 1 trae el nombre del dibujo y en 2 pone 1 0 si no fue cobrado y un 1 si fue cobrado
	$traeTarjetas=array(
		0=>array(0=>'',1=>NULL,2=>NULL),
		1=>array(0=>'',1=>NULL,2=>NULL),
		2=>array(0=>'',1=>NULL,2=>NULL),
		3=>array(0=>'',1=>NULL,2=>NULL),
		4=>array(0=>'',1=>NULL,2=>NULL)
		
	);
			//trae al jugador que llamo el script
		$usuario=$partida->getJugadorPorId($_SESSION['id']);
			//recorro el arreglo tarjeta del jugado		
			
			$i=0;
		foreach($usuario->getTarjetas() as $tarjeta){
			if($tarjeta != NULL){
				$traeTarjetas[$i][0]=$tarjeta->getNombrePais($partida);
				
				switch($tarjeta->getLogo()){
					case 0:	
						$traeTarjetas[$i][1]='canon.png';
					break;
					case 1:	
						$traeTarjetas[$i][1]='globo.png';
					break;
					case 2:	
						$traeTarjetas[$i][1]='barco.png';
					break;
					case 3:	
						$traeTarjetas[$i][1]='comodin.png';
					break;
				}
					
					//en 2 pongo el estado(cobrada o no)
				$traeTarjetas[$i][2]=$tarjeta->getEstado();
				$i++;
			}
		}//foreach($partida->tarjetas as $tarjeta)
	
	
	echo json_encode($traeTarjetas);

}


?>