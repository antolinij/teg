<?php
class Continente{
	private $nombre;
	private $id;
	private $fichas_entrega;
	private $objetos_paises;


	
	function __construct($nombre,$id,$fichas_entrega,$paises){
		$this->nombre=$nombre;
		$this->id=$id;
		$this->fichas_entrega=$fichas_entrega;
		
		$this->objetos_paises=array(sizeof($paises));
		
			$this->objetos_paises=$paises;

	}
	
	function __destruct(){
	}
	
	function getObjetos_paises(){
		return $this->objetos_paises;
	}
	
	function getMePertenese($id_solicitante){
			//uno quiere decir que es del solicitante, empiezo suponiendo que es
			//despues recorro todos los paises que tiene el continente y si alguno no es del solicitante
			//retorno con un 0;
		foreach($this->objetos_paises as $paises){
				//si alguno de los paises no del id que se le mando sale
			if($paises->getPropietario()->getId() != $id_solicitante)
				return 0;
		}
		return $this->fichas_entrega;
	}
	
	function getId(){
		return $this->id;
	}
	
	
	
	
		//DEVUELVE LA CANTIDAD DE PAISES DEL CONTIENTE QUE TIENE EL USUARIO EN DICHO CONTINENTE
	function getCantidadPaisesUsuario($id_usuario){
		$cantidad=0;
		foreach($this->objetos_paises as $paises){
				//LE SUMA 1 A CANTIDAD POR CADA PAIS QUE LE PERTENECE AL USUARIO SOBRE EL QUE SE COMPRUEBA CUANTOS PAISES TIENE EN EL CONTINENTE
			if($paises->getPropietario()->getId() == $id_usuario)
				$cantidad++;
		}
			return $cantidad;
	}
	
	
}

?>