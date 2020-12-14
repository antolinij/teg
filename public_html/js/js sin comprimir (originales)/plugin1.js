///mediante un id trae y coloca un usuario en el this o sea el div que llama al plugin



$.fn.traeUsuario = function(id){
	//Carga en el div usuario la foto del usuario y el nombre
	var i=0;
	var nodos = $(this).children();
	var div= $(this);
	var data = new Array(5);
	//	$.getJSON( 'ajax/__trae_usuario.php?id='+id, function( data ) {
	for(j=0;j<arregloUsuarios.length;j++)
		if(id != 0 && arregloUsuarios[j]['id'] == id ){

					data['nombre']=arregloUsuarios[j]['nombre'];
					data['url_img']=arregloUsuarios[j]['url_img'];
					data['color']=arregloUsuarios[j]['color'];
					data['estado']=arregloUsuarios[j]['estado'];
					
				j=arregloUsuarios.length;
					
			var color = nombreColor(data.color);
				//Carga la foto del usuario y el nombre en el div que la llamo
			div.css('border-color',color);	
			i=0;
			nodos.each(function(){
				if(i==0)
					$(this).text(data.nombre);
				if(i==1){
					$(this).css('background-image','url('+data.url_img+')');
					$(this).css('border','1px solid #000');
				}
				if(i==2)
					$(this).attr('value', id);
				i++
			});
				//SI EL USUARIO QUE ESTA CARGANDO FUE ELIMINADO, LE PONGO TRANSPARENCIA, AL DIV, TAMBIEN TENGO UN ELSE PORQUE CUANDO ROTA 
				//NO SE MUEVEN LOS DIV SINO QUE CAMBIA SU CONTENIDO, Y SI NO LE VUELVO A SACAR LA TRANSPARENCIA, LA HEREDARIA UNO QUE NO LE CORRESPONDE
			if(data['estado'] == 'eliminado')
				div.css('opacity','0.3');
			else
				div.css('opacity','.9');	
			
				//si el usuario que trae es el que esta en turno, le pone el selector
			if(id == turno_usuario && estado_usuario_turno == 3)
				$('.hidden').ubicarSelector(div.eq(2).attr('value'));

	}
	//	}); 
		//si por id viene un 0 saca de la lista todo(NO PUEDEN HABER USUARIO QUE TENGAN ID 0)
	else
	if(id == 0){
		//pone borde negro
		div.css('border-color','black');	
		nodos.each(function(){
			if(i==0)
				$(this).text(" ");
			if(i==1)
				$(this).css('background-image','none');
			if(i==2)
				$(this).attr('value', '');
				i++;
		});	
	}
};
$.fn.traeUsuariobis = function(id){
	//Carga en el div usuario la foto del usuario y el nombre
	var i=0;
	var nodos = $(this).children();
	var div= $(this);
	if(id!=0)
	$.getJSON( 'ajax/__trae_usuario.php?id='+id, function( data ) {

					
			var color = nombreColor(data.color);
				//Carga la foto del usuario y el nombre en el div que la llamo
			div.css('border-color',color);	
			i=0;
			nodos.each(function(){
				if(i==0)
					$(this).text(data.nombre);
				if(i==1){
					$(this).css('background-image','url('+data.url_img+')');
					$(this).css('border','1px solid #000');
				}
				if(i==2)
					$(this).attr('value', id);
				i++
			});
				//SI EL USUARIO QUE ESTA CARGANDO FUE ELIMINADO, LE PONGO TRANSPARENCIA, AL DIV, TAMBIEN TENGO UN ELSE PORQUE CUANDO ROTA 
				//NO SE MUEVEN LOS DIV SINO QUE CAMBIA SU CONTENIDO, Y SI NO LE VUELVO A SACAR LA TRANSPARENCIA, LA HEREDARIA UNO QUE NO LE CORRESPONDE
			if(data.estado == 'eliminado')
				div.css('opacity','0.3');
			else
				div.css('opacity','.9');	
			
				//si el usuario que trae es el que esta en turno, le pone el selector
			if(id == turno_usuario && estado_usuario_turno == 3){
				//alert("hola");
				$('.hidden').ubicarSelector(div.eq(2).attr('value'));
			}

			}); 
		//si por id viene un 0 saca de la lista todo(NO PUEDEN HABER USUARIO QUE TENGAN ID 0)
	else{
		//pone borde negro
		div.css('border-color','black');	
		nodos.each(function(){
			if(i==0)
				$(this).text(" ");
			if(i==1)
				$(this).css('background-image','none');
			if(i==2)
				$(this).attr('value', '');
				i++;
		});	
	}
};


$.fn.traePais =function(id,accion){
	var nodo=$(this).children();
	pais="Alema–ia";
	if(accion==1)
		nodo.text("De: "+pais);
	else
		nodo.text("A: "+pais);
};

//recarga todas las fichas y dice si estan seleccionadas
$.fn.actualizarFichas = function(){
	//$.getJSON( 'ajax/__actualizar_fichas.php', function( respuesta ) {
		respuesta=arregloFichas;
			//si al menos un pais esta seleccionado esta variable se pone en 1(es para sacar abajo ataque y nombre atacante)
		var seleccionado=0;
		for(i=0;i<50;i++){
				//le pongo el color del propietario a la ficha
			var color=nombreColor(respuesta[0][i]);
			$('#ficha'+i).css({
				'background-color': color
			});
			switch(color){
				case 'black':
					$('#ficha'+i).css('color', '#fff');
				break;
				case 'green':
					$('#ficha'+i).css('color', '#fff');
				break;
				case 'red':
					$('#ficha'+i).css('color', '#fff');
				break;
				case 'blue':
					$('#ficha'+i).css('color', '#fff');
				break;
				case 'magenta':
					$('#ficha'+i).css('color', '#000');
				break;
				case 'yellow':
					$('#ficha'+i).css('color', '#000');
				break;
			}

				//le seteo el atributo nombre a la ficha no es el name es nombre que es uno propio y tiene el nombre del pais
			$('#ficha'+i).attr('nombre' ,respuesta[4][i]);

			//si la cantidad de fichas que tiene un pais es distinta a la cantidad que dice actualizar
			// o sea que se modificaron la cantidad de fichas de una pais hago un efecto para que se note
			if( $('#ficha'+i).attr('value') != respuesta[1][i] && ( (estado_usuario_turno!=3 && mi_id==turno_usuario) || (mi_id!=turno_usuario) ) )	{			
				color_viejo = $('#ficha'+i).css('background-color');
				
				$('#ficha'+i).animate({'background-color':'#fff'},500); 
				$('#ficha'+i).animate({'background-color': color_viejo},500); 
			}

			//cargo la cantidad de fichas que tiene en ese pais
			$('#ficha'+i).attr('value' ,respuesta[1][i]);	

			//en el atributo name pongo el id del due–o del pais
			$('#ficha'+i).attr('name' ,respuesta[2][i]);
			
			//selecciona el pais_de o atacante
			if(respuesta[3][i]==1){
				$('#ficha'+i).css('border', '2px solid #FFF');

				$('#ficha'+i).css('box-shadow', '0px 0px 10px 5px #000');

				$('#pais_de').children().text("De: "+$('#ficha'+i).attr('nombre'));
				$('#usuario_de').traeUsuario(turno_usuario);
				seleccionado=1;
				
			}
			else{	
				if(respuesta[3][i]==2){
					//EL SELECCIONADO AL pais_a o atacado
					$('#ficha'+i).css('border', '2px solid #FFF');
					if(estado_usuario_turno != 1)
						$('#ficha'+i).css('box-shadow', '0px 0px 10px 5px red');
					else
						$('#ficha'+i).css('box-shadow', '0px 0px 5px 1px #000');
					$('#pais_a').children().text("A: "+$('#ficha'+i).attr('nombre'));
					//el id del usuario atacado lo consigo por la ficha
					$('#usuario_a').traeUsuario($('#ficha'+i).attr('name'));
					seleccionado=1;
				}
				else{
					seleccionado++;
					$('#ficha'+i).css('border', '1px solid #000');
					$('#ficha'+i).css('box-shadow', 'none');

				}
			}	
				
		}//for(i=0;i<50;i++)
		if(seleccionado==50){
			$('#pais_de').children().text(" ");
			$('#usuario_de').traeUsuario(0);
			$('#pais_a').children().text(" ");
			$('#usuario_a').traeUsuario(0);
		}

	//}); 
	return;
};

//esto no es un plugin es una funcion y hay que llamarla
//variable = nombreColor(numero del color)
//se le pasa como argumento el numero de color y devuelve el color correspondiente 
//con nombre
function nombreColor(color_numerico){
	var color_texto;
	switch(color_numerico){
		case '1':
			color_texto="black";
		break;
		case '2':
			color_texto="red";
		break;
		case '3':
			color_texto="yellow";
		break;
		case '4':
			color_texto="magenta";
		break;
		case '5':
			color_texto="green";
		break;
		case '6':
			color_texto="blue";
		break;
	}
	return color_texto;
};


///mueve el selector de a cuerdo a quien le toqeu jugar es medio mamarracho
//y usa un hidden para saber quien es el jugador, ese hidden tiene el id del jugador
//recibe el id del usuario al que se le quiere poner el selector
$.fn.ubicarSelector = function (id){
//if(a == 0)
//	alert(id);
	$(this).each(function(){
			//con ese if consigo tener en this el div usuario que necesito
		if($(this).attr('value') == id)
			switch($(this).attr('name')){
				case 'hidden1':
					$('#selector_jugador').animate({top:'90px'},1000);
				break;
				case 'hidden2':
					$('#selector_jugador').animate({top:'160px'},1000);
				break;
				case 'hidden3':
					$('#selector_jugador').animate({top:'230px'},1000);
				break;
				case 'hidden4':
					$('#selector_jugador').animate({top:'300px'},1000);
				break;
				case 'hidden5':
					$('#selector_jugador').animate({top:'370px'},1000);
				break;
				case 'hidden6':
					$('#selector_jugador').animate({top:'440px'},1000);
				break;
			}
	});
};

	//MUY IMPORTANTE, POR THIS SIEMPRE LLEGA UNA FICHA NUNCA UN AREA, CUANDO HAGO CLICK EN UN AREA, LLAMO A ESTE PLUGIN CON LA FICHA CORRESPONDIENTE
$.fn.clickFicha = function(cantidad){
	var entradas_a_incorporar_fichas=0;
	
	//en la variable dis tengo el this, o sea la ficha a laque se le hizo click
	//lo guardo en esta variable porque cuando entra a $.getJSON el this deja de ser la ficha
	var dis=$(this);
	var id_ficha=$(this).attr('id').split('a');
	//consulto si esta en turno
	if(mi_id==turno_usuario){
		if(estado_usuario_turno!=3){//si NO se esta en la fase incorporar ejercito
			$.getJSON( 'ajax/__seleccionar.php?id_pais='+id_ficha[1] , function( respuesta ){
				//si se cumple el pais es del prpietario
				if(respuesta[0]==1){
					dis.css('border', '3px solid #FFF');
					$('#pais_de').children().text("De: "+dis.attr('nombre'));

					$('#usuario_de').traeUsuario(turno_usuario);

					//borro los option del select para que pueda seguir reagrupando
					//si se seleccioanan dos paises para reagrupar y despues se borra la 
					//seleccion el select ya tiene el numero de tropas que podian enviar
					//etnonces con esto las borro esto pasa porque la forma que tengo ede que no entre cada vez que 
					//pide datos (timer) a cargar los valores en el select es decir que los cargue solamente
					//cuando no haya ningun option, y los option los borro despues de que envia tropas.
					$('#reagrupar select').find('option').remove();
				}

			});
			
			//FIN DE if(estado_usuario_turno!=3){	  
		}
		else{//si SE esta en la fase de incorporar ejercito
		
				//desactiva la ficha por unas milesimas de segundo
			dis.attr('disabled', 'disabled');
				//saco el click del area al que tambien pertenese la ficha por unas milesimas de segundo
			$('#area-'+id_ficha[1]).unbind('click');
			
			for(j=0;j<cantidad;j++){
			
				//CON ESTO TRATO DE HACER EN TIEMPO REAL EL INCORPORAR FICHA
				//SI LLEGO ACA PERO CANTIDAD A INCORPORAR ES IGUAL A CERO ES PORQUE SE TRABO ENTONCES ACTUALIZO TODO, Y SINO HAGO QUE PONGA DIRECTO LA FICHA
				if(arreglo_cantidad_incorporar[3] == 0){
					$('').actualizarFichas();
					$().fichasParaIncorporar();
				}
				else{

					
					$().simularIncorporacion(dis);
					

				} 
			
					
				$('#accion #informacion').css('z-index','1');
					//PIDE AL SERVIDOR QUE INCORPORE LAS FICHAS
				$.getJSON( 'ajax/__cargar.php?id_pais='+id_ficha[1] , function( respuesta ){
						//devuelve un 0 si estuvo todo bien y un 5 si tiene 5 tarjetas, por ende cmabio obligado
					if(respuesta[0] == 5){
						$('#informacion').animate({'background-color': "#FF3333"}, 1000);
						$('#informacion').animate({'background-color': "#D2DACD"}, 1000);
					}
						//con esto consigo que al hacer incorporacion multiple, no se quede pegado sobre todo en firefox pasa, despues de hacer
						//la ultima incorporacion, espera 300 ms y hace un touch
					if(entradas_a_incorporar_fichas+1 == cantidad && cantidad > 1){
						setTimeout('$().touch()',300);
					}
					entradas_a_incorporar_fichas++;
				});
			}

				
				//les devuelvo el click al area y a la ficha pasado las milesimas de segundo correspondiente
			if(arreglo_cantidad_incorporar[3] == 0)
				setTimeout('sleepIncorporarFicha("'+id_ficha[1]+'")',3000);
			else
				setTimeout('sleepIncorporarFicha("'+id_ficha[1]+'")',500);
							
			
		} //fin else
		//FIN DE if(mi_id==turno_usuario){
	}
	
};


$.fn.mostrarEstadoTurno = function(){
		//alert(turno_usuario+" "+mi_id+" "+estado_usuario_turno);
		//Limpia todos
	$('#selector_ataque').css('background','none');
	$('#selector_ataque').css('opacity','.6');
	$('#selector_ataque').css('color','#000');
	$('#selector_reagrupar').css('background','none');
	$('#selector_reagrupar').css('opacity','.6');
	$('#selector_reagrupar').css('color','#000');
	$('#selector_tarjeta').css('background','none');
	$('#selector_tarjeta').css('opacity','.6');
	$('#selector_tarjeta').css('color','#000');
	$('#selector_incorporar').css('background','none');
	$('#selector_incorporar').css('opacity','.6');
	$('#selector_incorporar').css('color','#000');
		//EL Z-INDEX DE ATAQUE ESTABA EN 0 PERO LO PUSE EN UNO PARA QUE CUANDO PIERDA UN PAIS
		//LE SIGAN SALIENDO LOS DADOS Y NO LAS TARJETAS, EL PROBLEMA DE MOSTRAR LAS TARJETAS
		//ES QUE CUANDO LO VUELVEN A ATACAR NO SIEMPRE MUESTRA LOS DADOS
	$('#accion #reagrupar').css('z-index','0');
	$('#accion #informacion').css('z-index','0');
	$('#accion #ataque').css('z-index','0');
		//ESTA EN ETAPA DE INCORPORAR PUEDO SEGUIR MODIFICANDO ESTO PARA MEJORAR LO QUE APARECE EN LOS DISTINTOS TURNOS
	/*if(estado_usuario_turno==3){
		$('#accion #informacion').css('z-index','1');
		$('#accion #ataque').css('z-index','0');
	}
	else{
		$('#accion #informacion').css('z-index','0');
		$('#accion #ataque').css('z-index','1');
	}*/
	switch(estado_usuario_turno){
	
		//esta atacando
		case 0:
			$('#selector_ataque').css('background-color','#FFF');
			$('#selector_ataque').css('opacity','1');
			$('#selector_ataque').css('color','#000');
			$('#accion #ataque').css('z-index','1');
		break;
			//esta reagrupando
		case 1:
			$('#selector_reagrupar').css('background-color','#FFF');
			$('#selector_reagrupar').css('opacity','1');
			$('#selector_reagrupar').css('color','#000');
			//if(turno_usuario == mi_id){
			$('#reagrupar').css('z-index','1');
					break;
			//esta en sacar tarjeta
		case 2:
			if(turno_usuario == mi_id){
				$('#selector_tarjeta').css('background-color','#FFF');
				$('#selector_tarjeta').css('opacity','1');
				$('#selector_tarjeta').css('color','#000');
				$('#accion #informacion').css('z-index','1');
			}
		break;
			//esta en incorporar ejercito
		case 3:
			$('#selector_incorporar').css('background-color','#FFF');
			$('#selector_incorporar').css('opacity','1');
			$('#selector_incorporar').css('color','#000');
			$('#accion #informacion').css('z-index','1');
		break;
			//pais ganado
		case 4:
			$('#selector_reagrupar').css('background-color','#FFF');
			$('#selector_reagrupar').css('opacity','1');
			$('#selector_reagrupar').css('color','#000');
			if(turno_usuario == mi_id)
				$('#accion #reagrupar').css('z-index','1');
		break;
		
	}
		
};
		
		
$.fn.avanzarProceso = function(){
	//envio el id del boton al que se le hizo click de esta forma se cual es el paso a hacer por el script
	$.getJSON( 'ajax/__avanzar_proceso.php?accion='+$(this).attr('id'), function( respuesta ) {
	});	
};


$.fn.sacarTarjeta = function(){
	$.getJSON( 'ajax/__sacar_tarjeta.php', function( respuesta ) {
	});
};

$.fn.traeTarjetas = function(){
	//$.getJSON( 'ajax/__trae_tarjetas.php', function( respuesta ) {
		respuesta=arregloTraeTarjetas;
		//en [i][0] trae el nombre en 1 el numero del logo y en 2 el estado si se cambio o no		
		$('#informacion #tarjeta1 marquee').text(respuesta[0][0]);		
		$('#informacion #tarjeta1').css('background-image','url(fondos/'+respuesta[0][1]+')');
		if(respuesta[0][2] == 1)
			$('#informacion #tarjeta1 marquee').css('background-color','#82C0F4');
		else
			$('#informacion #tarjeta1 marquee').css('background-color','#FFF');
			
		$('#informacion #tarjeta2 marquee').text(respuesta[1][0]);		
		$('#informacion #tarjeta2').css('background-image','url(fondos/'+respuesta[1][1]+')');
		if(respuesta[1][2] == 1)
			$('#informacion #tarjeta2 marquee').css('background-color','#82C0F4');
		else
			$('#informacion #tarjeta2 marquee').css('background-color','#FFF');
			
		$('#informacion #tarjeta3 marquee').text(respuesta[2][0]);		
		$('#informacion #tarjeta3').css('background-image','url(fondos/'+respuesta[2][1]+')');
		if(respuesta[2][2] == 1)
			$('#informacion #tarjeta3 marquee').css('background-color','#82C0F4');
		else
			$('#informacion #tarjeta3 marquee').css('background-color','#FFF');
			
		$('#informacion #tarjeta4 marquee').text(respuesta[3][0]);		
		$('#informacion #tarjeta4').css('background-image','url(fondos/'+respuesta[3][1]+')');
		if(respuesta[3][2] == 1)
			$('#informacion #tarjeta4 marquee').css('background-color','#82C0F4');
		else
			$('#informacion #tarjeta4 marquee').css('background-color','#FFF');
			
		$('#informacion #tarjeta5 marquee').text(respuesta[4][0]);		
		$('#informacion #tarjeta5').css('background-image','url(fondos/'+respuesta[4][1]+')');
		if(respuesta[4][2] == 1)
			$('#informacion #tarjeta5 marquee').css('background-color','#82C0F4');
		else
			$('#informacion #tarjeta5 marquee').css('background-color','#FFF');
	//});
};

$.fn.seleccionarTartjeta = function(){
	if((estado_usuario_turno ==  3  || estado_usuario_turno ==  2)  && mi_id == turno_usuario){
		if($(this).attr('seleccionada') == 'no'){
			$(this).css('border-color','green');
			$(this).attr('seleccionada','si');
		}
		else{
			$(this).css('border-color','#000');
			$(this).attr('seleccionada','no');
		}
	}
};


$.fn.cambiarTarjetas = function(){
	var arreglo_enviar=[5];
	var i=0;
	$('#informacion .tarjeta').each(function(){
		if($(this).attr('seleccionada') == 'si')
			arreglo_enviar[i]=1;
		else
			arreglo_enviar[i]=0;
		i++;
	});

	$.getJSON( 'ajax/__cambiar.php?tarjeta1='+arreglo_enviar[0]+'&tarjeta2='+arreglo_enviar[1]+'&tarjeta3='+arreglo_enviar[2]+'&tarjeta4='+arreglo_enviar[3]+'&tarjeta5='+arreglo_enviar[4], function( respuesta ) {
		if(respuesta[0] == 0){
			$('#informacion').animate({'background-color': "#66CC99"}, 1000);
			$('#informacion').animate({'background-color': "#D2DACD"}, 1000);
			$().fichasParaIncorporar();
		}
		else{
			$('#informacion').animate({'background-color': "#FF3333"}, 1000);
			$('#informacion').animate({'background-color': "#D2DACD"}, 1000);
		}
	});
		//le saco la seleccion
	$('#informacion .tarjeta').css('border-color','black');
	$('#informacion .tarjeta').attr('seleccionada','no');
};


$.fn.cobrar = function(){
	i=0;
	var arreglo_enviar=[5];
		///en un arreglo pongo 1 en la poiscion donde hay una tarjeta seleccionada y un 0 en la posicion de una tarjeta que no esta seleccionada
	$('#informacion .tarjeta').each(function(){
		if($(this).attr('seleccionada') == 'si')
			arreglo_enviar[i]=1;
		else
			arreglo_enviar[i]=0;
		i++;
	});
		//envio todas las tarjetas, seleccionadas y no seleccionadads, en el servidor despues veo que sea una sola la seleccionada y que no se haya cobrado
	$.getJSON( 'ajax/__cobrar.php?tarjeta1='+arreglo_enviar[0]+'&tarjeta2='+arreglo_enviar[1]+'&tarjeta3='+arreglo_enviar[2]+'&tarjeta4='+arreglo_enviar[3]+'&tarjeta5='+arreglo_enviar[4], function( respuesta ) {
	if(respuesta[0] == 1){
		$('#informacion').animate({'background-color': "#66CC99"}, 1000);
		$('#informacion').animate({'background-color': "#D2DACD"}, 1000);
		$('').actualizarFichas();
	}
	else{
		$('#informacion').animate({'background-color': "#FF3333"}, 1000);
		$('#informacion').animate({'background-color': "#D2DACD"}, 1000);
	}
	});
	$('#informacion .tarjeta').css('border-color','black');
	$('#informacion .tarjeta').attr('seleccionada','no');
};
									
				//EN VALUE DEL HIDDEN ESTA EL ID DEL JUGADOR					
$.fn.infoUsuario = function(){
	//TRAE AL FRENTE O TIRA ATRAS EL DIV QUE MUESTRA LA INFORMACION
	if($('#info_usuarios').css('z-index') == 0){
		$.getJSON( 'ajax/__info_usuarios.php?id_usuario='+this.children('input').attr('value'), function( respuesta ) {
			$('#info_usuarios').css('z-index','10');	
			
			$('#info_usuarios').animate({opacity:1},100);
			
			$('#fondo_info_usuario').css('visibility','visible');		
			
			$('#info_usuarios').css('visibility','visible');		
				//CARGA CANTIDAD DE PAISES
			$('#info_usuarios #info_usuarios_cantidad_paises').text('Cantidad de paises: '+respuesta[1]);
				//CARGA	NUMERO DE RONDA
			$('#info_usuarios #info_usuarios_ronda').text('Ronda #: '+respuesta[2]);
				//CARGA NUMERO DE CAMBIOS
			$('#info_usuarios #info_usuarios_cantidad_cambios').text('Cambios realizados: '+respuesta[3]);
				//CARGO LAS TARJETAS
				

				//TRAE LA IMAGEN DEL OBJETIVO QUE LE CORRESPONDE, SI NO SE TERMINO LA PARTIDA Y PIDE EL DE OTRO USUARIO TRAE LA IMAGEN QUE DICE OBJETIVO SECRETO
			if(respuesta[4] == 'secreto'){
				$('#info_usuarios_contenedor_objetivo').css('background-image','url(fondos/secreto.png)');
			}
			else{
				if(respuesta[4] == 'objetivo_comun')
					$('#info_usuarios_contenedor_objetivo').css('background-image','url(fondos/'+respuesta[4]+'.png)');
				else
					$('#info_usuarios_contenedor_objetivo').css('background-image','url(fondos/objetivo'+respuesta[4]+'.png)');
			}				
			
			for(i=0;i<5;i++)
				if(respuesta[0][i][0] != null){
					$('#info_tarjeta'+i+' marquee').text(respuesta[0][i][0]);
					$('#info_tarjeta'+i).css('background-image','url(fondos/'+respuesta[0][i][1]+')');	
					if(respuesta[0][i][2] == 1)
						$('#info_tarjeta'+i+' marquee').css('background-color','#82C0F4');
					else
						$('#info_tarjeta'+i+' marquee').css('background-color','#FFF');
				}
		});
		var usuario = this.clone();
		
		usuario.css('position','absolute');
		usuario.css('left','480px');
		usuario.css('top','15px');
		usuario.appendTo($('#info_usuarios'));
		
			//PREGUNTA SI PIDE SU INFORMACION		
		if(this.children('input').attr('value') == mi_id){
				//SI PIDE SU INFORMACION ACTIVA EL BOTON GANE
			$('#info_usuarios_gane').removeAttr('disabled');
		}
		else{
				//SI PIDE LA INFORMACION DE OTRO, DESACTIVA EL BOTON GANE
			$('#info_usuarios_gane').attr('disabled','disabled');
		}
	}
	else{
		$('#info_usuarios').css('opacity','0.0');
		$('#info_usuarios').css('visibility','hidden');
		$('#info_usuarios').css('z-index','0');
			
			//SACA EL FONDO INFO USUARIO SOLO SI LA PARTIDA NO TERMINO
		if($('#juego_terminado').css('visibility') == 'hidden')	
			$('#fondo_info_usuario').css('visibility','hidden');
			
			//SACA EL USUARIO ANTERIOR
		$('#info_usuarios .usuario').remove();	
	}
};
			

$.fn.mostrarNombre = function(){
	$('#nombre_pais').text($(this).attr('nombre'));
};

$.fn.reagrupar = function (){
		//agarro el select y lo meto en this_select
	var this_select=$('#reagrupar select');
	
		//calculo cuantas fichas puede enviar
		//con este if logro que haga el pedido de fichas con las que puede pasar una sola vez
	if((this_select.children()).length==0){
		$.getJSON( 'ajax/__calcular_envio.php', function( respuesta ) {
				//alert("Pais ganado, envie tropas");
				//borro todos los option anteriores (esto es muy importante sino el select puede tener valores que no le correspondan)
			$('#reagrupar select').find('option').remove();
				for(i=0;i<respuesta[0];i++){
					var option =$(document.createElement('option'));
					option.attr('value',i+1);
					option.text(i+1);
					option.appendTo(this_select);
				}	
				//envio las fichas
				$('#reagrupar input').click(function(){
					$.getJSON( 'ajax/__enviar_fichas.php?cantidad='+this_select.attr('value'), function( respuesta ) {
							//quiere decir que se pudo enviar las fichas
						if(respuesta[0]==1){
							$('#reagrupar').css('z-index','0');
							$('#reagrupar select option').remove();
						}
					});
				});
		});
	}
};

$.fn.cargarChat = function (){
			//antes de insertar los mensajes compruebo si el scroll estaba al final o no
			//si estaba al final, despues de poner el mensaje lo llevo de nuevo al final
			//de lo contrario no lo muevo
		var target = document.getElementById('todos_los_mensajes');
		var isScrolledToBottom = target.scrollTop + target.offsetHeight >= target.scrollHeight;
//	$.getJSON( 'ajax/__recibir_mensaje.php?numero_ultimo='+numero_ultimo, function( respuesta ) {
			//comprueba que traiga un mensaje
			respuesta=arregloMensajes;
			if(respuesta != undefined)
		if(respuesta[0][0] != undefined){
		$('#ultimo_mensaje a').text(respuesta[respuesta.length-2][1]);
		$('#ultimo_mensaje div').css('background-image','url(http://graph.facebook.com/'+respuesta[respuesta.length-2][0]+'/picture)');
		$('#ultimo_mensaje').animate({'border-color': '#FFF'}, 1000);
		$('#ultimo_mensaje').animate({'border-color': '#000'}, 1000);
		tmp_numero_ultimo=numero_ultimo;
		numero_ultimo = respuesta[respuesta.length-1];
		if(numero_ultimo != tmp_numero_ultimo){
		
		for(i=0;i<respuesta.length-1;i++){
			if($('#todos_los_mensajes').children('div').last().attr('id_propietario') != respuesta[i][0]){
			var div =$(document.createElement('div'));
				div.css('width','210px');
				div.css('height','auto');
				div.css('min-height','50px');
				div.css('left','5px');
				div.css('border-top','1px solid #ccc');
				div.attr('id_propietario',respuesta[i][0]);
				div.css('position','relative');
				
				var foto =$(document.createElement('div'));
				foto.css('width','28px');
				foto.css('height','28px');
				foto.css('top','10px');
				foto.css('left','0px');
				foto.css('position','relative');
				foto.css('background-image','url(http://graph.facebook.com/'+respuesta[i][0]+'/picture)');
				foto.css('float','left');
				foto.attr('id_propietario',respuesta[i][0]);
				div.append(foto);
				
				var a =$(document.createElement('p'));
				a.css('margin-left','35px');
				a.css('margin-top','10px');
				a.css('font-size','13px');
				a.css('position','relative');
				a.css('display','block');
				a.text(respuesta[i][1]);
				div.append(a);
					
				
			
			}
			else{
				var a =$(document.createElement('a'));
				a.css('font-size','13px');
				a.css('position','relative');
				a.css('display','block');
				a.text(respuesta[i][1]);
				$('#todos_los_mensajes').children('div').children('p').last().append(a);
			}
				
			$('#todos_los_mensajes').append(div);	
		}
		
	if(isScrolledToBottom)
		$('#todos_los_mensajes').scrollTop(target.scrollHeight);

		
	}
	
	}
	
//	});

};
$.fn.enviarMensaje = function (){
var target = document.getElementById('todos_los_mensajes');
	$.post("ajax/__enviar_mensaje.php", { mensaje: $('#chat textarea').val() },
		function(data){
	});
	$('#chat textarea').val('');
	$('#chat textarea').css('height','20px');
	
  			$('#chat #todos_los_mensajes').css('margin-bottom','0px');
  			$('#chat #todos_los_mensajes').css('height','315px');
  			$('#todos_los_mensajes').scrollTop(target.scrollHeight);
};

$.fn.fichasParaIncorporar = function (){

	//$.getJSON( 'ajax/__cantidad_a_incorporar.php', function( respuesta ) {
		respuesta=arregloCantidadIncorporar;
			//guardo en esta variable global el arreglo entero
			//despues la uso para poner fichas, sin tener que esperar la respuesta del servidor
		arreglo_cantidad_incorporar=respuesta;
			//CARGO LIBRES, CAMBIO, CONTINENTES, TOTALES
		i=0;
	
		$('#desarrollo_incorporar_izquierda a').each(function(){
				//en libres ya esta sumado el cambio entonces si hay cambio se lo voy restando
			if(arreglo_cantidad_incorporar[1] != 0 && i==0){
				var nombre = $(this).text().split(':');
				$(this).text(nombre[0]+': '+(arreglo_cantidad_incorporar[0]-arreglo_cantidad_incorporar[1]));
				i++;
			}
			else{
				var nombre = $(this).text().split(':');
				$(this).text(nombre[0]+': '+arreglo_cantidad_incorporar[i]);
				i++;
			}
		});
		
			//CARGO LA DE LOS CONTINENTES EN PARTICULAR
		i=4;
		$('#desarrollo_incorporar_derecha a').each(function(){
			var nombre = $(this).text().split(':');
			$(this).text(nombre[0]+': '+arreglo_cantidad_incorporar[i]);
			i++;
		});
	//});
};

$.fn.simularIncorporacion = function(ficha){

		//compruebo que este en fase incorporar, que el usuario en turno sea el que lo llama y que la ficha sobre la que se hizo click
		//sea de el propietario
	if(estado_usuario_turno==3 && mi_id==turno_usuario && (ficha.attr('name') == mi_id) && arreglo_cantidad_incorporar[3]!=0){
				
		tmp_total= arreglo_cantidad_incorporar[3];
		
		var id_ficha = ficha.attr('id').split('a');
		

		
		
			//esta entre 0 y 9 o sea que pertenece a america del norte
		if(id_ficha[1] <= 9)
				//si tiene que poner por contiente le resta al continente
			if(arreglo_cantidad_incorporar[4]!=0){
				ficha.attr('value',(Number(ficha.attr('value'))+1));
				arreglo_cantidad_incorporar[3]--;
				arreglo_cantidad_incorporar[2]--;
				arreglo_cantidad_incorporar[4]--;
			}
			//esta entre 0 y 9 o sea que pertenece a america del sur
		if(id_ficha[1] >= 10 && id_ficha[1] <= 15 )
				//si tiene que poner por contiente le resta al continente
			if(arreglo_cantidad_incorporar[5]!=0){
				ficha.attr('value',(Number(ficha.attr('value'))+1));
				arreglo_cantidad_incorporar[3]--;
				arreglo_cantidad_incorporar[2]--;
				arreglo_cantidad_incorporar[5]--;
			}
			//esta entre 0 y 9 o sea que pertenece a africa
		if(id_ficha[1] >= 16 && id_ficha[1] <= 21 )
				//si tiene que poner por contiente le resta al continente
			if(arreglo_cantidad_incorporar[6]!=0){
				ficha.attr('value',(Number(ficha.attr('value'))+1));
				arreglo_cantidad_incorporar[3]--;
				arreglo_cantidad_incorporar[2]--;
				arreglo_cantidad_incorporar[6]--;
		}
			//esta entre 0 y 9 o sea que pertenece a europa
		if(id_ficha[1] >= 22 && id_ficha[1] <= 30 )
				//si tiene que poner por contiente le resta al continente
			if(arreglo_cantidad_incorporar[7]!=0){
				ficha.attr('value',(Number(ficha.attr('value'))+1));
				arreglo_cantidad_incorporar[3]--;
				arreglo_cantidad_incorporar[2]--;
				arreglo_cantidad_incorporar[7]--;
		}
			//esta entre 0 y 9 o sea que pertenece a asia
		if(id_ficha[1] >= 31 && id_ficha[1] <= 45 )
				//si tiene que poner por contiente le resta al continente
			if(arreglo_cantidad_incorporar[8]!=0){
				ficha.attr('value',(Number(ficha.attr('value'))+1));
				arreglo_cantidad_incorporar[3]--;
				arreglo_cantidad_incorporar[2]--;
				arreglo_cantidad_incorporar[8]--;
		}
			//esta entre 0 y 9 o sea que pertenece a oceania
		if(id_ficha[1] >= 46 && id_ficha[1] <= 49 )
				//si tiene que poner por contiente le resta al continente
			if(arreglo_cantidad_incorporar[9]!=0){
				ficha.attr('value',(Number(ficha.attr('value'))+1));
				arreglo_cantidad_incorporar[3]--;
				arreglo_cantidad_incorporar[2]--;
				arreglo_cantidad_incorporar[9]--;
		}
		
		
		
		
			////////////si no la quito de las de ningun continente
		if(tmp_total == arreglo_cantidad_incorporar[3] && (arreglo_cantidad_incorporar[0] != 0 || arreglo_cantidad_incorporar[1] != 0 )){
			if(mi_id == turno_usuario)
				if(arreglo_cantidad_incorporar[1] != 0){
					arreglo_cantidad_incorporar[1]--;
					arreglo_cantidad_incorporar[0]--;
					arreglo_cantidad_incorporar[3]--;
					ficha.attr('value',(Number(ficha.attr('value'))+1));
				}
				else{
					ficha.attr('value',(Number(ficha.attr('value'))+1));
					arreglo_cantidad_incorporar[3]--;
					arreglo_cantidad_incorporar[0]--;
				}
				
		}
		
		///Recargo el div de abajo a la izquierda que dice cuantas puede poner
		i=0;
	
		$('#desarrollo_incorporar_izquierda a').each(function(){
				//en libres ya esta sumado el cambio entonces si hay cambio se lo voy restando
			if(arreglo_cantidad_incorporar[1] != 0 && i==0){
				var nombre = $(this).text().split(':');
				$(this).text(nombre[0]+': '+(arreglo_cantidad_incorporar[0]-arreglo_cantidad_incorporar[1]));
				i++;
			}
			else{
				var nombre = $(this).text().split(':');
				$(this).text(nombre[0]+': '+arreglo_cantidad_incorporar[i]);
				i++;
			}
		});
		
			//CARGO LA DE LOS CONTINENTES EN PARTICULAR
		i=4;
		$('#desarrollo_incorporar_derecha a').each(function(){
			var nombre = $(this).text().split(':');
			$(this).text(nombre[0]+': '+arreglo_cantidad_incorporar[i]);
			i++;
		});
		ficha.animate({'border-color': "#FFF"}, 200);
		ficha.animate({'border-color': "#000"}, 300);	

		if(arreglo_cantidad_incorporar[3] == 0)
			setTimeout('$().touch()',300);
	}
	
	

	
};


$.fn.colorFondo = function(elemento){
	if(elemento.attr('value') == 'Original'){
		$("#slider_rojo").slider( "value",'130' );
		$("#slider_verde").slider( "value", "203" );
		$("#slider_azul").slider( "value", "231" );
	}
		
	valor_rojo = $("#slider_rojo").slider( "option", "value" );
	valor_verde = $("#slider_verde").slider( "option", "value" );
	valor_azul = $("#slider_azul").slider( "option", "value" );
	$('#cuerpo').css('background-color','rgb('+valor_rojo+','+valor_verde+','+valor_azul+')');
	$('#mapa_nombres').css('background-color','rgb('+valor_rojo+','+valor_verde+','+valor_azul+')');
	$('#fondo_info_usuario').css('background-color','rgb('+valor_rojo+','+valor_verde+','+valor_azul+')');
};

$.fn.seRecargoPagina =function(){

	///////////////////TODO ESTO QUE SIGUE ES POR SI EL USUARIO ACTUALIZA LA PAGINA, PARA QUE LA DIBUJE BIEN NUEVAMENTE
		//lo hace si existe esta variable esto es porque daba error diciendo que no existe la variable
	if(arregloSecuenciador != null){
	
					///TRAE LOS TURNOS DE LOS JUGADORES, Y LA ACCION QUE ESTA DESARROLLANDO
		//	$.getJSON( 'ajax/__secuenciador.php', function( respuesta ) {
				respuesta=arregloSecuenciador;
				//respuesta en [0] trae id del jugador en turno en [1] estado del jugador en turno(ataque, reagrupar....) [2] el id del que llamo a __secuenciador.php
				mi_id=respuesta[2];
				turno_usuario=respuesta[0];
				estado_usuario_turno=respuesta[1];
				id_defensa=respuesta[3];
					//lista jugadores
				//$.getJSON( 'ajax/__lista_jugadores.php', function( respuesta ) {
					for(i=0;i<=arregloUsuarios.length;i++)
						if(respuesta[i]!=0)
							$('#jugador'+i).traeUsuario(respuesta[i]);	
						//le pone el selector al jugador en turno
					$('.hidden').ubicarSelector(turno_usuario);
				//}); 
				
			
					 ///HAGO QUE ACTUALIZE LAS FICHAS, ES POR SI REFREZCA LA PAGINA, SE EJECUTA UNA SOLA VEZ
	 $('').actualizarFichas();
	 
		 //trae las tarjetas del jugador
	 if(mi_id == turno_usuario && (estado_usuario_turno ==  2 || estado_usuario_turno ==  3 ) )
		$().traeTarjetas();
	
			$().fichasParaIncorporar();
						
	
		$("#slider_rojo").slider( "value",'130' );
		$("#slider_verde").slider( "value", "203" );
		$("#slider_azul").slider( "value", "231" );
	
	//});
	}
};

$.fn.juegoTerminado = function (){
	$('#fondo_info_usuario').css('visibility','visible');
	$('#juego_terminado').css('visibility','visible');
};
		//ESTA FUNCION LA LLAMO EN SIMULAR INCORPORACION, ES PARA HACER UN SLEEP ENTRE INCORPORACION DE FICHA E INCORPORACION DE FICHA
		//HACE QUE SE PUEDA HACER CLICK DE NUEVO EN EL AREA O EN LA FICHA TRANSCURRIDO UN TIEMPO DADO DESDE EL ULTIMO CLICK
function sleepIncorporarFicha(id){
		$('#ficha'+id).removeAttr('disabled');
	
		$('#area-'+id).bind('click',function() {
			var id = $(this).attr('id').split('-');
			$('#ficha'+id[1]).clickFicha(1);
			$('#incorporar_varias').css('visibility','hidden');	
		});
}

$.fn.touch = function(){
	$.getJSON( 'ajax/__touch.php', function( respuesta ) {
		
	})
}

