var esperando_jugadores=0;
var mi_id=0;
var id_defensa=null;
var turno_usuario=0;
var estado_usuario_turno=null;
var de=51;
var a=51;
var cambio=0;
var tiempo=500;
var entradas=0;
var tmp_turno_usuario=0;
var tmp_estado_usuario_turno=0;
var numero_ultimo=0;
var ultimo_tamanio=0;
var tmp_numero_ultimo=0;
var tmp_scroll=0;
var en_foco=0;
var arreglo_cantidad_incorporar;
var numero_ronda=0;
var tmp_numero_ronda=0;
//cuenta cuantas veces si vio si la partida habia sufrido alguna modificacion, y dio negativo
var entradas_sin_actualizacion=0;

var trampita=0;
var ultima_consulta=0;

var arregloFichas;
var arregloSecuenciador;
var arregloCantidadIncorporar;
var arregloTraeTarjetas;
var arregloMensajes;
var arregloDados;
var arregloUsuarios;

//esta variable tienel estado del usuario en turno de forma temporal, para evaluar si de consulta a consulta sufrio una modificacion, y de esa forma saber si actualizar o no ciertas cosas
var tmp_estado_usuario_turno=null;

//esta variable tiene el jugador en turno de forma temporal, para evaluar si de consulta a consulta sufrio una modificacion, y de esta forma saber si actualizo o no ciertas cosas
var tmp_turno_usuario=null;
var tmp_inicio;
var tmp_fin;
$(document).ready(function() {

		//si el usuario es el qeu esta en turno y el estado es retirar tarjeta, hago que traiga las tarjetas que tiene
		///al plugin que llama se lo puede modificar para que sea llamado por la clase y haga particularmente para cada cosa lo que debe hacer

			
			
	
				$.fn.comprobarTiempo=function(){
				//COMPRUEBO SI EL ARCHIVO SERIALIZADO SE MODIFICO DESDE LA ULTIMA VEZ QUE EL USUARIO HIZO UNA CONSULTA
				//ES PARA NO ACTUALIZAR EL JUEGO SI ES QUE NO HUBO CAMBIO, TAMBIEN SETEA LA NUEVA VARIABLE DE SESSION
				//ID_PARTIDA, SI ES QUE EL ANFITRION DE LA PARTIDA LA TRANSFIRIO
				$.getJSON( 'ajax/__comprobar_tiempo.php?ultima_consulta='+ultima_consulta+'&ultimo_tamanio='+ultimo_tamanio+'&numero_ultimo='+numero_ultimo, function( respuesta ) {
				
					ultima_consulta=respuesta['ultima_consulta'];
					ultimo_tamanio=respuesta['ultimo_tamanio'];
					arregloFichas=respuesta['fichas'];
					arregloSecuenciador=respuesta['secuenciador'];
					arregloCantidadIncorporar=respuesta['cantidadIncorporar'];
					arregloTraeTarjetas=respuesta['traeTarjetas'];
					arregloMensajes=respuesta['mensajes'];
					if(respuesta['dados'] != undefined)
					arregloDados=respuesta['dados'];
					
					arregloUsuarios=respuesta['usuarios'];
					$().cargarChat();
					
					hacer();
				}); 
				}
			
			

	$.timer(300, function(){
	
	
						//Cuando gano un pais compruebo si el cliente que esta corriendo es el atacante
				//se que lo gano porque estado_usuario_turno se pone en 4
			if(estado_usuario_turno==4 && mi_id==turno_usuario){
				//agarro el select y lo meto en this_select
				var this_select=$('#reagrupar select');
						

				//calculo cuantas fichas puede enviar
				//con este if logro que haga el pedido de fichas con las que puede pasar una sola vez
				if((this_select.children()).length==0){
						var option =$(document.createElement('option'));
							option.attr('value',0);
							option.text('Ninguna');
							option.appendTo(this_select);
					$('#accion #reagrupar').animate({'background-color': "#66CC99"}, 1000);
					$('#accion #reagrupar').animate({'background-color': "#D2DACD"}, 1000);

				
					$.getJSON( 'ajax/__calcular_envio.php', function( respuesta ) {
						//alert("Pais ganado, envie tropas");
						//borro todos los option anteriores (esto es muy importante sino el select puede tener valores que no le correspondan)
						//$('#reagrupar select').find('option').remove();
						for(i=1;i<=respuesta[0];i++){
							var option =$(document.createElement('option'));
							option.attr('value',i);
							//con este if hago si si no elije mandar ninguna salga en el select Ninguna pero envie un 0
						//	if(i!=0)
								option.text(i);
							//else
							option.appendTo(this_select);
						}	
						//envio las fichas
						$('#reagrupar input').unbind('click');
						$('#reagrupar input').click(function(){
							$.getJSON( 'ajax/__enviar_fichas.php?cantidad='+this_select.attr('value'), function( respuesta ) {
								//quiere decir que se pudo enviar las fichas
								if(respuesta[0]==1){
									$('#reagrupar').css('z-index','0');
									estado_usuario_turno=0;
									$('#reagrupar select option').remove();
								}
							});
						});
					});
				}
			}
			

		
		if((mi_id == id_defensa) || (turno_usuario == mi_id))
			$('#ataque img').css('visibility','visible');
		else
			$('#ataque img').css('visibility','hidden');

		
			//MUESTRA EN LA PARTE INFERIOR IZQUIERDA, INFO SOBRE LAS FICHAS QUE PUEDE INCORPORAR, O EN LAS OTRAS FASES, QUIEN Y A QUIEN ATACA
		if(estado_usuario_turno == 3){
			$('#desarrollo_otros').css('visibility','hidden');
			$('#desarrollo_incorporar').css('visibility','visible');
		}
		else{
			$('#desarrollo_otros').css('visibility','visible');
			$('#desarrollo_incorporar').css('visibility','hidden');
		}
		})//$.timer(300, function()

			
				
		function hacer(){
		
			
			//$.getJSON( 'ajax/__secuenciador.php', function( respuesta ) {
				respuesta = arregloSecuenciador;
				
				mi_id=respuesta[2];
				turno_usuario=respuesta[0];
				estado_usuario_turno=respuesta[1];
				id_defensa=respuesta[3];
					
				$().mostrarEstadoTurno();	
					//lista jugadores CON ESTO COMPRUEBO QUE SOLO LO HAGA SI SE EMPIEZA A INCORPORAR FICHAS, QUE ES CUANDO CAMBIA EL ORDEN DE LOS JUGADORES
				if((tmp_estado_usuario_turno != estado_usuario_turno) && estado_usuario_turno==3){
					$.getJSON( 'ajax/__lista_jugadores.php', function( respuesta ) {
						for(i=1;i<=respuesta.length;i++)
							if(respuesta[i-1]!=0)
								$('#jugador'+i).traeUsuario(respuesta[i-1]);	
									$('.hidden').ubicarSelector(turno_usuario);	
					}); 
					$.getJSON( 'ajax/__numero_ronda.php', function( respuesta ) {
						$('#numero_ronda').text('Ronda #: '+respuesta);
					}); 
				}
				else
					$('.hidden').ubicarSelector(turno_usuario);
			
			if(estado_usuario_turno == 1)
				$('#reagrupar select').reagrupar();
			
				//trae las tarjetas del jugador
			if(mi_id == turno_usuario && (estado_usuario_turno ==  2 || estado_usuario_turno ==  3 ) )
				$().traeTarjetas();
				
	
			
				$('').actualizarFichas();
				$('').fichasParaIncorporar();
				
			

			
				//Muestra los dados del atacante y de la defensa
			if(estado_usuario_turno == 0){
				$('#dados_atacante').dado();
				$('#dados_defensa').dado();
			}
			
					//VUELVE A LLAMAR A LA FUNCION QUE COMPRUEBA SI SE MODIFICO LA PARTIDA
			tmp_estado_usuario_turno = estado_usuario_turno;
			tmp_turno_usuario = turno_usuario;
		
		setTimeout('$().comprobarTiempo()',700);
	}//FIN FUNCION hacer()
	
});
