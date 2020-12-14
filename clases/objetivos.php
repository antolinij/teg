<?php
class Objetivo{
	private $id;
	private $amercia_norte;
	private $america_sur;
	private $europa;
	private $africa;
	private $asia;
	private $oceania;
	
	private $color;
		//si no fue entregado a un jugador le deja un 0 si ya fue entregado le pone un 1
	private $entregado=0;
	
	
	function __construct($id,$america_norte,$america_sur,$europa,$africa,$asia,$oceania,$color){
		$this->id=$id;
		$this->america_norte=$america_norte;
		$this->america_sur=$america_sur;
		$this->europa=$europa;
		$this->africa=$africa;
		$this->asia=$asia;
		$this->oceania=$oceania;
		$this->color=$color;
		$this->entregado=0;
		
	}
	function getId(){
		return $this->id;
	}
	function getAmericaNorte(){
		return $this->america_norte;
	}
	function getAmericaSur(){
		return $this->america_sur;
	}
	function getEuropa(){
		return $this->europa;
	}
	function getAfrica(){
		return $this->africa;
	}
	function getAsia(){
		return $this->asia;
	}
	function getOceania(){
		return $this->oceania;
	}
	function getColor(){
		return $this->color;
	}
		//GUARDA SI PUEDE SER ENTREGADO, SI ES 0 O 1 PUEDE SER ENTREGADO, CUANDO EL OBJETIVO ES DESTRUIR A UN COLOR LE SUMA UNO
		//ESTO ES PARA QUE PUEDA VOLVER A ENTREGARSE UNA VEZ MAS, SI ES OBJETIVO DE PAISES LE SUMA 2 PARA QUE SOLO PUEDA ENTREGARSELO A UNA PERSONA
	function setEntregado(){
		$this->entregado=1;
	}
	function getEntregado(){
		return $this->entregado;
	}
}

?>