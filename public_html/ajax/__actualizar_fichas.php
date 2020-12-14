<?php
/*
*	DEVUELVE UN ARREGLO DE DOS DIMENSIONES DONDE ESTAN LA INFORMACION DE CADA PAIS: COLOR, CANTIDAD DE FICHAS,
*	ID DEL PROPIETARIO, NOMBRE DEL PAIS
*
*Arma un arreglo de 50 posiciones (una por cada pais) y dentro de cada elemento hace un sub arreglo
*En el que pone en la primera posicion el color
*En la segunda posicion la cantidad de fichas
*En la tercera posicion el id del propietario
*En la cuarta posicion el nombre del pais
*
*Finalmente lo envia en un json
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
		
		$arreglo_paises = $partida->paises;
		
		for($i=0;$i<50;$i++){
			$fichas[0][$i]=$arreglo_paises[$i]->getPropietario()->getColor();
			$fichas[1][$i]=$arreglo_paises[$i]->getFichas();
			$fichas[2][$i]=$arreglo_paises[$i]->getPropietario()->getId();
			$fichas[4][$i]=$arreglo_paises[$i]->getNombre();
				
				//se presupone que el pais tomado por el for no esta seleccionado ni para ataque ni defensa, despues se comprueba y si estan tomado
				//para alguna de las dos se le cambia el estado tal corresponda
				$fichas[3][$i]=0;
	
				//Si hay un objeto ataque
			if($partida->objeto_ataque!=NULL){
					//si el id del pais que esta en objeto ataque como atacante coincide con el pais que se esta seteando le pone 1 sino 0
				if($partida->objeto_ataque->getPaisAtaque()->getId()==$i){
					$fichas[3][$i]=1;
				}
				else{				
					if($partida->objeto_ataque->getPaisDefensa()!=NULL)
						if($partida->objeto_ataque->getPaisDefensa()->getId()==$i)
							$fichas[3][$i]=2;

				}
				
			}

				//Si hay un objeto objeto_reagrupar
			if($partida->objeto_reagrupar!=NULL){
					//si el id del pais que esta en objeto ataque como atacante coincide con el pais que se esta seteando le pone 1 sino 0
				if($partida->objeto_reagrupar->getPaisDe()->getId()==$i){
					$fichas[3][$i]=1;
				}
				else{				
					if($partida->objeto_reagrupar->getPaisDe()!=NULL)
						if($partida->objeto_reagrupar->getPaisA()->getId()==$i)
							$fichas[3][$i]=2;

				}
				
			}
			
			
			
					
		}
		
		echo json_encode($fichas);
		
		//echo $partida->objeto_ataque->getPaisAtaque()->getId().'fue';
		//print_r( $fichas);
	}
?>