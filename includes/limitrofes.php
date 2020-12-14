<?php
/* devuelve 1 si es que son limitrofes los paises que viene*/

function limitrofes($pais1,$pais2){
			switch( $pais1->getId() ){
				case 0: //yucon
					switch($pais2->getId()){
						
						case 1://canada
							return 1;
						break;
						case 2://alasca
							return 1;
						break;
						case 4://oregon
							return 1;
						break;
					default: return 0;
					//llave switch hijos	
					}	
				break;	
					
				case 1: //canada
					switch($pais2->getId()){
						
						case 0://yucon
							return 1;
						break;
						case 4://oregon
							return 1;
						break;
						case 5://nueva york
							return 1;
						break;
						case 6://terranova
							return 1;
						break;
					default: return 0;
					//llave switch hijos	
					}	
				break;
				case 2: //alasca
					switch($pais2->getId()){
						case 0://yucon
							return 1;
						break;
						case 4://oregon
							return 1;
						break;
						case 35://alasca
							return 1;
						break;
					default: return 0;
					//llave switch hijos	
					}	
				break;
				
				case 3: //groenlandia
					switch($pais2->getId()){
						case 7://labrador
							return 1;
						break;
						case 5://nueva york
							return 1;
						break;
						case 22://islandia
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}
				break;
				case 4: //oregon
					switch($pais2->getId()){
						case 2:
							return 1;
						break;
						case 0:
							return 1;
						break;
						case 1:
							return 1;
						break;
						case 5:
							return 1;
						break;
						case 8:
							return 1;
						break;						
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 5: //nueva york
					switch($pais2->getId()){
						case 1:
							return 1;
						break;
						case 4:
							return 1;
						break;
						case 8:
							return 1;
						break;
						case 6:
							return 1;
						break;
						case 3:
							return 1;
						break;						
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 6: //terranova
					switch($pais2->getId()){
						case 1:
							return 1;
						break;
						case 5:
							return 1;
						break;
						case 7:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 7: //labrador
					switch($pais2->getId()){
						case 6:
							return 1;
						break;
						case 3:
							return 1;
						break;
					
						default: return 0;
					//llave switch hijos	
					}
				break;
				case 8: //california
					switch($pais2->getId()){
						case 4:
							return 1;
						break;
						case 5:
							return 1;
						break;
						case 9:
							return 1;
						break;						
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 9: //mexico
					switch($pais2->getId()){
						case 8:
							return 1;
						break;
						case 10:
							return 1;
						break;				
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 10: //colombia
					switch($pais2->getId()){
						case 9:
							return 1;
						break;
						case 12:
							return 1;
						break;
						case 11:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 11: //brasil
					switch($pais2->getId()){
						case 10:
							return 1;
						break;
						case 12:
							return 1;
						break;
						case 14:
							return 1;
						break;
						case 15:
							return 1;
						break;
						case 16:
							return 1;
						break;						
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 12: //peru
					switch($pais2->getId()){
						case 10:
							return 1;
						break;
						case 11:
							return 1;
						break;
						case 13:
							return 1;
						break;
						case 14:
							return 1;
						break;					
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 13: //chile
					switch($pais2->getId()){
						case 12:
							return 1;
						break;
						case 14:
							return 1;
						break;
						case 47:
							return 1;
						break;	
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 14: //argentina
					switch($pais2->getId()){
						case 11:
							return 1;
						break;
						case 12:
							return 1;
						break;
						case 13:
							return 1;
						break;
						case 15:
							return 1;
						break;			
						default: return 0;
					//llave switch hijos	
					}			
				break;
				case 15: //uruguay
					switch($pais2->getId()){
						case 11:
							return 1;
						break;
						case 14:
							return 1;
						break;				
						default: return 0;
					//llave switch hijos	
					}
				break;
				case 16: //sahara
					switch($pais2->getId()){
						case 11:
							return 1;
						break;
						case 30:
							return 1;
						break;
						case 17:
							return 1;
						break;
						case 18:
							return 1;
						break;
						case 19:
							return 1;
						break;						
						default: return 0;
					//llave switch hijos	
					}
				break;
				case 17: //egipto
					switch($pais2->getId()){
						case 16:
							return 1;
						break;
						case 18:
							return 1;
						break;
						case 21:
							return 1;
						break;
						case 26:
							return 1;
						break;
						case 41:
							return 1;
						break;	
						case 42:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 18: //etiopia
					switch($pais2->getId()){
						case 16:
							return 1;
						break;
						case 17:
							return 1;
						break;
						case 19:
							return 1;
						break;
						case 20:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}
				break;
				case 19: //zaire
					switch($pais2->getId()){
						case 16:
							return 1;
						break;
						case 18:
							return 1;
						break;
						case 21:
							return 1;
						break;
						case 20:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 20: //sudafrica
					switch($pais2->getId()){
						case 19:
							return 1;
						break;
						case 18:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 21: //madagascar
					switch($pais2->getId()){
						case 17:
							return 1;
						break;
						case 19:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 22: //islandia
					switch($pais2->getId()){
						case 3:
							return 1;
						break;
						case 23:
							return 1;
						break;
						case 24:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 23: //gran bretaña
					switch($pais2->getId()){
						case 27:
							return 1;
						break;
						case 30:
							return 1;
						break;
						case 22:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 24: //suecia
					switch($pais2->getId()){
						case 25:
							return 1;
						break;
						case 22:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 25: //rusia
					switch($pais2->getId()){
						case 24:
							return 1;
						break;
						case 26:
							return 1;
						break;
						case 31:
							return 1;
						break;
						case 37:
							return 1;
						break;
						case 41:
							return 1;
						break;	
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 26: //polonia
					switch($pais2->getId()){
						case 27:
							return 1;
						break;
						case 25:
							return 1;
						break;

						case 17:
							return 1;
						break;
						case 41:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 27: //alemania
					switch($pais2->getId()){
						case 23:
							return 1;
						break;
						case 29:
							return 1;
						break;
						case 28:
							return 1;
						break;
						case 26:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 28: //italia
					switch($pais2->getId()){
						case 27:
							return 1;
						break;
						case 29:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 29: //francia
					switch($pais2->getId()){
						case 27:
							return 1;
						break;
						case 28:
							return 1;
						break;
						case 30:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 30: //españa
					switch($pais2->getId()){
						case 23:
							return 1;
						break;
						case 29:
							return 1;
						break;
						case 16:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}	
				break;
				case 31: //aral
					switch($pais2->getId()){
						case 25:
							return 1;
						break;
						case 37:
							return 1;
						break;
						case 34:
							return 1;
						break;
						case 32:
							return 1;
						break;
						case 38:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 32: //tartaria
					switch($pais2->getId()){
						case 31:
							return 1;
						break;
						case 33:
							return 1;
						break;
						case 34:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 33: //taimir
					switch($pais2->getId()){
						case 32:
							return 1;
						break;
						case 34:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 34: //siberia
					switch($pais2->getId()){
						case 31:
							return 1;
						break;
						case 32:
							return 1;
						break;
						case 33:
							return 1;
						break;
						case 35:
							return 1;
						break;
						case 38:
							return 1;
						break;	
						case 39:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 35: //camchatca
					switch($pais2->getId()){
						case 34:
							return 1;
						break;
						case 36:
							return 1;
						break;
						case 39:
							return 1;
						break;
						case 2:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 36: //japon
					switch($pais2->getId()){
						case 35:
							return 1;
						break;
						case 39:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 37: //iran
					switch($pais2->getId()){
						case 25:
							return 1;
						break;
						case 31:
							return 1;
						break;
						case 41:
							return 1;
						break;
						case 44:
							return 1;
						break;
						case 39:
							return 1;
						break;
						case 40:
							return 1;
						break;
						case 38:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}					
				break;
				case 38: //mongolia
					switch($pais2->getId()){
						case 31:
							return 1;
						break;
						case 34:
							return 1;
						break;
						case 37:
							return 1;
						break;
						case 39:
							return 1;
						break;
						case 40:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 39: //china
					switch($pais2->getId()){
						case 34:
							return 1;
						break;
						case 35:
							return 1;
						break;
						case 38:
							return 1;
						break;
						case 36:
							return 1;
						break;
						case 40:
							return 1;
						break;	
						case 37:
							return 1;
						break;
						case 44:
							return 1;
						break;
						case 45:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 40: //gobi
					switch($pais2->getId()){
						case 37:
							return 1;
						break;
						case 38:
							return 1;
						break;
						case 39:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 41: //turquia
					switch($pais2->getId()){
						case 25:
							return 1;
						break;
						case 26:
							return 1;
						break;
						case 37:
							return 1;
						break;
						case 42:
							return 1;
						break;
						case 43:
							return 1;
						break;	
						case 17:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 42: //israel
					switch($pais2->getId()){
						case 41:
							return 1;
						break;
						case 17:
							return 1;
						break;
						case 43:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 43: //arabia
					switch($pais2->getId()){
						case 41:
							return 1;
						break;
						case 42:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 44: //india
					switch($pais2->getId()){
						case 37:
							return 1;
						break;
						case 39:
							return 1;
						break;
						case 45:
							return 1;
						break;
						case 46:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 45: //malasia
					switch($pais2->getId()){
						case 39:
							return 1;
						break;
						case 44:
							return 1;
						break;
						case 48:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 46: //sumatra
					switch($pais2->getId()){
						case 44:
							return 1;
						break;
						case 47:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 47: //australia
					switch($pais2->getId()){
						case 46:
							return 1;
						break;
						case 48:
							return 1;
						break;
						case 49:
							return 1;
						break;
						case 13:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				case 48: //borneo
						switch($pais2->getId()){
						case 45:
							return 1;
						break;
						case 47:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}			
				break;
				case 49: //java
					switch($pais2->getId()){
						case 47:
							return 1;
						break;
						default: return 0;
					//llave switch hijos	
					}				
				break;
				
				
					
			//llave switch superior	
			}
		
		//llave function
		}


?>