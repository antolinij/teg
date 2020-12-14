<?php 
/*Comprueba si el usuario que la llama ya recibió la ultima modificación del archivo,
*si ya la recibió envía un 0 diciendo que no fue modificado desde el ultimo pedido,
*si fue modificado envía un 1
*/
	session_start();
	
	require_once '../../clases/pais.php';
	require_once '../../clases/continente.php';
	require_once '../../clases/usuarios.php';
	require_once '../../clases/tarjeta.php';
	require_once '../../clases/objetivos.php';
	require_once '../../clases/partida.php';
	require_once '../../clases/ataque.php';
	require_once '../../clases/incorporar.php';
	require_once '../../includes/funciones_archivo.php';
	require_once '../../clases/reagrupar.php';
	require_once '../../clases/mensaje.php';
	
	$id_partida=$_SESSION['id_partida'];
	session_write_close ();
	$ciclos = 0;
//	set_time_limit ( 0 );
//While(!Connection_Aborted() && $trampa < 100) { 
	
While(filemtime('../../partidas/'.$id_partida) <= $_GET['ultima_consulta'] && filesize('../../partidas/'.$id_partida) ==  $_GET['ultimo_tamanio'] && $ciclos != 100) { 
	$ciclos++;
	usleep(300000);
	
	clearstatcache ($tiempo);
	
	Flush(); //Now php will check de connection 
} 
$enviar	['ultima_consulta']=filemtime('../../partidas/'.$id_partida);
$enviar ['ultimo_tamanio']=filesize('../../partidas/'.$id_partida);

if(isset($_SESSION['usuario']))
	$partida = abrir_archivo('../../partidas/'.$_SESSION['id_partida']);
if(isset($_SESSION['usuario']) && $partida->inicializada == 1){
////////ACTUALIZAR FICHAS


		
		$arreglo_paises = $partida->paises;
		
		for($i=0;$i<50;$i++){
			$fichas[0][$i]=$arreglo_paises[$i]->getPropietario()->getColor();
			$fichas[1][$i]=$arreglo_paises[$i]->getFichas();
			$fichas[2][$i]=$arreglo_paises[$i]->getPropietario()->getId();
			$fichas[4][$i]=$arreglo_paises[$i]->getNombre();
				
				//se presupone que el pais tomado por el for no esta seleccionado ni para ataque ni defensa, despues se comprueba y si estan tomado
				//para alguna de las dos se le cambia el estado tal corresponda
				$fichas[3][$i]=0;
	
				//Si hay un objeto ataque
			if($partida->objeto_ataque!=NULL){
					//si el id del pais que esta en objeto ataque como atacante coincide con el pais que se esta seteando le pone 1 sino 0
				if($partida->objeto_ataque->getPaisAtaque()->getId()==$i){
					$fichas[3][$i]=1;
				}
				else{				
					if($partida->objeto_ataque->getPaisDefensa()!=NULL)
						if($partida->objeto_ataque->getPaisDefensa()->getId()==$i)
							$fichas[3][$i]=2;

				}
				
			}

				//Si hay un objeto objeto_reagrupar
			if($partida->objeto_reagrupar!=NULL){
					//si el id del pais que esta en objeto ataque como atacante coincide con el pais que se esta seteando le pone 1 sino 0
				if($partida->objeto_reagrupar->getPaisDe()->getId()==$i){
					$fichas[3][$i]=1;
				}
				else{				
					if($partida->objeto_reagrupar->getPaisA()!=NULL)
						if($partida->objeto_reagrupar->getPaisA()->getId()==$i)
							$fichas[3][$i]=2;

				}
				
			}
		
		}
		$enviar['fichas']=$fichas;

////////////////////fin actualizar fichas	


////////INICIO SECUENCIADOR
		
		$secuenciador[0]=$partida->turno_usuario->getId();
		$secuenciador[1]=$partida->estado_usuario_turno;
		$secuenciador[2]=$_SESSION['id'];
		
		//envia el id del usuario que se debe defender
			//si existe el objeto ataque
		if($partida->objeto_ataque != NULL)
				//si ya esta seteado el pais que debe defenderse
			if($partida->objeto_ataque->getPaisDefensa() !=NULL)
					//pregunta si los dados del ataque son distintos de NULL(es para evitar llamar a un metodo que no esta definido)
				if($partida->objeto_ataque->getBloquear() == 1)
						//si ya tiro los dados el atacante					
					//COMENTE EL IF PORQUE NO ES NECESARIO ESPERAR
					//if(sizeof($partida->objeto_ataque->getDadosAtaque())>0)
						$secuenciador[3]=$partida->objeto_ataque->getPaisDefensa()->getPropietario()->getId();

		
		
			
		$enviar['secuenciador']=$secuenciador;

	
/////////FIN SECUENCIADOR


//////INICIO CANTIDAD INCORPORAR
			//indico las fichas libres a poner por el usuario
		$cantidadIncorporar[0]=$partida->turno_usuario->getObjetoIncorporar()->getLibres();
			//indico las fichas que pone por el el cambio, si es que lo realizo
		$cantidadIncorporar[1]=$partida->turno_usuario->getObjetoIncorporar()->getPorCambio();
			//traigo en un arreglo las fichas que debe poner por cambio, en 0 cuantas fichas poner por america del norte, si es que lo tiene, de lo contrario 0
			//en 1 cuantas para america del sur y asi para cada uno
		$continentes=$partida->turno_usuario->getObjetoIncorporar()->getFichasPorContinentes();
			//sumo todas las fichas que pone por continente, 
		$cantidadIncorporar[2]=$continentes[0]+$continentes[1]+$continentes[2]+$continentes[3]+$continentes[4]+$continentes[5];
			//la suma de todas las fichas que pone por continente
		$cantidadIncorporar[3]=$partida->turno_usuario->getObjetoIncorporar()->getFichasTotales();
			//entre cuantas fichas pone por cada continente de forma discriminada en la posicion 4 esta america del norte en la 5 america del sur y asi....
		$cantidadIncorporar[4]=$continentes[0];
		$cantidadIncorporar[5]=$continentes[1];
		$cantidadIncorporar[6]=$continentes[2];
		$cantidadIncorporar[7]=$continentes[3];
		$cantidadIncorporar[8]=$continentes[4];
		$cantidadIncorporar[9]=$continentes[5];
		$enviar['cantidadIncorporar']=$cantidadIncorporar;
//////FIN CANTIDAD INCORPORAR


/////////TRAE TARJETAS
	
	//creo $respueta=0, y si no se modifica, la respuesta es porque ese jugador no tenia tarjeta
	//en 0 trae el nombre del pais en 1 trae el nombre del dibujo y en 2 pone 1 0 si no fue cobrado y un 1 si fue cobrado
	$traeTarjetas=array(
		0=>array(0=>'',1=>NULL,2=>NULL),
		1=>array(0=>'',1=>NULL,2=>NULL),
		2=>array(0=>'',1=>NULL,2=>NULL),
		3=>array(0=>'',1=>NULL,2=>NULL),
		4=>array(0=>'',1=>NULL,2=>NULL)
		
	);
			//trae al jugador que llamo el script
		$usuario=$partida->getJugadorPorId($_SESSION['id']);
			//recorro el arreglo tarjeta del jugado		
			
			$i=0;
		foreach($usuario->getTarjetas() as $tarjeta){
			if($tarjeta != NULL){
				$traeTarjetas[$i][0]=$tarjeta->getNombrePais($partida);
				
				switch($tarjeta->getLogo()){
					case 0:	
						$traeTarjetas[$i][1]='canon.png';
					break;
					case 1:	
						$traeTarjetas[$i][1]='globo.png';
					break;
					case 2:	
						$traeTarjetas[$i][1]='barco.png';
					break;
					case 3:	
						$traeTarjetas[$i][1]='comodin.png';
					break;
				}
					
					//en 2 pongo el estado(cobrada o no)
				$traeTarjetas[$i][2]=$tarjeta->getEstado();
				$i++;
			}
		}//foreach($partida->tarjetas as $tarjeta)
	
	
	$enviar['traeTarjetas']=$traeTarjetas;

////////////FIN TRAE TARJETAS


//////////RECIBIR MENSAJE
		
		$cantidad=$partida->numero_mensaje - $_GET['numero_ultimo'];
		
		if($cantidad > 100)
			$cantidad =100;
		
		for($i=0;$i<$cantidad;$i++){
				$mensajes[$i]=$partida->chat[sizeof($partida->chat) - $cantidad+$i]->getMensaje();
		}
		$mensajes[$i]=$partida->numero_mensaje;
		$enviar['mensajes']=$mensajes;
////FIN RECIBIR MENSAJES

////INICIO DADOS
			
				if(isset($partida->objeto_ataque))
					$dados['ataque']=$partida->objeto_ataque->getDatosTmpAtaque();
					//echo json_encode($partida->objeto_ataque->getDatosTmpAtaque());

				if(isset($partida->objeto_ataque))
					$dados['defensa']=$partida->objeto_ataque->getDadosTmpDefensa();
					//echo json_encode($partida->objeto_ataque->getDadosTmpDefensa());
if(isset($partida->objeto_ataque))
	$enviar['dados']=$dados;		
else
	$enviar['dados']=NULL;

/////FIN DADOS

///////COMIENZO USUARIOS
		
		
		for($i=0;$i<sizeof($partida->objetos_usuarios);$i++){
						 $usuarios[$i] = array('nombre'=>$partida->objetos_usuarios[$i]->getNombre(),
						 'url_img'=>$partida->objetos_usuarios[$i]->getUrlImg(),
						 'color'=>$partida->objetos_usuarios[$i]->getColor(),
						 'id'=>$partida->objetos_usuarios[$i]->getId());
						 
						 	//PREGUNTO SI EL USUARIO FU ELIMINADO, SI ES ELIMINADO LO INFORMO ENVIANDO eliminado EN LA POSICION ESTADO
						 	//Y DEL LADO DEL CLIENTE LE PONGO TRANSPARENCIA PARA QUE SE NOTE
						 if($partida->objetos_usuarios[$i]->getEliminado() != NULL)
						 	$usuarios[$i]['estado']='eliminado';
						 else
						 	$usuarios[$i]['estado']='en_juego';				
						
			}
			$respuesta[$i]=0;
		$enviar['usuarios']=$usuarios;
		

//////FIN USUARIOS

}
	echo json_encode($enviar);
	
?> 