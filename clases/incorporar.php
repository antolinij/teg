<?php

	class Incorporar{
			//indican la cantidad de fichas que pone por tener
		private $fichas_por_continente=array(5);
		
		private $libres=0;
		
		private $por_cambio=0;
		
		private $fichas_totales=0;
		


			//crea y carga las variables de con las fichas que debe poner
		function __construct($usuario,$partida){
				//limpia las fichas por cambio
					//si le pertence devuelve el numero de fichas que incorpora a dicho continente por ser el propietsario
					//si no le pertence devuelve un 0 o sea que no incorporar ninguna por ese contienente		
			for($i=0;$i<6;$i++){
				$this->fichas_por_continente[$i]=$partida->continentes[$i]->getMePertenese($usuario->getId());
					//si es distinto es porque tiene el continente
					//entonces a las fichas totales le suma la de ese continente
				if($this->fichas_por_continente[$i]!=0)
					$this->fichas_totales+=$this->fichas_por_continente[$i];
			}
					//carga libres, que son las fichas que puede poner en cualquier lugar
				if(($usuario->getCantidadPaises()%2) == 1)
					$this->libres=($usuario->getCantidadPaises()-1)/2;
				else
					$this->libres=$usuario->getCantidadPaises()/2;
					
					//hace que un usuario pueda poner como minimo 3 fichas
				if($this->libres<4)
					$this->libres=4;
				
					//agrega a libre las fichas que le dal el cambio si es que lo hizo
				$this->libres+=$this->por_cambio;
				
				$this->por_cambio=0;
				
				$this->fichas_totales+=$this->libres;
				
				
					//si recien comienza le entrega al usuario cinco fichas libres
				if($partida->numero_veces_incorporaciones == 0){
					$this->fichas_totales=5;
					$this->libres=5;
				}
				
				if($partida->numero_veces_incorporaciones == 1){
					$this->fichas_totales=3;
					$this->libres=3;
				}	
			
		}
				
		function getLibres(){
			return $this->libres;
		}
		function getPorCambio(){
			return $this->por_cambio;
		}
		function getFichasTotales(){
			return $this->fichas_totales;
		}
			//devuelve un arreglo con las fichas que debe poner por cada continente
		function getFichasPorContinentes(){
			return $this->fichas_por_continente;
		}
		
		
		function setCambio($numero_cambio){
			switch($numero_cambio+1){
				case 1:
					$this->por_cambio=4;
				break;
				case 2:
					$this->por_cambio=7;
				break;
				case 3:
					$this->por_cambio=10;
				break;
				default:
						//esta hace que entregue 15, 20, 25,....
					$this->por_cambio=(($numero_cambio+1)*5)-5;
			}		
			
								//agrega a libre las fichas que le dal el cambio si es que lo hizo
				$this->libres+=$this->por_cambio;
				$this->fichas_totales+=$this->por_cambio;
				//$this->por_cambio=0;	
		}
		
		
		
		function setAgregar($pais,$partida){
			
				//recorre el arreglo continente
			for($i=0;$i<6;$i++){
				if($this->fichas_totales!=0){
							//pregunto si el usuario tiene este continente
							//si me dice que ese continente me entrega alguna ficha es porque lo tengo
							//si el pais al que se le quiere poner fichas pertence al continente seleccionado por el for y tiene continente
						if($partida->continentes[$i]->getId() == $pais->getIdContinente()){
										
								if($this->fichas_por_continente[$i]!=0){
									//descuento delas fichas del continente
									$this->fichas_por_continente[$i]--;
									$pais->setFichas(1);
									$this->fichas_totales--;
										//fuerzo salida del for porque incorpore la ficha
									$i=6;
								}
								else{
										//puede poner aca en tanto y en cuanto queden fichas libres
										//si llega aca porque fichas_totales es distinto de cero pero libres es 0
										//no hace nada, es que la tiene que poner en su continente
									if($this->libres!=0){
										$pais->setFichas(1);
										$this->libres-=1;
										$this->fichas_totales--;
											//HAGO QUE RESTE TAMBIEN DE LAS FICHAS DEL CAMBIO
										if($this->por_cambio != 0)
											$this->por_cambio--;
											//fuerzo salida del for porque incorpore la ficha
										$i=6;
									}
								}
						
						} ///cierra llave if($partida->continentes[$i]->getId() == $pais->getIdContinente()){
				
				}// cierra llave  del if($this->fichas_totales!=0){
				
			}//cierra llave for
					//si ya se puso todas las fichas en esta parte hago que avencen los jugadores o la ronda segun corresponda
				if($this->fichas_totales==0){
					//avanzo los usuarios
					for($i=0;$i<sizeof($partida->objetos_usuarios);$i++){
							//recorro el arreglo usuario hasta encontrar la posicion del usuario en turno
						if($partida->objetos_usuarios[$i]->getId() == $partida->turno_usuario->getId()){							
								//compruebo si es el ultimo elemente del arreglo
							if($i+1 == sizeof($partida->objetos_usuarios) && $partida->turno_usuario->getCantidadTarjetas() != 5){
									//si es el ultimo usuario del arreglo hago que ponga en fase de atacaque al primer usuario del arreglo que no este eliminado
								for($j=0;$j<sizeof($partida->objetos_usuarios);$j++){
									if($partida->objetos_usuarios[$j]->getEliminado() == NULL){
										$partida->turno_usuario=$partida->objetos_usuarios[$j];
											
											//si ya ingresaron las fichas de las dos primeras rondas, hago ir a ataque al usuario 1, de lo contrario 
											//dejo en estado de incorporacion
										if($partida->numero_veces_incorporaciones >= 1)
											$partida->estado_usuario_turno=0;
											
										//fuerzo salida del for que tiene como variable $i
										$i=sizeof($partida->objetos_usuarios);
										$i=6;
											//incremento las veces que se incorporo en todo el partido
											//va aca porque cuando entra aca es el ultimo jugador que incorpora fichas en esa ronda
										$partida->numero_veces_incorporaciones++;
											//CUIDADO CON ESTA FUNCION NO CREO QUE TENGA QUE ESTAR ---------------
										$partida->turno_usuario->setObjetoIncorporar(new Incorporar($partida->turno_usuario,$partida));
											//fuerzo la salida del for que tiene como variable $j
										$j=sizeof($partida->objetos_usuarios);	
									}
								}
							}
							else{
									//avanza al otro usuario en tanto y en cuanto el usuario que esta incorporando no tenga cinco tarjetas
									//si tiene cinco tarjetas tiene cambio obligado
								if($partida->turno_usuario->getCantidadTarjetas() != 5){
								
										//si logra entregar el turno esta variable se pone en 1
									$entregue_turno=0;
										//arranca desde el usuario que esta entregando el turno
									for($j=$i;$j<sizeof($partida->objetos_usuarios);$j++){
									
											//si el usuario que esta entregando el turno no es el ultimo del arreglo
										if($j+1 != sizeof($partida->objetos_usuarios)){
												//si el usuario al que se le va a entregar el turno no fue eliminado
											if($partida->objetos_usuarios[$j+1]->getEliminado() == NULL){
													//pongo en usuario en turno el el que esta en $j+1
													//y la variable de estado del usuario sigue en 3 que es incorporar
												$partida->turno_usuario=$partida->objetos_usuarios[$j+1];
												$partida->estado_usuario_turno=3;			
													///le creo el objeto incorporar al proximo jugador y se lo inserto
												$partida->turno_usuario->setObjetoIncorporar(new Incorporar($partida->turno_usuario,$partida));
										
													//fuerzo salida
												$i=sizeof($partida->objetos_usuarios);
												$i=6;														
												$entregue_turno=1;
													//fuerzo la salida del for que tiene como variable $j
												$j=sizeof($partida->objetos_usuarios);	
											}
										}
									}

										//cuando termina el for compruebo si pudo entregarle el turno a algun usuario
										//si no pudo entregarl es porque no habia delante de el ningun jugador que no estuviese eliminado
										//entonces lo avanzo a fase ataque y pongo el primero libre de la partida
									if($entregue_turno == 0){
										for($j=0;$j<sizeof($partida->objetos_usuarios);$j++){
											if($partida->objetos_usuarios[$j]->getEliminado() == NULL){
												$partida->turno_usuario=$partida->objetos_usuarios[$j];
											
													//si ya ingresaron las fichas de las dos primeras rondas, hago ir a ataque al usuario 1, de lo contrario 
													//dejo en estado de incorporacion
												if($partida->numero_veces_incorporaciones >= 1)
													$partida->estado_usuario_turno=0;
													
													//fuerzo salida del for que tiene como variable $i
												$i=sizeof($partida->objetos_usuarios);
												$i=6;
													//incremento las veces que se incorporo en todo el partido
													//va aca porque cuando entra aca es el ultimo jugador que incorpora fichas en esa ronda
												$partida->numero_veces_incorporaciones++;
													//CUIDADO CON ESTA FUNCION NO CREO QUE TENGA QUE ESTAR ---------------
												$partida->turno_usuario->setObjetoIncorporar(new Incorporar($partida->turno_usuario,$partida));
													//fuerzo la salida del for que tiene como variable $j
												$j=sizeof($partida->objetos_usuarios);	
											}
										}
									}	
	
									
								} //if($partida->turno_usuario->getCantidadTarjetas() != 5)
								else{
										//devuelvo un cinco como para decir que no se pudo avanzar de usuario porque tiene que cmabiar tarjetas
									return 5;
								}
							}
							
							
						}
							
					}
				////	if($this->fichas_totales==0){*/
				}
							
			//cierra el metodo
			}
	//cierra la clase
	}
		

?>