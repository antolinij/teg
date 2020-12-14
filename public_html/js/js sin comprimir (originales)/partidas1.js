var tiempo=30;
var jugadores;
var usuarios_reserva;
ultima_consulta=0;
ultimo_tamanio=0;
	//cuenta cuantas veces entro al timer, es para darle visibilidad al select despues de que trajo los datos de los usuarios
var numero_de_entradas_timer=0;
$(document).ready(function() {
		if(document.location != 'http://tegame.com.ar/partidas.php')
		document.location = "partidas.php";
    
    $.fn.esperandoJugadores = function(){
    $.getJSON( 'ajax/__comprobar_tiempo.php?ultima_consulta='+ultima_consulta+'&ultimo_tamanio='+ultimo_tamanio, function( respuesta ){	
    	ultima_consulta=respuesta['ultima_consulta'];
		ultimo_tamanio=respuesta['ultimo_tamanio'];
		//TRAE LOS USUARIOS QEU YA INGRESARON A LA PARTIDA
		$.getJSON( 'ajax/__lista_jugadores.php', function( respuesta ) {
			$.each($('.jugador'),function(objeto,valor){
				$(valor).attr('id',respuesta[objeto]);
				if(respuesta[objeto] != null)
					$.getJSON( 'ajax/__trae_usuario.php?id='+respuesta[objeto], function( data ) {
						$(valor).children(0).text(data['nombre']);
						$(valor).children(1).attr('src',data['url_img']);
						$(valor).css('border','3px solid #000');
						$(valor).css('border-color',nombreColor(data['color']));
						$('option').each(function(){
							if($(this).attr('value') == data['color'])
								$(this).remove();
						});
					}); 
			});
				//DEVUELVE LA VISIBILIDAD AL SELECT, DESPUES DE QUE LISTA LOS JUGADORES QUE YA INGRESARON  
			$('#ingresar select').attr('disabled',false);
		});
	
	
	
	
				//TRAE LOS USUARIOS QUE HICIERON UNA RESERVA
				$.getJSON( 'ajax/__comprobar_reservas.php', function( respuesta ) {
					usuarios_reserva=respuesta;
					//SACO TODOS LOS RESERVADOS, Y ABAJO VUELVO A CARGARLOS DE NUEVO Y DEVUELVO AL SELECT
				$('.jugador').each(function(){
					if($(this).attr('id') == null){
						if($(this).children('a').text() != 'Libre'){
								//negro
							if( $(this).attr('referencia_color') == 0){
								options = new Option('Negro', 0);  
								$('#ingresar select').append(options);
							}
								//amarillo
							if( $(this).attr('referencia_color') == 3){
								options = new Option('Amarillo', 3);  
								$('#ingresar select').append(options);
							}
								//rojo
							if( $(this).attr('referencia_color') == 2){
								options = new Option('Rojo', 2);  
								$('#ingresar select').append(options);
							}
								//magenta
							if( $(this).attr('referencia_color') == 4){
								options = new Option('Magenta', 4);  
								$('#ingresar select').append(options);
							}
								//verde
							if( $(this).attr('referencia_color') == 5){
								options = new Option('Verde', 5);  
								$('#ingresar select').append(options);
							}
								//Azul
							if( $(this).attr('referencia_color') == 6){
								options = new Option('Azul', 6);  
								$('#ingresar select').append(options);
							}
							
														
							$(this).children('img').attr('src', 'none');
							$(this).children('a').text('Libre');
							$(this).css('border', '1px dashed #000');
						}
						
					}
							
				});
				
				//SI HAY RESPUESTA, ES PORQUE HAY RESERVAS, EN TONCES LAS CARGO
				if(usuarios_reserva != null){
					for(i=0;i<usuarios_reserva.length;i++){
							entre=0;
						$('.jugador').each(function(){
							if($(this).attr('id') == null && entre==0 && usuarios_reserva[i]['id'] != null && $(this).children('a').text()=='Libre'){	
								$(this).children('img').attr('src', 'http://graph.facebook.com/'+usuarios_reserva[i]['id']+'/picture');
								$(this).children('a').text(usuarios_reserva[i]['nombre']);
								$(this).css('border', '1px dashed '+nombreColor(usuarios_reserva[i]['color']));
								
								$(this).attr('referencia_color', usuarios_reserva[i]['color']);
								
								entre=1;
								
								$('option').each(function(){
									if($(this).attr('value') == usuarios_reserva[i]['color'])
										$(this).remove();	
								});
							}
							
							
						});
					}
				}
				
				
				

			});
	
		
		setTimeout('$().esperandoJugadores()',700);
	})
	} //cierra el plugin esperandoJugadores
	
	
	$().esperandoJugadores();
	
		//RESERVA UN LUGAR
	$('#ingresar select').change(function(){
		var this_jugador=0;
		var respuesta_salvada=0;
		if($('#ingresar select option:selected').attr('value') != 0){
			
			
			$.getJSON( 'ajax/__reserva.php?color='+$('#ingresar select option:selected').attr('value'), function( respuesta ) {
				var entre=0;
				$('.jugador').each(function(){
					if($(this).attr('id') == null && entre==0 && respuesta['id'] != null){	
						entre=1;
						jugadores=$(this);
						cuentaRegresiva();
						$('#unirse').attr('disabled',true);
					}
				});
			});
		}
	});
	

});





	function cuentaRegresiva(){
			tiempo--;
			if(tiempo>0){
				$('#ingresar select').attr('disabled','disabled');
				$('#unirse').attr('disabled',false);
				$('#tiempo').text('Reservado por: '+tiempo+'segundos');
				setTimeout('cuentaRegresiva()',1000);
			}
			else{
				$('#tiempo').text('');
				$('#ingresar select').attr('disabled',false);
				$('#unirse').attr('disabled','disabled');
				tiempo=30;
				$("#ingresar select option[value=0]").attr("selected",true);
			}
		
	}