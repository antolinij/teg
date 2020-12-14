<?php
	class Partida{
			//le agrega una clave a la partida que es aleatoria
		public $clave;
		
		public $ronda=1;
		public $objeto_anfitrion;
		
		public $objetos_usuarios;
		
		public $objetos_usuarios_temporales;
		
		public $tarjetas;
		public $continentes;
		public $paises;
		public $objetivos;
		public $usuarios_efectivos=0;
		public $inicializada=0;
		
		public $paises_america_norte;
		public $paises_america_sur;
		public $paises_africa;
		public $paises_europa;
		public $paises_asia;
		public $paises_oceania;	
		public $numero_veces_incorporaciones=0;
			
			//SI UN USUARIO GANA UNA PARTIDA, ACA PONE AL USUARIO QUE LA GANO
		public $usuario_ganador=NULL;
		
		public $chat=array(100);
		public $numero_mensaje=0;
			
		//CREO LA VARIABLE PARA LA TRANSFERENCIA, EL VALOR QUE PONGO EN id_emisor ES EL ID DEL QUE ENTREGA LA PARTIDA
		public $id_emisor = array(NULL,NULL,NULL,NULL,NULL,NULL);
		//EN ESTA VARIABLE ALMACENO LA CLAVE ALEATORIA CON LA QUE SE GUARDA EL ID DE LA PARTIDA ES UN NUMERO ENTRE 0 Y 999999
		//EL CERO ESTA RESERVADO PARA INDICAR ERROR
		public $clave_emisor = array(NULL,NULL,NULL,NULL,NULL,NULL);
		//SI EL QUE ENTREGA UNA PARTIDA ES EL ANFITRION, EL ARCHIVO EN EL QUE SE SERIALIZA EL OBJETO PARTIDA
		//CAMBIA DE NOMBRE, Y ESTO SE LO NOTIFICO A TODOS LOS USUARIOS PARA QUE CAMBIEN LA VARIABLE DE SESSION QUE SE LLAMA
		//ID_PARTIDA
		//public $id_nuevo_anfitrion=0;
		
		
		//LOS DOS PRIMEROS ESTABAN IGUALADOS A CERO Y DESPUES LOS CAMBIE SI EN ALGUN MOMENTO FALLA ESE PUEDE SER EL ERROR
			//este tiene un objeto
		public $turno_usuario=NULL;
			//este es un numero entre 0 y 4
		public $estado_usuario_turno=NULL;
		public $objeto_ataque=NULL;
		
		public $objeto_reagrupar=NULL;
		
		public $tarjetas_sacadas=0;
		public $tarjetas_devueltas=0;
		
		//public ultima_modificacion = new array('fichas'=>,);
		
		
		function __construct($objeto_anfitrion,$cantidad_usuarios, $clave){
			$this->clave=$clave;
			$this->paises=array(50);
			//datos creador de partida
			$this->objeto_anfitrion=$objeto_anfitrion;
			
			//futuros datos jugadores;
			$this->objetos_usuarios=array($cantidad_usuarios);
			
				//CREO UN ARREGLO EN EL QUE SE GUARDAN LOS USUARIOS TEMPORALES, ESTOS SON LOS QUE QUIEREN INGRESAR, O SEA SELECCIONAN COLOR, PERO 
				//TODAVIA NO INGRESARON
			$this->objetos_usuarios_temporales=array($cantidad_usuarios-1);
			
			//Pongo todos los campos de los usuarios en NULL
			for($i=0;$i<$cantidad_usuarios;$i++)
				$this->objetos_usuarios[$i]=NULL;
			
			//Meto el objeto anfitrion en objetos_usuarios
			$this->objetos_usuarios[0]=$this->objeto_anfitrion;
			$this->usuarios_efectivos++;
			
			//creo paises y los y continentes
				//America del norte
			$paises_america_norte=array(10);
			
			$this->paises_america_norte[0]=$yukon=new Pais("Yukon",0,1);
			$this->paises[0]=$yukon;
			
			$this->paises_america_norte[1]=$canada= new Pais("Canada",1,1);
			$this->paises[1]=$canada;
			
			$this->paises_america_norte[2]=$alasca= new Pais("Alasca",2,1);
			$this->paises[2]=$alasca;
			
			$this->paises_america_norte[3]=$groenlandia= new Pais("Groenlandia",3,1);
			$this->paises[3]=$groenlandia;
			$this->paises_america_norte[4]=$oregon= new Pais("Oregon",4,1);
			$this->paises[4]=$oregon;
			$this->paises_america_norte[5]=$nueva_york= new Pais("Nueva York",5,1);
			$this->paises[5]=$nueva_york;
			$this->paises_america_norte[6]=$terranova= new Pais("Terranova",6,1);
			$this->paises[6]=$terranova;
			$this->paises_america_norte[7]=$labrador= new Pais("Labrador",7,1);
			$this->paises[7]=$labrador;
			$this->paises_america_norte[8]=$california= new Pais("California",8,1);
			$this->paises[8]=$california;
			$this->paises_america_norte[9]=$mexico= new Pais("Mexico",9,1);
			$this->paises[9]=$mexico;
			
				//America del sur
			$paises_america_sur=array(6);
			$this->paises_america_sur[0]=$colombia= new Pais("Colombia",10,2);
			$this->paises[10]=$colombia;
			$this->paises_america_sur[1]=$brasil= new Pais("Brasil",11,2);
			$this->paises[11]=$brasil;
			$this->paises_america_sur[2]=$peru= new Pais("Peru",12,2);
			$this->paises[12]=$peru;
			$this->paises_america_sur[3]=$chile= new Pais("Chile",13,2);
			$this->paises[13]=$chile;
			$this->paises_america_sur[4]=$argentina= new Pais("Argentina",14,2);
			$this->paises[14]=$argentina;
			$this->paises_america_sur[5]=$uruguay= new Pais("Uruguay",15,2);
			$this->paises[15]=$uruguay;
			
				//Africa
			$paises_africa=array(6);
			$this->paises_africa[0]=$sahara= new Pais("Sahara",16,3);
			$this->paises[16]=$sahara;
			$this->paises_africa[1]=$egipto= new Pais("Egipto",17,3);
			$this->paises[17]=$egipto;
			$this->paises_africa[2]=$etiopia= new Pais("Etiopia",18,3);
			$this->paises[18]=$etiopia;
			$this->paises_africa[3]=$zaire= new Pais("Zaire",19,3);
			$this->paises[19]=$zaire;
			$this->paises_africa[4]=$sudafrica= new Pais("Sudafrica",20,3);
			$this->paises[20]=$sudafrica;
			$this->paises_africa[5]=$madagascar= new Pais("Madagascar",21,3);
			$this->paises[21]=$madagascar;
			
				//Europa
			$paises_europa=array(9);
			$this->paises_europa[0]=$islandia= new Pais("Islandia",22,4);
			$this->paises[22]=$islandia;
			$this->paises_europa[1]=$gran_bretania= new Pais("Gran bretaña",23,4);
			$this->paises[23]=$gran_bretania;
			$this->paises_europa[2]=$suecia= new Pais("Suecia",24,4);
			$this->paises[24]=$suecia;
			$this->paises_europa[3]=$rusia= new Pais("Rusia",25,4);
			$this->paises[25]=$rusia;
			$this->paises_europa[4]=$polonia= new Pais("Polonia",26,4);
			$this->paises[26]=$polonia;
			$this->paises_europa[5]=$alemania= new Pais("Alemania",27,4);
			$this->paises[27]=$alemania;
			$this->paises_europa[6]=$italia= new Pais("Italia",28,4);
			$this->paises[28]=$italia;
			$this->paises_europa[7]=$francia= new Pais("Francia",29,4);
			$this->paises[29]=$francia;
			$this->paises_europa[8]=$espania= new Pais("España",30,4);
			$this->paises[30]=$espania;
				
				//Asia
			$paises_asia=array(15);
			$this->paises_asia[0]=$aral= new Pais("Aral",31,5);
			$this->paises[31]=$aral;
			$this->paises_asia[1]=$tartaria= new Pais("Tartaria",32,5);
			$this->paises[32]=$tartaria;
			$this->paises_asia[2]=$taimir= new Pais("Taimir",33,5);
			$this->paises[33]=$taimir;
			$this->paises_asia[3]=$siberia= new Pais("Siberia",34,5);
			$this->paises[34]=$siberia;
			$this->paises_asia[4]=$camchatca= new Pais("Camchatca",35,5);
			$this->paises[35]=$camchatca;
			$this->paises_asia[5]=$japon= new Pais("Japon",36,5);
			$this->paises[36]=$japon;
			$this->paises_asia[6]=$iran= new Pais("Iran",37,5);
			$this->paises[37]=$iran;
			$this->paises_asia[7]=$mongolia= new Pais("Mongolia",38,5);
			$this->paises[38]=$mongolia;
			$this->paises_asia[8]=$china= new Pais("China",39,5);
			$this->paises[39]=$china;
			$this->paises_asia[9]=$gobi= new Pais("Gobi",40,5);
			$this->paises[40]=$gobi;
			$this->paises_asia[10]=$turquia= new Pais("Turquia",41,5);
			$this->paises[41]=$turquia;
			$this->paises_asia[11]=$israel= new Pais("Israel",42,5);
			$this->paises[42]=$israel;
			$this->paises_asia[12]=$arabia= new Pais("Arabia",43,5);
			$this->paises[43]=$arabia;
			$this->paises_asia[13]=$india= new Pais("India",44,5);
			$this->paises[44]=$india;
			$this->paises_asia[14]=$malasia= new Pais("Malasia",45,5);
			$this->paises[45]=$malasia;
			
				//Oceania
			$paises_oceania=array(4);
			$this->paises_oceania[0]=$sumatra= new Pais("Sumatra",46,6);
			$this->paises[46]=$sumatra;
			$this->paises_oceania[1]=$australia= new Pais("Australia",47,6);
			$this->paises[47]=$australia;
			$this->paises_oceania[2]=$borneo= new Pais("Borneo",48,6);
			$this->paises[48]=$borneo;
			$this->paises_oceania[3]=$java= new Pais("Java",49,6);
			$this->paises[49]=$java;
			
			
				//Creo Continentes
			$this->continentes=array(6);	
			$this->continentes[0] = new Continente("America del norte",1,5,$this->paises_america_norte);
			$this->continentes[1] = new Continente("America del sur",2,3,$this->paises_america_sur);
			$this->continentes[2] = new Continente("Africa",3,3,$this->paises_africa);
			$this->continentes[3] = new Continente("Europa",4,5,$this->paises_europa);
			$this->continentes[4] = new Continente("Asia",5,7,$this->paises_asia);
			$this->continentes[5] = new Continente("Oceania",6,2,$this->paises_oceania);	
			
			//Creo tarjetas
			$this->tarjetas=array(50);
			$this->tarjetas[0]=new Tarjeta(0,1,0);
			$this->tarjetas[1]=new Tarjeta(1,0,0);
			$this->tarjetas[2]=new Tarjeta(2,2,0);
			$this->tarjetas[3]=new Tarjeta(3,1,0);
			$this->tarjetas[4]=new Tarjeta(4,0,0);
			$this->tarjetas[5]=new Tarjeta(5,2,0);
			$this->tarjetas[6]=new Tarjeta(6,0,0);
			$this->tarjetas[7]=new Tarjeta(7,0,0);
			$this->tarjetas[8]=new Tarjeta(8,0,0);
			$this->tarjetas[9]=new Tarjeta(9,0,0);
			$this->tarjetas[10]=new Tarjeta(10,1,0);
			$this->tarjetas[11]=new Tarjeta(11,2,0);
			$this->tarjetas[12]=new Tarjeta(12,2,0);
			$this->tarjetas[13]=new Tarjeta(13,1,0);
			$this->tarjetas[14]=new Tarjeta(14,3,0);
			$this->tarjetas[15]=new Tarjeta(15,1,0);
			$this->tarjetas[16]=new Tarjeta(16,0,0);
			$this->tarjetas[17]=new Tarjeta(17,1,0);
			$this->tarjetas[18]=new Tarjeta(18,1,0);
			$this->tarjetas[19]=new Tarjeta(19,2,0);
			$this->tarjetas[20]=new Tarjeta(20,0,0);
			$this->tarjetas[21]=new Tarjeta(21,2,0);
			$this->tarjetas[22]=new Tarjeta(22,2,0);
			$this->tarjetas[23]=new Tarjeta(23,2,0);
			$this->tarjetas[24]=new Tarjeta(24,2,0);
			$this->tarjetas[25]=new Tarjeta(25,1,0);
			$this->tarjetas[26]=new Tarjeta(26,0,0);
			$this->tarjetas[27]=new Tarjeta(27,2,0);
			$this->tarjetas[28]=new Tarjeta(28,1,0);
			$this->tarjetas[29]=new Tarjeta(29,1,0);
			$this->tarjetas[30]=new Tarjeta(30,1,0);
			$this->tarjetas[31]=new Tarjeta(31,0,0);
			$this->tarjetas[32]=new Tarjeta(32,0,0);
			$this->tarjetas[33]=new Tarjeta(33,3,0);
			$this->tarjetas[34]=new Tarjeta(34,2,0);
			$this->tarjetas[35]=new Tarjeta(35,1,0);
			$this->tarjetas[36]=new Tarjeta(36,0,0);
			$this->tarjetas[37]=new Tarjeta(37,1,0);
			$this->tarjetas[38]=new Tarjeta(38,2,0);
			$this->tarjetas[39]=new Tarjeta(39,2,0);
			$this->tarjetas[40]=new Tarjeta(40,1,0);
			$this->tarjetas[41]=new Tarjeta(41,2,0);
			$this->tarjetas[42]=new Tarjeta(42,2,0);
			$this->tarjetas[43]=new Tarjeta(43,0,0);
			$this->tarjetas[44]=new Tarjeta(44,1,0);
			$this->tarjetas[45]=new Tarjeta(45,0,0);
			$this->tarjetas[46]=new Tarjeta(46,1,0);
			$this->tarjetas[47]=new Tarjeta(47,0,0);
			$this->tarjetas[48]=new Tarjeta(48,2,0);
			$this->tarjetas[49]=new Tarjeta(49,0,0);
			
			
			//Creo objetivos
			//$id, $america_norte,$america_sur,$europa,$africa,$asia,$oceania,$color
			//si hay un 1 es que tiene que hacer continente, menos en el ultimo valor que corresponde al color
			$this->objetivos= array(13);
			$this->objetivos[0] = new Objetivo(0,1,0,0,0,4,2,0);
			$this->objetivos[1] = new Objetivo(1,0,0,0,0,0,0,6);
			$this->objetivos[2] = new Objetivo(2,0,0,0,0,0,0,2);
			$this->objetivos[3] = new Objetivo(3,0,0,0,0,0,0,1);
			$this->objetivos[4] = new Objetivo(4,0,2,0,0,1,0,0);
			$this->objetivos[5] = new Objetivo(5,0,1,0,1,4,0,0);
			$this->objetivos[6] = new Objetivo(6,1,0,2,0,0,1,0);
			$this->objetivos[7] = new Objetivo(7,4,2,3,2,3,2,0);
			$this->objetivos[8] = new Objetivo(8,5,0,0,1,0,1,0);
			$this->objetivos[9] = new Objetivo(9,0,2,1,0,4,0,0);
			$this->objetivos[10]= new Objetivo(10,0,0,0,0,0,0,3);
			$this->objetivos[11]= new Objetivo(11,0,0,0,0,0,0,4);
			$this->objetivos[12]= new Objetivo(12,0,0,0,0,0,0,5);
		}
		//meti mano puede haber un error
		function setUsuarios($objetos_usuarios){
			for($i=0;$i<sizeof($this->objetos_usuarios);$i++){
				//guardo id del usuario en el primer lugar libre del arreglo
				if($this->objetos_usuarios[$i]==NULL){
					$this->objetos_usuarios[$i]=$objetos_usuarios;
					$this->usuarios_efectivos++;
					//Fuerzo la salida del for de lo contrario lo seguiria guardando
					return;
				}
			}
		}
		
		

		
		function setAvanzarTurno(){			
				//recorro el arreglo usuario
			for($i=1;$i<=sizeof($this->objetos_usuarios);$i++){
					//si el usuario que agarro es igual al usuario en turno 
				if(  $this->objetos_usuarios[$i-1]->getId() == $this->turno_usuario->getId() ){
					// compruebo que tampoco sea el ultimo del arreglo
					if( ($i != sizeof($this->objetos_usuarios)) ){
						
							//antes de entregar el turno le reseteo (pongo igual a 0) la bandera que dice que gano un pais
						$this->turno_usuario->setSaqueTarjetaReset();			
						
						//COMPRUEBO QUE NO NO HAYA SIDO ELIMINADO EL USUARIO AL QUE SE LE VA A ENTREGAR EL TURNO
						//SI FUE ELIMINADO TRATO DE PONER EL PROXIMO Y ASI HASTA LLEGAR AL ULTIMO, Y SI ESTE TAMBIEN FUE ELIMINADO, LLAMO A setNuevaRonda()
							
							//ESTE FOR EMPIEZA A TOMAR DESDE EL USUARIO QUE LE SIGUE AL QUE ESTA ENTREGANDO EL TURNO
						$entrego_turno=0;
						for($j=$i;$j<sizeof($this->objetos_usuarios);$j++){
								//SI EL USUARIO QUE SIGUE NO FUE ELIMINADO Y Y TAMPOCO ES EL ULTIMO DEL ARREGLO
							if($this->objetos_usuarios[$j]->getEliminado() == NULL ){
									
									//pongo como usuario en turno el proximo usuario del arreglo 
								$this->turno_usuario= $this->objetos_usuarios[$j];
								
									//PONGO EL ESTADO DEL USUARIO EN TURNO EN 0 QUE ES EN ATAQUE.
								$this->estado_usuario_turno=0;
									
									//fuerzo la salida del for
								$j=sizeof($this->objetos_usuarios);
								
									//con esto digo que pudo entregar el turno mas abajo lo compara y si no pudo entregarlo, llama a nueva ronda
									//QUIERE DECIR QUE NO HAY MAS USUARIOS POR JUGAR EN EL ARREGLO
								$entrego_turno=1;
							}							
						}
							//SI AL SALIR DEL FOR ANTERIOR NO PUDO ENTREGAR EL TURNO, LLAMA A UNA NUEVA RONDA
						if($entrego_turno == 0)
								//empieza un turno nuevo
							$this->setNuevaRonda();
							
							//fuerzo el finalizado del for, si no hago esto siempre va a ir al ultimo jugador del arreglo
						$i=sizeof($this->objetos_usuarios)+1;
					}
					else
							//empieza un turno nuevo
						$this->setNuevaRonda();
				}
					
			}			
			
			
		}
		
		function setNuevaRonda(){
			$jugadores_activos=0;
				//RECORRO TODOS LOS USUARIOS PARA CONTAR CUANTOS HAY ACTIVOS, O SEA CONTAR LOS QUE NO FUERON ELIMINADOS
			for($j=0;$j<sizeof($this->objetos_usuarios);$j++){
					//SI EL USUARIO QUE SIGUE NO FUE ELIMINADO Y INCREMENTO EL CONTADOR DE JUGADORES ACTIVOS
				if($this->objetos_usuarios[$j]->getEliminado() == NULL )
					$jugadores_activos++;
			}
			
			
			if($jugadores_activos >= 2){
				
					//avanzo el arreglo
				$tmp_primer_usuario=$this->objetos_usuarios[0];
				for($i=0;$i<sizeof($this->objetos_usuarios)-1;$i++){
					$this->objetos_usuarios[$i]=$this->objetos_usuarios[$i+1];
				}
				$this->objetos_usuarios[$i]=$tmp_primer_usuario;
				
				
				//RECORRO DESDE EL PRIMER USUARIO HASTA EL ULTIMO, ESTO LO HAGO PORQUE VOY COMPROBANDO QUE NO ESTEN ELIMINADOS, Y SI ESTA ELIMINADO
				//AVANZO AL PROXIMO. SIEMPRE VA A TENER QUE HABER JUGADORES QUE NO ESTEN ELIMINADOS, POR EL IF QUE TENGO ARRIBA QUE COMPRUEBA CUANTOS JUGADORES HAY
				for($j=0;$j<sizeof($this->objetos_usuarios);$j++){
					if($this->objetos_usuarios[$j]->getEliminado() == NULL ){
						$this->turno_usuario=$this->objetos_usuarios[$j];
						$this->estado_usuario_turno=3;						

						//crea un objeto Incorporar y lo mete en el usuario que quedo primero en la ronda
						$this->turno_usuario->setObjetoIncorporar(new Incorporar($this->turno_usuario, $this));	
					
							//cuando empieza una ronda nueva a todos los paises los pone en estado de que no recibieron nada de reagrupamient
							//esto lo hago porque sino en las siguientes rondas, las fichas que recibio de reagrupadas anteriores no las puede enviar
						for($i=0;$i<50;$i++){
							$this->paises[$i]->setRecibidoCero();
						}
							//incremento la variable # de ronda
						$this->ronda++;
						
							//FUERZO LA SALIDA DEL FOR
						$j=sizeof($this->objetos_usuarios);
					}	
									
				}
			}
			else{
					//INDICA QUE LA PARTIDA FINALIZO, PORQUE HAY UN SOLO JUGADOR
				$this->estado_usuario_turno=5;
			}
		}
			
		
		function getJugadorPorId($id){
			foreach($this->objetos_usuarios as $usuario){
				if($usuario->getId() == $id)
					return $usuario;
			}
		
		}	
		
		//GENERA LA TRANSFERENCIA DE LA PARTIDA, ENTREGA UN NUMERO ENTRE 1 Y 999999 CUANDO FUE CORRECTA Y UN 0 SI NO SE LOGRO
		function setTransferirPartida($id){
			
			
			//COMPRUEBO QUE UNA SOLA VEZ PUEDA ENTREGAR SU SESSION
			//O SEA SI YA ESTA EN TRAMITE LA ENTREGA SALE LA FUNCION
			for($i=0;$i<6;$i++)	
				if($this->id_emisor[$i]== $id)
					return 0;
			
			for($i=0;$i<6;$i++){
				
				//GUARDO EL ID Y LE GENERO UNA CLAVE EN EL PRIMER LUGAR DEL ARREGLO VACIO
				//ESTO ULTIMO ES PORQUE MUCHOS A LA VEZ PUEDEN ESTAR ENTREGANDO SU SESSION
				//PREGUNTO SI EL QEU QUIERE TRANSFERIR LA PARTIDA NO ES EL QUE LA CREO
				if($this->id_emisor[$i] == NULL && $this->objeto_anfitrion->getId() != $id){
					$this->id_emisor[$i]=$id;
					$this->clave_emisor[$i]=rand(1,999999);
					return $this->clave_emisor[$i];
				}
			}
			return 0;
		}
		
			//SI LOS DATOS QUE LE ENVIA EL SOLICITANTE CONCUERDAN INDICA QUE PUEDE ADQUIRIR LA SESSION
			//DEVUELVE UN 0 PARA INDICAR QUE FUE CORRECTO Y UN CERO PARA INDICAR QUE FUE ERRONEO
		function getTransferirPartida($id_emisor,$clave){
			
			for($i=0;$i<6;$i++){
				if($this->id_emisor[$i] == $id_emisor && $this->clave_emisor[$i]==$clave){
					$this->id_emisor[$i]=NULL;
					$this->clave_emisor[$i]=NULL;
					return 0;
				}
			}
			return 1;
		}
		
		
	}
?>