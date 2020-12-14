<?php

if(!isset($_SESSION['rol'])){

	if($_GET['accion']=="crear"){
		$_SESSION['ultima_consulta']=0;
		$_SESSION['ultima_consulta_bis']=0;
		
		//$_SESSION['usuario']=$_GET['nombre'];
		$_SESSION['numero_jugadores']=$_GET['numero_jugadores'];
		//Donde dice 10 va el id del jugador que crea la partida
		//$_SESSION['id']=$_GET['id'];
		$_SESSION['id_partida']=$_SESSION['id'];
		//el valor va de acuerdo al color de fichas que elije
		$_SESSION['color']=$_GET['color'];
		//el rol es uno para anfitrion y 0 para los demas
		$_SESSION['rol']=1;
		$_SESSION['clave']=rand(1,999999);
		//hay uqe traer img
		//$_SESSION['url_img']= $_GET['url_img'];
		
		
		$anfitrion = new Usuario($_SESSION['usuario'],$_SESSION['id'],$_SESSION['color'],$_SESSION['url_img']);
		$partida= new Partida($anfitrion,$_SESSION['numero_jugadores'], $_SESSION['clave']);
		
		$ingreso=0;
			//lleva los puntos adelante porque es como si estuviera este escript en el directorio del que lo incluye o sea un directorio distinto
			insertar_usuario($_SESSION['usuario'], $_SESSION['id'], $_SERVER[REMOTE_ADDR], $_SESSION['id'], 1);
		crear_archivo("../partidas/".$_SESSION['id_partida'],$partida);
	}
	
	
	
		//VOY A TENER QUE TENER CUIDADO CON LA EXCLUSION MUTUA TENER EN CUENTA//////////////////////////////////////////////////////////////
	if($_GET['accion']=="Unirse"){
	 
		$partida = abrir_archivo("../partidas/".$_SESSION['id_partida']);//Falta comprobar si se pudo unir y si no se puede unir destruir la session
			//Las posibilidades por las uqe no se pudo unir son la partida se lleno, el color ya estaba usado.
			//hay que ver la exclusion mutua entre el momento de entrar a una partida y el momento de guardarla
		if($partida->clave == $_GET['clave']){
		
			for($i=0; $i< sizeof($partida->objetos_usuarios_temporales) ;$i++)
				if($partida->objetos_usuarios_temporales[$i]['id'] == $_SESSION['id'] ){
				
					$tiempo = time() - ((int)$partida->objetos_usuarios_temporales[$i]['tiempo'] + 30);
					if($tiempo < 0){
						//LO SACO DEL ARREGLO TEMPORAL
					$partida->objetos_usuarios_temporales[$i]['id']=NULL;
							
					
		$_SESSION['ultima_consulta']=0;
		$_SESSION['ultima_consulta_bis']=0;
		//$_SESSION['usuario']=$_GET['nombre'];
		//donde dice 5 va el id del jugador que se une
		//$_SESSION['id']=$_GET['id'];
		//donde dice 10 va el id de la partida
		$_SESSION['id_partida']=$_SESSION['id_partida'];
		//donde dice 3 va el color de fichas que leije
		$_SESSION['color']=$partida->objetos_usuarios_temporales[$i]['color'];
		//rol 0 es rol de jugador
		$_SESSION['rol']=0;
		//hay que traer img
		//$_SESSION['url_img']= $_GET['url_img'];
		$_SESSION['clave']=$_GET['clave'];
		
		$invitado = new Usuario($_SESSION['usuario'],$_SESSION['id'],$_SESSION['color'],$_SESSION['url_img'],$_SESSION['clave']);
		
		
		insertar_usuario($_SESSION['usuario'], $_SESSION['id'], $_SERVER[REMOTE_ADDR], $_SESSION['id_partida'], 0);		
		
		
		$partida->setUsuarios($invitado);
		
		//Si es el ultimo jugador qeu ingresa, sortea las posiciones y asigna paises
		if($partida->usuarios_efectivos==sizeof($partida->objetos_usuarios)){
			//sorteo orden de comienzo
			shuffle($partida->objetos_usuarios);
			
			//sorteo los paises
			// voy tomando de a un pais de forma ordenada y se lo entrego a un jugador tomado al azar
			//siempre que este jugador no tenga completa la cantidad de paises que puede tener
		
			$arreglo_jugadores = $partida->objetos_usuarios;
			$arreglo_paises = $partida->paises;	
			shuffle($arreglo_paises);
			//setea para cada usuario el comienza_con que indica cuantos paises va a tener cada usuario al empezar
			//esto depende de la cantidad de jugadores que haya y el orden de comienzo
			$asignador=0;
			for($i=0;$i<50;$i++){	
				if($asignador==$partida->usuarios_efectivos)
					$asignador=0;	
				$arreglo_jugadores[$asignador]->setAgregarUnPais();
				$asignador++;
			}
			
			//Le asigno a cada usuario el numero de paises que le corresponde
			//en realidad pongo el objeto usuario en el pais
			for($i=0;$i<50;$i++){
				$jugador_sorteado = rand(0,(sizeof($arreglo_jugadores)-1));

				//en el pais cargo el usuario propietario (EL USUARIO PROPIETARIO AUTOMATICAMENTE INCREMENTA EN UNO SU CANTIDAD DE PAISES)
				$arreglo_paises[$i]->setPropietario($arreglo_jugadores[$jugador_sorteado]);
				
				//si se le asignaron todos los paises lo saca de la lista de jugadores esperando paises 
				if(($arreglo_jugadores[$jugador_sorteado]->getComienzaCon()) == ($arreglo_jugadores[$jugador_sorteado]->getCantidadPaises()) ){
					unset($arreglo_jugadores[$jugador_sorteado]);	
					$tmp=array(sizeof($arreglo_jugadores));
					//esto es un mamarracho para arreglar que el array queda deforme dependiendo que jugador saque
					$j=0;
					foreach ($arreglo_jugadores as $valor){
						$tmp[$j]=$valor;
						$j++;
					}
					$arreglo_jugadores=$tmp;
				}
			}
			//mezclo las tarjetas en su arreglo
		shuffle($partida->tarjetas);
		
		
			//ENTREGA OBJETIVO SOLAMETE SI HAY MAS DE DOS USUAIOS	
		if(sizeof($partida->objetos_usuarios) > 2){
				//MEZCLO EL ARREGLO DE LOS OBJETIVOS
			shuffle($partida->objetivos);
					//RECORRO JUGADOR POR JUGADOR
				for($j=0; $j < $partida->usuarios_efectivos;$j++){
					$se_puedo_entregar=0;
						//HACER MIENTRAS NO SE PUEDA ASIGNAR OBJETIVO
					do{
							//EN ESTA VARIABLE PONGO EL POSIBLE OBJETIVO A ENTREGAR, DA VUELTAS HASTA QUE AGARRA UNO QUE NO ESTE ENTREGADO 
						do{
							$numero_objetivo=rand(0,12);
							$objetivo_a_entregar = $partida->objetivos[$numero_objetivo];
						}while($partida->objetivos[$numero_objetivo]->getEntregado() != 0);
						
								//COMPRUEBO SI EL OBJETIVO ES DESTRUIR A OTRO EJERCITO
							if($objetivo_a_entregar->getColor() != 0){
									//RECORRO TODOS LOS USUARIOS Y COMPRUEBO SI ALGUNO TIENE EL COLOR QUE INDICA EL OBJETIVO QUE HAY QUE MATAR
									//Y QUE ESE COLOR NO LO TENGA AL QUE SE LE VA A ASIGNAR EL OBJETIVO
								$existe_color = 0;
								for($h=0; $h < $partida->usuarios_efectivos;$h++)
									if($partida->objetos_usuarios[$j]->getColor() != $objetivo_a_entregar->getColor() && $partida->objetos_usuarios[$h]->getColor() == $objetivo_a_entregar->getColor())
										$existe_color = 1;
									//EL COLOR DEL EJERCITO QUE DEBE DESTRUIR ESTA EN LA PARTIDA, Y NO CORRESPONDE AL QUE SE LO ESTA ENTREGANDO
								if($existe_color == 1){
									$partida->objetos_usuarios[$j]->setObjetivo($objetivo_a_entregar);
									$objetivo_a_entregar->setEntregado();
									$se_puedo_entregar=1;	
								}
									//EL COLOR DEL EJERCITO QUE DEBE DESTRUIR NO ESTA EN LA PARTIDA, O PERTENESE AL QUE SE LE INTENTA ENTREGAR
								else{
										//AGARRO EL USUARIO DE LA DERECHA DEL JUGADOR AL QUE SE LE VA A ENTREGAR EL OBJETIVO
										//SI EXISTE UNA POSICION MAS EN EL ARREGLO (O SEA NO DESBORDA) ES < PORQUE LA CANTIDAD DE USUARIO ES UN ENTERO SIN CERO, PERO LOS ARREGLOS ARRANCAN DE 0
									if($j+1 < $partida->usuarios_efectivos)
										$color_derecha = $partida->objetos_usuarios[$j+1]->getColor();
									else
										//SI NO EXISTE UNA POSICION A LA DERECHA EN EL ARREGLO DE USUARIOS, O SEA SI ES EL ULTIMO USUARIO DEL ARREGLO AGARRO EL PRIMERO DEL ARREGLO
										$color_derecha = $partida->objetos_usuarios[0]->getColor();
										
										
										//RECORRO EL ARREGLO DE OBJETIVOS, HASTA ENCONTRAR EL OBJETIVO QUE DIGA QUE HAY QUE MATAR AL COLOR QUE SELECCIONE ANTERIORMENTE
									for($k=0;$k<13;$k++){
											//COMPRUEBO SI EL OBJETIVO INDICA MATAR AL COLOR QUE ANTES SELECCIONE
										if($partida->objetivos[$k]->getColor() == $color_derecha){
												//CUANDO ENCUENTRO EL OBJETIVO, SE LO ENTREGO AL USUARIO, NO LLAMO AL METODO setObjetivo PORQUE NO ES QUE SE HAYA ENTREGADO,
												//SOLO HACE REFERENCIA AL USUARIO DE LA DERECHA
											$partida->objetos_usuarios[$j]->setObjetivo($partida->objetivos[$k]);
											$se_puedo_entregar=1;
											$k=13;
										}
									}
										
								}			
								
							}
								//VIENE ACA SI EL OBJETIVO NO ES DESTRUIR ALGUN EJERCITO, ENTONCES LO ENTREGO DIRECTAMENTE
							else{
								$partida->objetos_usuarios[$j]->setObjetivo($objetivo_a_entregar);
								$objetivo_a_entregar->setEntregado();
								$se_puedo_entregar=1;
							}
						
					}while($se_puedo_entregar == 0);
				}
				
		
		}//FIN ENTREGAR OBJETIVO SI LA PARTIDA TIENE MAS DE 2 USUARIOS	
		
		
			//en turno usuario pongo el usuario que debe jugar
		$partida->turno_usuario=$partida->objetos_usuarios[0];
		
			//dice que la accion a realizar por el primer jugador es incorporar ejercito
		$partida->estado_usuario_turno=3;
		
			///le creo el objeto incorporar al proximo jugador y se lo inserto
		$partida->turno_usuario->setObjetoIncorporar(new Incorporar($partida->turno_usuario,$partida));
		
				///es la bandera que dice que la partida ya esta lista para jugarse
		$partida->inicializada=1;
		
		}
		
									//FUERZA LA SALIDA DEL FOR
						$i= sizeof($partida->objetos_usuarios_temporales);
							//HACE QUE ENTRE AL HEADER LOCATION Y LO MANDA A PARTIDAS, DONDE LE DICE QUE ESTA LLENA Y LE DA LA POSIBILIDAD DE CREAR UNA
						$ingreso=1;
		crear_archivo("../partidas/".$_SESSION['id_partida'],$partida);
		}
		
	}
		if($ingreso==0)
			header("Location: partidas.php?id_partida=".$_GET['id_partida']);
	
	}//CIERRA EL IF DE LA CLAVE
	
}//CIERRA EL IF DE UNIRSE

}//CIERRRA EL IF QUE CONSULTA SI EXISTE ROL
?>
