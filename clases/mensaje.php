<?php
class Mensaje{
	private $id_envio=NULL;
	private $mensaje=NULL;

	function __construct($id_envio,$mensaje){
		$this->id_envio=$id_envio;
		$this->mensaje=$mensaje;
	}
	function getMensaje(){
		$arreglo_respuesta[0]=$this->id_envio;
		$arreglo_respuesta[1]=$this->mensaje;
		return $arreglo_respuesta;
	}

}


?>