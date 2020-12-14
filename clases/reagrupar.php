<?php	
	class Reagrupar{
		private $pais_de=NULL;
		private $pais_a=NULL;

		function __construct($pais_de){
			if($pais_de->getPropietario()->getId() == $_SESSION['id'] ){
				$this->pais_de=$pais_de;
				return 1;
			}		
			else
				return 0;
		}
		
		function setPaisA($pais_a){
				//pregunta si el pais tambien es del mismo dueño
			if($pais_a->getPropietario()->getId() == $_SESSION['id'] ){
					//son limitrofes
				if($this->getLimitrofe($this->pais_de,$pais_a)==1){
					$this->pais_a=$pais_a;
					return 3;
				}
				else
					return 0;
			}
		}
		
		/******************************************************************************/
		function getLimitrofe($ataque,$defensa){
			return limitrofes($ataque,$defensa);
			
		}
		
		function getPaisDe(){
			return $this->pais_de;
		}
		
		function getPaisA(){
			return $this->pais_a;
		}
		
		
	}

?>