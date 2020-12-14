<?php
class Pais{
	private $nombre=NULL;
	private $id=NULL;
	private $objeto_propietario=NULL;
	private $cantidad_fichas=1;
	private $id_continente;
		
		//aca se acumulan la cantidad de fichas que recibio un pais cuando se reagrupa
		//despues al total se le resta esto y lo que efectivamente puede enviar a otro pais limitrofe
	private $recibido=0;
	function __construct($nombre,$id,$id_continente){
		$this->nombre=$nombre;
		$this->id=$id;
		$this->id_continente=$id_continente;
		
	}
	
	function __destruct(){
	}
	
	function setFichas($cantidad){
		$this->cantidad_fichas+=$cantidad;
	}
	
	function setPropietario($nuevo_propietario){

		
			//Es para ver si el pais se esta seteando cuando recien empieza el juego o si es que cambio de dueño
			//si esta cambiando de dueño entra aca y le saca al dueño anterior un pais
		if($this->objeto_propietario != NULL){
			//LLAMA AL METODO setFueEliminado DE LA CLASE USUARIO, SI ES EL ULTIMO PAIS QUE LE QUEDABA ELIMINA EL USUARIO
			//Y GUARDA EL USUARIO QUE LO ELIMINO, ESTO SIRVE POR SI EL OBJETIVO DE UN USUARIO ES ELIMINAR UN JUGADOR
			//EL ARGUMENTO LO MANDO PARA DECIR QUE EL NUEVO PROPIETARIO ES EL ELIMINADOR(O SEA EL QUE ELIMINO AL USUARIO DEL JUEGO)
				$this->objeto_propietario->setFueEliminado($nuevo_propietario);
				
			$this->objeto_propietario->setRestarPais();
		}

				
				//asigno nuevo propietario
			$this->objeto_propietario=$nuevo_propietario;
				//al nuevo propietario le incremento en uno la cantidad de paises que tiene
			$nuevo_propietario->setSumarPais();
				//pone en cero el contador de fichas que recibio de otros paises por reagruparse, esto es porque al cambiar de dueño
				//todas las fichas que tenga las puede enviar
			$this->setRecibidoCero();
	}
	
	function getFichas(){
		return $this->cantidad_fichas;
	}
	function getPropietario(){
		return $this->objeto_propietario;
	}
	
	function getNombre(){
		return $this->nombre;
	}
	
	//este lo tengo que sacar
	function setNombre($nombre){
		 $this->nombre=$nombre;
	}
	function getId(){
		return $this->id;
	}
	
	function setRecibido($cantidad){
		$this->recibido+=$cantidad;
	}
	function setRecibidoCero(){
		$this->recibido=0;
	}
	function getRecibido(){
		return $this->recibido;
	}
	
	function getIdContinente(){
		return $this->id_continente;
	}
}


?>