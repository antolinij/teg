<?php
	class Tarjeta{
		private $id_pais;
		private $logo;
		private $estado=0;
		
		function __construct($pais,$logo,$estado){
			$this->id_pais=$pais;
			$this->logo=$logo;
			$this->estado=$estado;
		}
		
		function setEstado($estado){
			$this->estado=$estado;
		}
		
		function getIdPais(){
			return $this->id_pais;
		}
		
		function getLogo(){
			return $this->logo;
		}
		
		function getEstado(){
			return $this->estado;
		}

		function getNombrePais($partida){
			foreach($partida->paises as $pais)
				if($pais->getId() == $this->getIdPais())
					return $pais->getNombre();
		}
				
	}
?>