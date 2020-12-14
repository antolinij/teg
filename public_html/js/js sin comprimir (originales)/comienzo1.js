$(document).ready(function() {
entrada=0;
	
	
	$.timer(600, function(timer){
			
			if($('#juego_terminado').css('visibility') == 'hidden')
		if(estado_usuario_turno == 5){
				
			$.getJSON( 'ajax/__traer_ganador.php', function( respuesta ) {
					//Muestra el objetivo
				$('#juego_terminado img').attr('src','fondos/objetivo'+respuesta[1]+'.png');
					//CARGA LOS DATOS DEL USUARIO QUE GANO
				$.getJSON( 'ajax/__trae_usuario.php?id='+respuesta[0], function( data ) {
					$('#ganador a').text(data.nombre);
					$('#ganador').css('border-color',nombreColor(data.color));
					$('#ganador div').css('background-image','url('+data.url_img+')');
					$('#ganador div').css('border','1px solid #000');
					$('#fondo_info_usuario').css('visibility','visible');
					$('#juego_terminado').css('visibility','visible');			
				});	
			}); 
		}
	
	
		//slider valor
		valor_slider = $("#slider").slider( "option", "value" );
		if(valor_slider == 20)
			$('#mapa_nombres').css('visibility','hidden');
		else{
			$('#mapa_nombres').css('visibility','visible');
			$('#mapa_nombres').css('filter','alpha(opacity='+valor_slider+')');
			$('#mapa_nombres').css('-moz-opacity','.'+valor_slider);
			$('#mapa_nombres').css('opacity','.'+valor_slider);
		}
			///////////MODIFICACION DEL TITULO DE LA PAGINA PARA AVISAR DE ACCION

			//LE INTERCALA EL TITULO ENTRE .::TEGame.com.ar::. y debe tirar dados al usuario que deba defendeser
		if(id_defensa == mi_id){
			if(entrada==0){
				$("title").text("Jugando | TEGame.com.ar");
				entrada++;
			}
			else{
				$("title").text("Debe defenderse | TEGame.com.ar");
				entrada=0;
			}
		}
		else
			$("title").text("TEGame.com.ar");					

		if(mi_id==turno_usuario)
			switch(estado_usuario_turno){
				case 0:
					if(entrada==0){
						$("title").text("TEGame.com.ar");
						entrada++;}
					else{
						$("title").text("Fase | Ataque");
						entrada=0;}
				break;
				case 1:
					if(entrada==0){
						$("title").text("TEGame.com.ar");
						entrada++;}
					else{
						$("title").text("Fase | Reagrupar");
						entrada=0;}
				break;
				case 2:
					if(entrada==0){
						$("title").text("TEGame.com.ar");
						entrada++;}
					else{
						$("title").text("Fase | Tarjetas");
						entrada=0;}
				break;
				case 3:
					if(entrada==0){
						$("title").text("TEGame.com.ar");
						entrada++;}
					else{
						$("title").text("Fase | Incorporar");
						entrada=0;}
				break;
				case 4:
					if(entrada==0){
						$("title").text("TEGame.com.ar");
						entrada++;}
					else{
						$("title").text("Pais ganado | Enviar tropas");
						entrada=0;}
				break;
			}
		/////////FIN MODIFICACION DEL TITULO

		//trae los id de los jugadores activos hasta el momento en la partida y llama a la funcion que trae los datos y los carga
		//en el rectangulo, este proceso se realiza hasta que se complete el cupo de la partida y
		//cargue todos los jugadoresque conforman la partida

			
	})/////////////PRIMER TIMER
	
	$.fn.esperando_jugadores = function(){
		if(esperando_jugadores==0){
			$.getJSON( 'ajax/__comprobar_tiempo.php?ultima_consulta='+ultima_consulta+'&ultimo_tamanio='+ultimo_tamanio, function( respuesta ) {
				ultima_consulta=respuesta['ultima_consulta'];
				ultimo_tamanio=respuesta['ultimo_tamanio'];
				$.getJSON( 'ajax/__lista_jugadores.php', function( respuesta ) {
					for(i=1;i<=respuesta.length;i++){
						if(respuesta[i-1]!=0)
							$('#jugador'+i).traeUsuariobis(respuesta[i-1]);
						else{
							esperando_jugadores=1;
								if(trampita == 0){
									$().touch();
									$().comprobarTiempo();
									trampita=1;
								}	

								//no es qeu se haya recargado la pagina, pero de esta forma logro, que al ingresar todos los usuarios
								//se deje bien dibujado el comienzo de la partida

							$().seRecargoPagina();
						}
					}
					$().esperando_jugadores();					 	
				}); 
				$().cargarChat();
			})
		}
	}

	$().esperando_jugadores();





	//LO SAQUE PORQUE EN ALGUNOS NAVEGADORES RECARGABA ETERNAMENTE LA PAGINA
/*	if(document.location != 'http://tegame.com.ar/juego.php')
		document.location = "juego.php";*/

		//ACTIVA EL BOTON GANE AGREGUE LA LLAMADA A FACEBOOK
	$('#info_usuarios_gane').click(function(){
		$.getJSON( 'ajax/__gane.php', function( respuesta ) {
			$().infoUsuario();
			if(respuesta== 'si')
				alert("gano");				
			if(respuesta == 'no')
				alert("no gano");
				
		});
	});
	
	///seteo las fichas para que se incorporen ejercitos al hacerles click
	$('.ficha').mousedown(function(){
		tmp_inicio = new Date().getTime();

	})
	
	$('.ficha').mouseup(function(e){
		tmp_fin =new Date().getTime();
		if((tmp_fin - tmp_inicio) > 1000 && estado_usuario_turno==3 && mi_id==turno_usuario && $(this).attr('name') == mi_id ){
			$('#incorporar_varias *').remove();
			
			
			for(i=0;i <= arreglo_cantidad_incorporar[3];i++){
				options = new Option(i, i);  
				$('#incorporar_varias').append(options);
			}	
			
			$('#incorporar_varias').css('top',(e.pageY-40));
			$('#incorporar_varias').css('left',(e.pageX-45));
			$('#incorporar_varias').css('visibility','visible');
			$('#incorporar_varias').attr('name', $(this).attr('id'));
		}
		else{
			$(this).clickFicha(1);
			$('#incorporar_varias').css('visibility','hidden');	
			
		}
	})
	
	$('#incorporar_varias').change(function(){
		$('#'+$('#incorporar_varias').attr('name')).clickFicha(Number($('#incorporar_varias option:selected').attr('value')));
		$('#incorporar_varias').css('visibility','hidden');	
	})

	

		//centro la ventana
	$(window).scrollLeft((1510-window.innerWidth)/2);
	
		///carga los valores de los slider que modifican el fondo de la pagina
	$("#slider_rojo").slider({ max: 255 });
	$("#slider_rojo").slider({ min: 0 });
	$("#slider_rojo").css('background-color','red');
	
	$("#slider_verde").slider({ max: 255 });
	$("#slider_verde").slider({ min: 0 });
	$("#slider_verde").css('background-color','green');
	
	$("#slider_azul").slider({ max: 255 });
	$("#slider_azul").slider({ min: 0 });
	$("#slider_azul").css('background-color','blue');
	
	$("#color_fondo *").mouseup(function(){
		$().colorFondo($(this));
	})
	
		//maneja lo que se esta ingresando en el chat, en el textarea
    $('#chat textarea').keypress(function(tecla){	
    	if(tecla.which == 13)
  			$().enviarMensaje(tecla);	
  		if($('#chat textarea').val().length > 29){
  			$('#chat textarea').css('height','30px');
  			$('#chat #todos_los_mensajes').css('margin-bottom','10px');
  			$('#chat #todos_los_mensajes').css('height','305px');

  			if($('#chat textarea').val().length > 57){
  				$('#chat textarea').css('height','40px');
  				$('#chat #todos_los_mensajes').css('margin-bottom','20px');
  				$('#chat #todos_los_mensajes').css('height','295px');

  			}
  		}
  		else{
  			$('#chat textarea').css('height','20px');
  			$('#chat #todos_los_mensajes').css('margin-bottom','0px');
  			$('#chat #todos_los_mensajes').css('height','315px');

  		}
	});
    

		// agrando el chat
		$('#chat').mouseover(function(){
			$('#chat').css('height','350px');
			$('#chat').css('z-index','50');
			$('#chat textarea').css('visibility','visible');
			$('#ultimo_mensaje *').css('visibility','hidden');
			$('#ultimo_mensaje').css('visibility','hidden');
			$('#todos_los_mensajes').css('visibility','visible');
			$('#todos_los_mensajes *').css('visibility','visible');
			$('#chat textarea').focus();
		});
		$('#chat').mouseout(function(){
			$('#chat').css('height','65px');
			$('#chat').css('z-index','50');
			$('#chat textarea').css('visibility','hidden');
			$('#ultimo_mensaje *').css('visibility','visible');
			$('#ultimo_mensaje').css('visibility','visible');
			$('#todos_los_mensajes').css('visibility','hidden');
			$('#todos_los_mensajes *').css('visibility','hidden');
			$('#chat textarea').blur();
			
		});
		



		//le asigna a los li incorporar atacar reagrupar y tarjeta en el evento click
		//el llamado a al script avanzar_proceso.php que hace que se valla a proximo paso o se finalise.
	$('#estado_turno li').click(function(){
		$(this).avanzarProceso();
	});
		//hace lo mismo que el anterior pero para el boton finalizar
	$('#finalizar').dblclick(function(){
		$(this).avanzarProceso();
	});
		//asigna la accion click al cubilete
	$('#ataque img').click(function(){
		$.getJSON( 'ajax/__ataque.php', function( respuesta ) {
			
		});
	});
		//slider de tiempo seteo maximo minimo y valor inicial
	$("#slider").slider({ max: 100 });
	$("#slider").slider({ min: 50 });
	$("#slider").slider( "value", "50" );

		//hago que cuando pase por arriba de una ficha diga el nombre del pais
	$('.ficha').mouseover(function(){
		$(this).mostrarNombre();
		$('#nombre_pais').css('z-index','10');
	});
	
	$('.ficha').mouseout(function(){
		$('#nombre_pais').text('');
		$('#nombre_pais').css('z-index','-1');
	});
		//hago que cuando pase por un pais diga el nombre del pais
	$('area').mouseover(function(){
		id = $(this).attr('id').split('-')
		$('#ficha'+id[1]).mostrarNombre();
		$('#nombre_pais').css('z-index','10');
	});
		//saco el nombre del pais cuando sale de un area el mouse
	$('area').mouseout(function(){
		$('#nombre_pais').text('');
		$('#nombre_pais').css('z-index','-1');
	});	
	
	
	
	
		//arrastra el nombre del pais, por donde este el puntero del mouse
	$('#mapa').mousemove(function(e){
		$('#nombre_pais').css('top',(e.pageY+10));
		$('#nombre_pais').css('left',(e.pageX+10));
		$('#nombre_pais').css('visibility','visible');
	});
	$('#mapa').mouseout(function(e){
		$('#nombre_pais').css('visibility','hidden');
	});
		//hago que cambie el cursor a la mano cuando paso por arriba de alguna tarjeta	 
	$('#informacion .tarjeta').css('cursor','pointer');

	var color_borde;
		//le pongo un borde de 4px al pais al que hace referencia la tarjeta, cuando paso por encima de ella
	$('#informacion .tarjeta').mouseover(function(){
		var nombre = $(this).children('marquee').text();
		$('#mapa input').each(function(nodo){
			if($(this).attr('nombre') == nombre){
				color_borde=$(this).css('border');
				$(this).css('border','4px solid #FFF');
			}
		}); 
	});
		//le devuelvo el borde original
	$('#informacion .tarjeta').mouseout(function(){
		var nombre = $(this).children('marquee').text();
		$('#mapa input').each(function(nodo){ 
			if($(this).attr('nombre') == nombre){
				$(this).css('border', color_borde);
			}
		}); 
	});

		//slider de tiempo seteo maximo minimo y valor inicial
	$("#slider").slider({ max: 99 });
	$("#slider").slider({ min: 20 });
	$("#slider").slider( "value", "20" );
	$("#slider").slider({ step: 30});

		//HAGO QUE HAGA CLICK EN UN JUGADOR Y TRAIGA AL FRENTE LAS OPCIONES
	$('.usuario').click(function(){
		$(this).infoUsuario();
	});

		//SI HAGO CLICK EN EL MAPA CON NOMBRES, MUEVE EL SLIDER A 20 ENTONCES MUESTRA EL MAPA SIN NOMBRES
	$('#mapa_nombres').click(function(){
		$("#slider").slider( "value", "20" );
	});


		//hago que cuando el usuario haga click retirar tarjeta, llame a la funcion que pide una tarjeta
	$('#retirar_tarjeta').click(function(){
		$(this).sacarTarjeta();
	});
		//seleccionar tarjetas
	$('#informacion .tarjeta').click(function(){
		$(this).seleccionarTartjeta();
	});
		//le asigna el click al boton cambiar tarjeta
	$('#cambiar_tarjeta').click(function(){
		$(this).cambiarTarjetas();
	});
		//le asigna el click al boton cobrar tarjeta
	$('#cobrar_tarjeta').click(function(){
		$(this).cobrar();
	});
		//le asigna el click al area de un pais
	$('area').click(function() {
		var id = $(this).attr('id').split('-');
		$('#ficha'+id[1]).clickFicha(1);
		$('#incorporar_varias').css('visibility','hidden');	
	});
	
});