<?php
class Usuario{
	private $nombre;
	private $id;
	private $color_ficha;
	private $cantidad_paises=0;
	private $comienza_con=0;
	private $objetos_tarjetas=NULL;
	private $objeto_incorporar=NULL;
	private $objeto_objetivo=NULL;
	private $url_img;				////VARIABLE DE LA URL DE LA IMAGEN
	

		//CONTINENTE EL OBJETO USUARIO QUE LO ELIMINO
	private $usuario_eliminador=NULL;

	
	private $sacar_tarjeta=0;
		//esta variable se pone en uno si cuando estuve para sacar tarjeta, efectivamente saque
	private $saque_tarjeta=0;
	
	private $numero_cambio=0;
	
	function __construct($nombre,$id,$color,$url_img){
		$this->nombre=$nombre;
		$this->id=$id;
		$this->color_ficha=$color;
		$this->url_img=$url_img;          //AGREGUE LA URL DE LA IMAGEN
		$this->objetos_tarjetas=array(5);
		for($i=0;$i<5;$i++)
			$this->objetos_tarjetas[$i]=NULL;
	}
	
	function __destruct(){
	}
	
		//SI EL USUARIO FUE ELIMINADO DEVUELVE EL OBJETO USUARIO QUE LO ELIMINO, SI NO FUE ELIMINADO DEVUELVE NULL
	function getEliminado(){
		return $this->usuario_eliminador;
	}
	
	//CONSULTA SI EL USUARIO FUE ELIMINADO SI FUE ELIMINADO PONGO EN USUARIO_ELIMINADOR EL OBJETO USUARIO QUE LO ELIMINO SI ES QUE FUE ELIMINADO
	function setFueEliminado($usuario_eliminador){
			//COMPARA CON UNO Y NO CON CERO, PORQUE YA LO PERDIO PERO TODAVIA NO SE LO SAQUE
		if($this->cantidad_paises == 1){
			$this->usuario_eliminador=$usuario_eliminador;
		}
		
	}
	
	//Esto devuelve un arreglo
	function setTarjeta($objeto_tarjeta){
		for($i=0;$i<5;$i++){
			//Guardo la tarjeta en el primer lugar libre del arreglo
			if($this->objetos_tarjetas[$i]==NULL){
				$this->objetos_tarjetas[$i]=$objeto_tarjeta;
				//Fuerzo la salida del for de lo contrario seguiria guardando la tarjeta
				return;
			}
		}
	}
	
	function getObjetivo(){
		return $this->objeto_objetivo;
	}
	
	function setObjetivo($objetivo){
		$this->objeto_objetivo=$objetivo;
	}
	
	//AGREGO LA FUNCION QUE DEVUELVE LA URL DE LA IMAGEN DEL USUARIO
	
	function getUrlImg(){
		return $this->url_img;
	}
	
	
	function getNumeroDeCambio(){
		return $this->numero_cambio;
	}
	
	function setNumeroDeCambio(){
		$this->numero_cambio++;
	}
		//incrementa en uno la cantidad de paises que posee
	function setSumarPais(){
		$this->cantidad_paises++;
	}
		//baja en uno la cantidad de paises que posee
	function setRestarPais(){
		$this->cantidad_paises--;
	}
		//devuelve todas las tarjetas que tiene el usuario(devuelve un arraglo que adentro tiene todas las tarjetas)
	function getTarjetas(){
		return $this->objetos_tarjetas;
	}
		//devuelve la tarjeta que este en la posicion del arreglo que se le diga
	function getTarjeta($posicion){
		return $this->objetos_tarjetas[$posicion];
	}
		//devuelve el nombre del usuario
	function getNombre(){
		return $this->nombre;
	}
		//devuelve el id del usuario
	function getId(){
		return $this->id;
	}
		//devuleve el color de fichas que tiene el usuario
	function getColor(){
		return $this->color_ficha;
	}
		//devuelve la cantidad de paises que posee el usuario
	function getCantidadPaises(){
		return $this->cantidad_paises;
	}
		//incrementa en uno los paises que tiene un usuario
	function setAgregarUnPais(){
		$this->comienza_con++;
	}
		//devuelve la cantidad de paieses con los que comieza
	function getComienzaCon(){
		return $this->comienza_con;
	}
	
	function setObjetoIncorporar($incorpora){
		$this->objeto_incorporar=$incorpora;
	}
	
	function getObjetoIncorporar(){
		return $this->objeto_incorporar;
	}
		///Calcula si con la cantidad de paises que gano puede o no sacar tarjeta devuelve uno si puede cero si no puede
	function getMerezcoTarjeta(){
		if($this->numero_cambio >= 3)
			$necesito=2;
		else
			$necesito=1;
		
		if($necesito <= $this->sacar_tarjeta){
			$this->sacar_tarjeta=0;
			return 1;
		}
		else{
			$this->sacar_tarjeta=0;
			return 0;
		}
	}
	
	function setGanePais(){
		 $this->sacar_tarjeta++;
	}
	function setGanePaisReset(){
		 $this->sacar_tarjeta=0;
	}
	
	function setSaqueTarjeta(){
		$this->saque_tarjeta=1;
	}
	function getSaqueTarjeta(){
		return $this->saque_tarjeta;
	}
	function setSaqueTarjetaReset(){
		$this->saque_tarjeta=0;
	}
		//devuelve la cantidad de tarjetas que tiene el usuario
	function getCantidadTarjetas(){
		$cantidad=0;
		foreach($this->objetos_tarjetas as $tarjetas)
			if($tarjetas != NULL)	
				$cantidad++;
		return	$cantidad;
	}

	function setDevolverTarjeta($tarjeta,$partida){
		for($i=0;$i<sizeof($partida->turno_usuario->getTarjetas());$i++){
				//el if este esta porque hay posiciones que pueden estar null entonces eso daria un error, de eta forma no compruebo las null
			if($partida->turno_usuario->getTarjeta($i)!=NULL){
				if($partida->turno_usuario->getTarjeta($i)->getIdPais() == $tarjeta->getIdPais()){
						//le pongo el estado 0 o sea no cambiado
					$tarjeta->setEstado(0);
						//devuelvo la tarjeta al final del arreglo
					$partida->tarjetas[sizeof($partida->tarjetas)]=$tarjeta;	
						//le saco la tarjeta al usuario
					$this->objetos_tarjetas[$i]=NULL;					
				}
			}
		}
		//EL ARREGLO OBJETOS_TARJETAS QUE ES EL QUE CONTIENE EN CADA UNA DE SUS CINCO PISICIONES OBJETOS TARJETAS
		//DEJO LAS TARJETAS EN LAS PRIMERAS POSICIONES Y LAS POSICIONES LIBRES AL FINAL ES PARA QUE QUEDE ORDENADO CUANDO RETIRO UNA TARJETA NUEVA VAYA AL FINAL
		for($i=0;$i<4;$i++){
			if($this->objetos_tarjetas[$i]==NULL){
				for($j=$i+1;$j<5;$j++){
					if($this->objetos_tarjetas[$j]!=NULL){
						$this->objetos_tarjetas[$i]=$this->objetos_tarjetas[$j];
						$this->objetos_tarjetas[$j]=NULL;
						$j=5;
					}
				}
			}
		}
	}
	
	
	
function setCobrar($tarjeta1,$tarjeta2,$tarjeta3,$tarjeta4,$tarjeta5,$partida){
		//pregunta si el usuario saco una tarjeta en la ronda, si no saco no puede cobrar ningna
	$tarjetas=array(0=>$tarjeta1,1=>$tarjeta2,2=>$tarjeta3,3=>$tarjeta4,4=>$tarjeta5);
	$tarjeta_cambio;
	$veces_entre_foreach=0;
	$cantidad=0;
			//pregunta si el usuario saco tarjeta en la ronda, si no saco no puede cambiar ninguna de las que ya tiene(por esto ese if)
	if($partida->turno_usuario->getSaqueTarjeta() == 1){
											
			foreach($tarjetas as $tarjeta){
				if($tarjeta == 1){
					if($partida->turno_usuario->getTarjeta($veces_entre_foreach)!=NULL ){
							//solamente puede tomar una tarjeta, porque es cobrar, si hay mas de una seleccionadada cantidad de hace mas de 1 y el cambio no se realiza
						if($cantidad < 1){
								//digo que la tarjeta que esta en la posicion $avanzar_arreglo del usuario fue seleccionada
							$tarjeta_cambio=$partida->turno_usuario->getTarjeta($veces_entre_foreach);
						}
						$cantidad++;
					}
				}				
				$veces_entre_foreach++;
			}//foreach($tarjetas as $tarjeta){
			
				//si se selecciono una y solo una tarjeta
			if($cantidad == 1){
					//compruebo si la tarjeta esta en estado de ser cambiada
				if($tarjeta_cambio->getEstado() == 0 ){
						
					$id_pais=$tarjeta_cambio->getIdPais();
						//recorro todos los paises 
					foreach($partida->paises as $pais){	
							//compruebo si id del usuario en turno es igual al del propietario del pais que selecciona el foreach Y aparte compruebo que 
							//el pais al que hace referencia la tarjeta sea el seleccionado por el foreach
						if($id_pais == $pais->getId() && $partida->turno_usuario->getId() == $pais->getPropietario()->getId()   )	{
								//cambio el estado de la tarjeta
							$tarjeta_cambio->setEstado(1);
								//le entrego al pais al que hace referencia 2 fichas
							$pais->setFichas(2);
								//reseteo el saco tarjeta, para que en la misma ronda no pueda cobrar dos tarjetas
							$partida->turno_usuario->setSaqueTarjetaReset();
							return 1;
						}
					}
				}
			}//if($cantidad == 1){
			
	}//if($partida->turno_usuario->getSaqueTarjeta() == 1){	
}


	
	
	
	
function setCambiarTarjetas($tarjeta1,$tarjeta2,$tarjeta3,$tarjeta4,$tarjeta5,$partida){
				//si esta variable se hace uno es que se pudo hacer el cambio
			$cambio_afirmativo=0;
			
			$tarjetas=array(0=>$tarjeta1,1=>$tarjeta2,2=>$tarjeta3,3=>$tarjeta4,4=>$tarjeta5);
			
			$cantidad=0;
			
			$arreglo_tarjetas=array(0=>NULL,1=>NULL,2=>NULL);
				//meto en arreglo_tarjetas las tarjetas seleccionadas y cuentos cuantas son, si son mas de tres o menos de tres posteriormente retorno con 0
			$avanzar_arreglo=0;
			$veces_entre_foreach=0;
			foreach($tarjetas as $tarjeta){
				if($tarjeta == 1)
							if($partida->turno_usuario->getTarjeta($veces_entre_foreach)!=NULL){
									//digo que la tarjeta que esta en la posicion $avanzar_arreglo del usuario fue seleccionada
								$arreglo_tarjetas[$avanzar_arreglo]=$partida->turno_usuario->getTarjeta($veces_entre_foreach);
								$cantidad++;
								$avanzar_arreglo++;
							}				
				
				$veces_entre_foreach++;
			}
				//envio mas o menos de tres tarjetas
			if($cantidad != 3){
				return 1;
				
			}
			else{ //envio tres tarjetas
				
					//alguna de las tres es un comodin
					
				if($arreglo_tarjetas[0]->getLogo() == 3 || $arreglo_tarjetas[1]->getLogo() == 3 ||  $arreglo_tarjetas[2]->getLogo() == 3 )	{
						//realizar si o si cambio
					$cambio_afirmativo=1;
				}
				else{
						//si son todas iguales
					if(($arreglo_tarjetas[0]->getLogo() == $arreglo_tarjetas[1]->getLogo()) &&  ($arreglo_tarjetas[0]->getLogo() == $arreglo_tarjetas[2]->getLogo())){
						//realizar cambio
					$cambio_afirmativo=1;
					
					}
						
						//si son todas distintas
					if(($arreglo_tarjetas[0]->getLogo() != $arreglo_tarjetas[1]->getLogo()) &&  ($arreglo_tarjetas[0]->getLogo() != $arreglo_tarjetas[2]->getLogo()) &&   ($arreglo_tarjetas[1]->getLogo() != $arreglo_tarjetas[2]->getLogo()))
						//realizar cambio
					$cambio_afirmativo=1;
					
				}
				
				
					///se pueden cambiar, devuelvo las tarjetas al arreglo y le entrego fichas al usuario
				if($cambio_afirmativo == 1){
					for($i=0;$i<3;$i++)
							//devuelve todas las tarjetas
							$partida->turno_usuario->setDevolverTarjeta($arreglo_tarjetas[$i],$partida);

					$partida->turno_usuario->getObjetoIncorporar()->setCambio($partida->turno_usuario->getNumeroDeCambio());
					$partida->turno_usuario->setNumeroDeCambio();	
					return 0;
				}
				
			}

}

//ESTE METODO MODIFICA UN USUARIO EXISTE CAMBIANDOLE ID, NOMBRE Y URL DE LA IMAGEN
//ES PARA LA TRANSFERENCIA DE PARTIDAS
function setModificarJugador($id,$nombre,$url_img){
	$this->nombre = $nombre;
	$this->id = $id;
	$this->url_img = $url_img;
}

}
?>