$.fn.traeUsuario=function(a){var b=0,d=$(this).children(),c=$(this),e=Array(5);for(j=0;j<arregloUsuarios.length;j++)if(0!=a&&arregloUsuarios[j].id==a){e.nombre=arregloUsuarios[j].nombre;e.url_img=arregloUsuarios[j].url_img;e.color=arregloUsuarios[j].color;e.estado=arregloUsuarios[j].estado;j=arregloUsuarios.length;var f=nombreColor(e.color);c.css("border-color",f);b=0;d.each(function(){0==b&&$(this).text(e.nombre);1==b&&($(this).css("background-image","url("+e.url_img+")"),$(this).css("border","1px solid #000")); 2==b&&$(this).attr("value",a);b++});"eliminado"==e.estado?c.css("opacity","0.3"):c.css("opacity",".9");a==turno_usuario&&3==estado_usuario_turno&&$(".hidden").ubicarSelector(c.eq(2).attr("value"))}else 0==a&&(c.css("border-color","black"),d.each(function(){0==b&&$(this).text(" ");1==b&&$(this).css("background-image","none");2==b&&$(this).attr("value","");b++}))}; $.fn.traeUsuariobis=function(a){var b=0,d=$(this).children(),c=$(this);0!=a?$.getJSON("ajax/__trae_usuario.php?id="+a,function(e){var f=nombreColor(e.color);c.css("border-color",f);b=0;d.each(function(){0==b&&$(this).text(e.nombre);1==b&&($(this).css("background-image","url("+e.url_img+")"),$(this).css("border","1px solid #000"));2==b&&$(this).attr("value",a);b++});"eliminado"==e.estado?c.css("opacity","0.3"):c.css("opacity",".9");a==turno_usuario&&3==estado_usuario_turno&&$(".hidden").ubicarSelector(c.eq(2).attr("value"))}): (c.css("border-color","black"),d.each(function(){0==b&&$(this).text(" ");1==b&&$(this).css("background-image","none");2==b&&$(this).attr("value","");b++}))};$.fn.traePais=function(a,b){var d=$(this).children();pais="Alema\u2013ia";1==b?d.text("De: "+pais):d.text("A: "+pais)}; $.fn.actualizarFichas=function(){respuesta=arregloFichas;var a=0;for(i=0;50>i;i++){var b=nombreColor(respuesta[0][i]);$("#ficha"+i).css({"background-color":b});switch(b){case "black":$("#ficha"+i).css("color","#fff");break;case "green":$("#ficha"+i).css("color","#fff");break;case "red":$("#ficha"+i).css("color","#fff");break;case "blue":$("#ficha"+i).css("color","#fff");break;case "magenta":$("#ficha"+i).css("color","#000");break;case "yellow":$("#ficha"+i).css("color","#000")}$("#ficha"+i).attr("nombre", respuesta[4][i]);if($("#ficha"+i).attr("value")!=respuesta[1][i]&&(3!=estado_usuario_turno&&mi_id==turno_usuario||mi_id!=turno_usuario))color_viejo=$("#ficha"+i).css("background-color"),$("#ficha"+i).animate({"background-color":"#fff"},500),$("#ficha"+i).animate({"background-color":color_viejo},500);$("#ficha"+i).attr("value",respuesta[1][i]);$("#ficha"+i).attr("name",respuesta[2][i]);1==respuesta[3][i]?($("#ficha"+i).css("border","2px solid #FFF"),$("#ficha"+i).css("box-shadow","0px 0px 10px 5px #000"), $("#pais_de").children().text("De: "+$("#ficha"+i).attr("nombre")),$("#usuario_de").traeUsuario(turno_usuario),a=1):2==respuesta[3][i]?($("#ficha"+i).css("border","2px solid #FFF"),1!=estado_usuario_turno?$("#ficha"+i).css("box-shadow","0px 0px 10px 5px red"):$("#ficha"+i).css("box-shadow","0px 0px 5px 1px #000"),$("#pais_a").children().text("A: "+$("#ficha"+i).attr("nombre")),$("#usuario_a").traeUsuario($("#ficha"+i).attr("name")),a=1):(a++,$("#ficha"+i).css("border","1px solid #000"),$("#ficha"+ i).css("box-shadow","none"))}50==a&&($("#pais_de").children().text(" "),$("#usuario_de").traeUsuario(0),$("#pais_a").children().text(" "),$("#usuario_a").traeUsuario(0))};function nombreColor(a){var b;switch(a){case "1":b="black";break;case "2":b="red";break;case "3":b="yellow";break;case "4":b="magenta";break;case "5":b="green";break;case "6":b="blue"}return b} $.fn.ubicarSelector=function(a){$(this).each(function(){if($(this).attr("value")==a)switch($(this).attr("name")){case "hidden1":$("#selector_jugador").animate({top:"90px"},1E3);break;case "hidden2":$("#selector_jugador").animate({top:"160px"},1E3);break;case "hidden3":$("#selector_jugador").animate({top:"230px"},1E3);break;case "hidden4":$("#selector_jugador").animate({top:"300px"},1E3);break;case "hidden5":$("#selector_jugador").animate({top:"370px"},1E3);break;case "hidden6":$("#selector_jugador").animate({top:"440px"}, 1E3)}})}; $.fn.clickFicha=function(a){var b=0,d=$(this),c=$(this).attr("id").split("a");if(mi_id==turno_usuario)if(3!=estado_usuario_turno)$.getJSON("ajax/__seleccionar.php?id_pais="+c[1],function(a){1==a[0]&&(d.css("border","3px solid #FFF"),$("#pais_de").children().text("De: "+d.attr("nombre")),$("#usuario_de").traeUsuario(turno_usuario),$("#reagrupar select").find("option").remove())});else{d.attr("disabled","disabled");$("#area-"+c[1]).unbind("click");for(j=0;j<a;j++)0==arreglo_cantidad_incorporar[3]?($("").actualizarFichas(), $().fichasParaIncorporar()):$().simularIncorporacion(d),$("#accion #informacion").css("z-index","1"),$.getJSON("ajax/__cargar.php?id_pais="+c[1],function(c){if(c[0]==5){$("#informacion").animate({"background-color":"#FF3333"},1E3);$("#informacion").animate({"background-color":"#D2DACD"},1E3)}b+1==a&&a>1&&setTimeout("$().touch()",300);b++});0==arreglo_cantidad_incorporar[3]?setTimeout('sleepIncorporarFicha("'+c[1]+'")',3E3):setTimeout('sleepIncorporarFicha("'+c[1]+'")',500)}}; $.fn.mostrarEstadoTurno=function(){$("#selector_ataque").css("background","none");$("#selector_ataque").css("opacity",".6");$("#selector_ataque").css("color","#000");$("#selector_reagrupar").css("background","none");$("#selector_reagrupar").css("opacity",".6");$("#selector_reagrupar").css("color","#000");$("#selector_tarjeta").css("background","none");$("#selector_tarjeta").css("opacity",".6");$("#selector_tarjeta").css("color","#000");$("#selector_incorporar").css("background","none");$("#selector_incorporar").css("opacity", ".6");$("#selector_incorporar").css("color","#000");$("#accion #reagrupar").css("z-index","0");$("#accion #informacion").css("z-index","0");$("#accion #ataque").css("z-index","0");switch(estado_usuario_turno){case 0:$("#selector_ataque").css("background-color","#FFF");$("#selector_ataque").css("opacity","1");$("#selector_ataque").css("color","#000");$("#accion #ataque").css("z-index","1");break;case 1:$("#selector_reagrupar").css("background-color","#FFF");$("#selector_reagrupar").css("opacity","1"); $("#selector_reagrupar").css("color","#000");$("#reagrupar").css("z-index","1");break;case 2:turno_usuario==mi_id&&($("#selector_tarjeta").css("background-color","#FFF"),$("#selector_tarjeta").css("opacity","1"),$("#selector_tarjeta").css("color","#000"),$("#accion #informacion").css("z-index","1"));break;case 3:$("#selector_incorporar").css("background-color","#FFF");$("#selector_incorporar").css("opacity","1");$("#selector_incorporar").css("color","#000");$("#accion #informacion").css("z-index", "1");break;case 4:$("#selector_reagrupar").css("background-color","#FFF"),$("#selector_reagrupar").css("opacity","1"),$("#selector_reagrupar").css("color","#000"),turno_usuario==mi_id&&$("#accion #reagrupar").css("z-index","1")}};$.fn.avanzarProceso=function(){$.getJSON("ajax/__avanzar_proceso.php?accion="+$(this).attr("id"),function(){})};$.fn.sacarTarjeta=function(){$.getJSON("ajax/__sacar_tarjeta.php",function(){})}; $.fn.traeTarjetas=function(){respuesta=arregloTraeTarjetas;$("#informacion #tarjeta1 marquee").text(respuesta[0][0]);$("#informacion #tarjeta1").css("background-image","url(fondos/"+respuesta[0][1]+")");1==respuesta[0][2]?$("#informacion #tarjeta1 marquee").css("background-color","#82C0F4"):$("#informacion #tarjeta1 marquee").css("background-color","#FFF");$("#informacion #tarjeta2 marquee").text(respuesta[1][0]);$("#informacion #tarjeta2").css("background-image","url(fondos/"+respuesta[1][1]+")"); 1==respuesta[1][2]?$("#informacion #tarjeta2 marquee").css("background-color","#82C0F4"):$("#informacion #tarjeta2 marquee").css("background-color","#FFF");$("#informacion #tarjeta3 marquee").text(respuesta[2][0]);$("#informacion #tarjeta3").css("background-image","url(fondos/"+respuesta[2][1]+")");1==respuesta[2][2]?$("#informacion #tarjeta3 marquee").css("background-color","#82C0F4"):$("#informacion #tarjeta3 marquee").css("background-color","#FFF");$("#informacion #tarjeta4 marquee").text(respuesta[3][0]); $("#informacion #tarjeta4").css("background-image","url(fondos/"+respuesta[3][1]+")");1==respuesta[3][2]?$("#informacion #tarjeta4 marquee").css("background-color","#82C0F4"):$("#informacion #tarjeta4 marquee").css("background-color","#FFF");$("#informacion #tarjeta5 marquee").text(respuesta[4][0]);$("#informacion #tarjeta5").css("background-image","url(fondos/"+respuesta[4][1]+")");1==respuesta[4][2]?$("#informacion #tarjeta5 marquee").css("background-color","#82C0F4"):$("#informacion #tarjeta5 marquee").css("background-color", "#FFF")};$.fn.seleccionarTartjeta=function(){if((3==estado_usuario_turno||2==estado_usuario_turno)&&mi_id==turno_usuario)"no"==$(this).attr("seleccionada")?($(this).css("border-color","green"),$(this).attr("seleccionada","si")):($(this).css("border-color","#000"),$(this).attr("seleccionada","no"))}; $.fn.cambiarTarjetas=function(){var a=[5],b=0;$("#informacion .tarjeta").each(function(){a[b]="si"==$(this).attr("seleccionada")?1:0;b++});$.getJSON("ajax/__cambiar.php?tarjeta1="+a[0]+"&tarjeta2="+a[1]+"&tarjeta3="+a[2]+"&tarjeta4="+a[3]+"&tarjeta5="+a[4],function(a){0==a[0]?($("#informacion").animate({"background-color":"#66CC99"},1E3),$("#informacion").animate({"background-color":"#D2DACD"},1E3),$().fichasParaIncorporar()):($("#informacion").animate({"background-color":"#FF3333"},1E3),$("#informacion").animate({"background-color":"#D2DACD"}, 1E3))});$("#informacion .tarjeta").css("border-color","black");$("#informacion .tarjeta").attr("seleccionada","no")}; $.fn.cobrar=function(){i=0;var a=[5];$("#informacion .tarjeta").each(function(){a[i]="si"==$(this).attr("seleccionada")?1:0;i++});$.getJSON("ajax/__cobrar.php?tarjeta1="+a[0]+"&tarjeta2="+a[1]+"&tarjeta3="+a[2]+"&tarjeta4="+a[3]+"&tarjeta5="+a[4],function(a){1==a[0]?($("#informacion").animate({"background-color":"#66CC99"},1E3),$("#informacion").animate({"background-color":"#D2DACD"},1E3),$("").actualizarFichas()):($("#informacion").animate({"background-color":"#FF3333"},1E3),$("#informacion").animate({"background-color":"#D2DACD"}, 1E3))});$("#informacion .tarjeta").css("border-color","black");$("#informacion .tarjeta").attr("seleccionada","no")}; $.fn.infoUsuario=function(){if(0==$("#info_usuarios").css("z-index")){$.getJSON("ajax/__info_usuarios.php?id_usuario="+this.children("input").attr("value"),function(a){$("#info_usuarios").css("z-index","10");$("#info_usuarios").animate({opacity:1},100);$("#fondo_info_usuario").css("visibility","visible");$("#info_usuarios").css("visibility","visible");$("#info_usuarios #info_usuarios_cantidad_paises").text("Cantidad de paises: "+a[1]);$("#info_usuarios #info_usuarios_ronda").text("Ronda #: "+a[2]); $("#info_usuarios #info_usuarios_cantidad_cambios").text("Cambios realizados: "+a[3]);"secreto"==a[4]?$("#info_usuarios_contenedor_objetivo").css("background-image","url(fondos/secreto.png)"):"objetivo_comun"==a[4]?$("#info_usuarios_contenedor_objetivo").css("background-image","url(fondos/"+a[4]+".png)"):$("#info_usuarios_contenedor_objetivo").css("background-image","url(fondos/objetivo"+a[4]+".png)");for(i=0;5>i;i++)null!=a[0][i][0]&&($("#info_tarjeta"+i+" marquee").text(a[0][i][0]),$("#info_tarjeta"+ i).css("background-image","url(fondos/"+a[0][i][1]+")"),1==a[0][i][2]?$("#info_tarjeta"+i+" marquee").css("background-color","#82C0F4"):$("#info_tarjeta"+i+" marquee").css("background-color","#FFF"))});var a=this.clone();a.css("position","absolute");a.css("left","480px");a.css("top","15px");a.appendTo($("#info_usuarios"));this.children("input").attr("value")==mi_id?$("#info_usuarios_gane").removeAttr("disabled"):$("#info_usuarios_gane").attr("disabled","disabled")}else $("#info_usuarios").css("opacity", "0.0"),$("#info_usuarios").css("visibility","hidden"),$("#info_usuarios").css("z-index","0"),"hidden"==$("#juego_terminado").css("visibility")&&$("#fondo_info_usuario").css("visibility","hidden"),$("#info_usuarios .usuario").remove()};$.fn.mostrarNombre=function(){$("#nombre_pais").text($(this).attr("nombre"))}; $.fn.reagrupar=function(){var a=$("#reagrupar select");0==a.children().length&&$.getJSON("ajax/__calcular_envio.php",function(b){$("#reagrupar select").find("option").remove();for(i=0;i<b[0];i++){var d=$(document.createElement("option"));d.attr("value",i+1);d.text(i+1);d.appendTo(a)}$("#reagrupar input").click(function(){$.getJSON("ajax/__enviar_fichas.php?cantidad="+a.attr("value"),function(a){1==a[0]&&($("#reagrupar").css("z-index","0"),$("#reagrupar select option").remove())})})})}; $.fn.cargarChat=function(){var a=document.getElementById("todos_los_mensajes"),b=a.scrollTop+a.offsetHeight>=a.scrollHeight;respuesta=arregloMensajes;if(void 0!=respuesta&&void 0!=respuesta[0][0]&&($("#ultimo_mensaje a").text(respuesta[respuesta.length-2][1]),$("#ultimo_mensaje div").css("background-image","url(http://graph.facebook.com/"+respuesta[respuesta.length-2][0]+"/picture)"),$("#ultimo_mensaje").animate({"border-color":"#FFF"},1E3),$("#ultimo_mensaje").animate({"border-color":"#000"},1E3), tmp_numero_ultimo=numero_ultimo,numero_ultimo=respuesta[respuesta.length-1],numero_ultimo!=tmp_numero_ultimo)){for(i=0;i<respuesta.length-1;i++){if($("#todos_los_mensajes").children("div").last().attr("id_propietario")!=respuesta[i][0]){var d=$(document.createElement("div"));d.css("width","210px");d.css("height","auto");d.css("min-height","50px");d.css("left","5px");d.css("border-top","1px solid #ccc");d.attr("id_propietario",respuesta[i][0]);d.css("position","relative");var c=$(document.createElement("div")); c.css("width","28px");c.css("height","28px");c.css("top","10px");c.css("left","0px");c.css("position","relative");c.css("background-image","url(http://graph.facebook.com/"+respuesta[i][0]+"/picture)");c.css("float","left");c.attr("id_propietario",respuesta[i][0]);d.append(c);c=$(document.createElement("p"));c.css("margin-left","35px");c.css("margin-top","10px");c.css("font-size","13px");c.css("position","relative");c.css("display","block");c.text(respuesta[i][1]);d.append(c)}else c=$(document.createElement("a")), c.css("font-size","13px"),c.css("position","relative"),c.css("display","block"),c.text(respuesta[i][1]),$("#todos_los_mensajes").children("div").children("p").last().append(c);$("#todos_los_mensajes").append(d)}b&&$("#todos_los_mensajes").scrollTop(a.scrollHeight)}}; $.fn.enviarMensaje=function(){var a=document.getElementById("todos_los_mensajes");$.post("ajax/__enviar_mensaje.php",{mensaje:$("#chat textarea").val()},function(){});$("#chat textarea").val("");$("#chat textarea").css("height","20px");$("#chat #todos_los_mensajes").css("margin-bottom","0px");$("#chat #todos_los_mensajes").css("height","315px");$("#todos_los_mensajes").scrollTop(a.scrollHeight)}; $.fn.fichasParaIncorporar=function(){arreglo_cantidad_incorporar=respuesta=arregloCantidadIncorporar;i=0;$("#desarrollo_incorporar_izquierda a").each(function(){if(0!=arreglo_cantidad_incorporar[1]&&0==i){var a=$(this).text().split(":");$(this).text(a[0]+": "+(arreglo_cantidad_incorporar[0]-arreglo_cantidad_incorporar[1]))}else a=$(this).text().split(":"),$(this).text(a[0]+": "+arreglo_cantidad_incorporar[i]);i++});i=4;$("#desarrollo_incorporar_derecha a").each(function(){var a=$(this).text().split(":"); $(this).text(a[0]+": "+arreglo_cantidad_incorporar[i]);i++})}; $.fn.simularIncorporacion=function(a){if(3==estado_usuario_turno&&mi_id==turno_usuario&&a.attr("name")==mi_id&&0!=arreglo_cantidad_incorporar[3]){tmp_total=arreglo_cantidad_incorporar[3];var b=a.attr("id").split("a");9>=b[1]&&0!=arreglo_cantidad_incorporar[4]&&(a.attr("value",Number(a.attr("value"))+1),arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[2]--,arreglo_cantidad_incorporar[4]--);10<=b[1]&&15>=b[1]&&0!=arreglo_cantidad_incorporar[5]&&(a.attr("value",Number(a.attr("value"))+1), arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[2]--,arreglo_cantidad_incorporar[5]--);16<=b[1]&&21>=b[1]&&0!=arreglo_cantidad_incorporar[6]&&(a.attr("value",Number(a.attr("value"))+1),arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[2]--,arreglo_cantidad_incorporar[6]--);22<=b[1]&&30>=b[1]&&0!=arreglo_cantidad_incorporar[7]&&(a.attr("value",Number(a.attr("value"))+1),arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[2]--,arreglo_cantidad_incorporar[7]--);31<=b[1]&& 45>=b[1]&&0!=arreglo_cantidad_incorporar[8]&&(a.attr("value",Number(a.attr("value"))+1),arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[2]--,arreglo_cantidad_incorporar[8]--);46<=b[1]&&49>=b[1]&&0!=arreglo_cantidad_incorporar[9]&&(a.attr("value",Number(a.attr("value"))+1),arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[2]--,arreglo_cantidad_incorporar[9]--);if(tmp_total==arreglo_cantidad_incorporar[3]&&(0!=arreglo_cantidad_incorporar[0]||0!=arreglo_cantidad_incorporar[1])&& mi_id==turno_usuario)0!=arreglo_cantidad_incorporar[1]?(arreglo_cantidad_incorporar[1]--,arreglo_cantidad_incorporar[0]--,arreglo_cantidad_incorporar[3]--,a.attr("value",Number(a.attr("value"))+1)):(a.attr("value",Number(a.attr("value"))+1),arreglo_cantidad_incorporar[3]--,arreglo_cantidad_incorporar[0]--);i=0;$("#desarrollo_incorporar_izquierda a").each(function(){if(arreglo_cantidad_incorporar[1]!=0&&i==0){var a=$(this).text().split(":");$(this).text(a[0]+": "+(arreglo_cantidad_incorporar[0]-arreglo_cantidad_incorporar[1]))}else{a= $(this).text().split(":");$(this).text(a[0]+": "+arreglo_cantidad_incorporar[i])}i++});i=4;$("#desarrollo_incorporar_derecha a").each(function(){var a=$(this).text().split(":");$(this).text(a[0]+": "+arreglo_cantidad_incorporar[i]);i++});a.animate({"border-color":"#FFF"},200);a.animate({"border-color":"#000"},300);0==arreglo_cantidad_incorporar[3]&&setTimeout("$().touch()",300)}}; $.fn.colorFondo=function(a){"Original"==a.attr("value")&&($("#slider_rojo").slider("value","130"),$("#slider_verde").slider("value","203"),$("#slider_azul").slider("value","231"));valor_rojo=$("#slider_rojo").slider("option","value");valor_verde=$("#slider_verde").slider("option","value");valor_azul=$("#slider_azul").slider("option","value");$("#cuerpo").css("background-color","rgb("+valor_rojo+","+valor_verde+","+valor_azul+")");$("#mapa_nombres").css("background-color","rgb("+valor_rojo+","+valor_verde+ ","+valor_azul+")");$("#fondo_info_usuario").css("background-color","rgb("+valor_rojo+","+valor_verde+","+valor_azul+")")}; $.fn.seRecargoPagina=function(){if(null!=arregloSecuenciador){respuesta=arregloSecuenciador;mi_id=respuesta[2];turno_usuario=respuesta[0];estado_usuario_turno=respuesta[1];id_defensa=respuesta[3];for(i=0;i<=arregloUsuarios.length;i++)0!=respuesta[i]&&$("#jugador"+i).traeUsuario(respuesta[i]);$(".hidden").ubicarSelector(turno_usuario);$("").actualizarFichas();mi_id==turno_usuario&&(2==estado_usuario_turno||3==estado_usuario_turno)&&$().traeTarjetas();$().fichasParaIncorporar();$("#slider_rojo").slider("value", "130");$("#slider_verde").slider("value","203");$("#slider_azul").slider("value","231")}};$.fn.juegoTerminado=function(){$("#fondo_info_usuario").css("visibility","visible");$("#juego_terminado").css("visibility","visible")};function sleepIncorporarFicha(a){$("#ficha"+a).removeAttr("disabled");$("#area-"+a).bind("click",function(){var a=$(this).attr("id").split("-");$("#ficha"+a[1]).clickFicha(1);$("#incorporar_varias").css("visibility","hidden")})} $.fn.touch=function(){$.getJSON("ajax/__touch.php",function(){})};