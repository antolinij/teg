<?php
	class Ataque{
		private $pais_ataque=NULL;
		private $pais_defensa=NULL;
		private $dados_ataque=NULL;
		private $dados_defensa=NULL;
		private $tmp_dados_ataque;
		private $tmp_dados_defensa;
		private $bloqueado=0;

		///esto puede traer poroblemas que no siempre ande bien
		function __construct($pais_ataque){
			if($pais_ataque->getPropietario()->getId() == $_SESSION['id'] ){
				$this->pais_ataque=$pais_ataque;
				return 1;
			}		
			else
				return 0;
		}
		
		function setDefensa($pais_defensa){
			if(($this->getLimitrofe($this->pais_ataque,$pais_defensa))==1){
				$this->pais_defensa=$pais_defensa;
				return 2;
			}
			else
				return 0;
			
		}
		
		
		function setRetirar(){
			$fichas_en_juego=0;
			if(sizeof($this->dados_ataque) > sizeof($this->dados_defensa))
				$fichas_en_juego=sizeof($this->dados_defensa);
			else
				$fichas_en_juego=sizeof($this->dados_ataque);			
				
			for($i=0;$i<$fichas_en_juego;$i++){
				if(($this->dados_ataque[$i]) > ($this->dados_defensa[$i]))
					$this->pais_defensa->setFichas(-1);
				else
					$this->pais_ataque->setFichas(-1);
				}	
				 //los salvo en una variable temporal y despues limpio las originales
				//$this->tmp_dados_ataque=$this->dados_ataque;
				$this->tmp_dados_defensa=$this->dados_defensa;
				//IMPORTANTE ESTO PORQUE EVITA QUE PUEDA TIRAR ANTES QUE EL ATACANTE LA DEFENSA
				$this->dados_ataque=NULL;
				//$this->dados_defensa=NULL;
			
		}
		
		function setDadosAtaque(){
			
				//quiere decir que ya se ataco
			if(sizeof($this->dados_ataque)>=1)
				return 2;
				
			//cada vez que comienza un ataque borro los dados viejos
			$this->tmp_dados_defensa=NULL;
			$this->tmp_dados_ataque=NULL;
			


			
			//si tiene una ficha el pais que intenta atacar no puede hacerlo
			if(($this->pais_ataque->getFichas() == 1)){
				$this->dados_ataque=NULL;
				return 0;
			}
			else
				{
				//digo que la cantidad de dados que tiene un atacantes es igual a la cantidad de fichas que tiene menos uno
				//e inmediatamente despues si cantidad_dados es mayor a tres la igualo a tres
				$cantidad_dados = $this->pais_ataque->getFichas()-1;
				if($cantidad_dados > 3)
					$cantidad_dados=3;
				//llamo a la funcion que tira los dados, se le pasa la cantidad de dados y la variable donde guarda los dados
				//notar que la pasa por referencia
				dados($cantidad_dados,$this->dados_ataque);
				
				//guardo los dados del atacante en tmp_dados_ataque que es lo que lee __dados.php para enviar al cliente
				$this->tmp_dados_ataque=$this->dados_ataque;
				return 1;			
				
			}	
		}
		
		
		
			function setDadosDefensa(){

				//digo que la cantidad de dados que tiene el pais defensa es igual a la cantidad de fichas que tiene
				//e inmediatamente despues si cantidad_dados es mayor a tres la igualo a tres
				$cantidad_dados = $this->pais_defensa->getFichas();
				if($cantidad_dados > 3)
					$cantidad_dados=3;
				//llamo a la funcion que tira los dados, se le pasa la cantidad de dados y la variable donde guarda los dados
				//notar que la pasa por referencia
				dados($cantidad_dados,$this->dados_defensa);
				return 1;			
			
		}
		
		
		function getDatosAtaque(){
			return $this->dados_ataque;
		}
		function getDadosDefensa(){
			return $this->dados_defensa;
			
			
		}
		function getDatosTmpAtaque(){
			return $this->tmp_dados_ataque;
		}
		function getDadosTmpDefensa(){
			return $this->tmp_dados_defensa;
		}
		
		function setLimpiarTmpAtaque(){
			 $this->tmp_dados_ataque=NULL;
		}
		
		function setLimpiarTmpDefensa(){
			$this->tmp_dados_defensa=NULL;
		}
		
		
		
		function getPaisAtaque(){
			return $this->pais_ataque;
		}
		function getPaisDefensa(){
			return $this->pais_defensa;
		}
		
		function setBloquear($estado){
			$this->bloqueado=$estado;
		}
		function getBloquear(){
			return $this->bloqueado;
		}
		
		/******************************************************************************/
		function getLimitrofe($ataque,$defensa){
			return limitrofes($ataque,$defensa);
			
		}
		
		
	}

?>