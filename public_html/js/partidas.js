var tiempo=30,jugadores,usuarios_reserva,numero_de_entradas_timer=ultimo_tamanio=ultima_consulta=0; $(document).ready(function(){$.fn.esperandoJugadores=function(){$.getJSON("ajax/__comprobar_tiempo.php?ultima_consulta="+ultima_consulta+"&ultimo_tamanio="+ultimo_tamanio,function(a){ultima_consulta=a.ultima_consulta;ultimo_tamanio=a.ultimo_tamanio;$.getJSON("ajax/__lista_jugadores.php",function(b){$.each($(".jugador"),function(a,c){$(c).attr("id",b[a]);b[a]!=null&&$.getJSON("ajax/__trae_usuario.php?id="+b[a], function(a){$(c).children(0).text(a.nombre);$(c).children(1).attr("src",a.url_img);$(c).css("border","3px solid #000");$(c).css("border-color",nombreColor(a.color));$("option").each(function(){$(this).attr("value")==a.color&&$(this).remove()})})});$("#ingresar select").attr("disabled",false)});$.getJSON("ajax/__comprobar_reservas.php",function(a){usuarios_reserva=a;$(".jugador").each(function(){if($(this).attr("id")==null&&$(this).children("a").text()!="Libre"){if($(this).attr("referencia_color")== 0){options=new Option("Negro",0);$("#ingresar select").append(options)}if($(this).attr("referencia_color")==3){options=new Option("Amarillo",3);$("#ingresar select").append(options)}if($(this).attr("referencia_color")==2){options=new Option("Rojo",2);$("#ingresar select").append(options)}if($(this).attr("referencia_color")==4){options=new Option("Magenta",4);$("#ingresar select").append(options)}if($(this).attr("referencia_color")==5){options=new Option("Verde",5);$("#ingresar select").append(options)}if($(this).attr("referencia_color")== 6){options=new Option("Azul",6);$("#ingresar select").append(options)}$(this).children("img").attr("src","none");$(this).children("a").text("Libre");$(this).css("border","1px dashed #000")}});if(usuarios_reserva!=null)for(i=0;i<usuarios_reserva.length;i++){entre=0;$(".jugador").each(function(){if($(this).attr("id")==null&&entre==0&&usuarios_reserva[i].id!=null&&$(this).children("a").text()=="Libre"){$(this).children("img").attr("src","http://graph.facebook.com/"+usuarios_reserva[i].id+"/picture"); $(this).children("a").text(usuarios_reserva[i].nombre);$(this).css("border","1px dashed "+nombreColor(usuarios_reserva[i].color));$(this).attr("referencia_color",usuarios_reserva[i].color);entre=1;$("option").each(function(){$(this).attr("value")==usuarios_reserva[i].color&&$(this).remove()})}})}});setTimeout("$().esperandoJugadores()",700)})};$().esperandoJugadores();$("#ingresar select").change(function(){$("#ingresar select option:selected").attr("value")!=0&&$.getJSON("ajax/__reserva.php?color="+ $("#ingresar select option:selected").attr("value"),function(a){var b=0;$(".jugador").each(function(){if($(this).attr("id")==null&&b==0&&a.id!=null){b=1;jugadores=$(this);cuentaRegresiva();$("#unirse").attr("disabled",true)}})})})}); function cuentaRegresiva(){tiempo--;0<tiempo?($("#ingresar select").attr("disabled","disabled"),$("#unirse").attr("disabled",!1),$("#tiempo").text("Reservado por: "+tiempo+"segundos"),setTimeout("cuentaRegresiva()",1E3)):($("#tiempo").text(""),$("#ingresar select").attr("disabled",!1),$("#unirse").attr("disabled","disabled"),tiempo=30,$("#ingresar select option[value=0]").attr("selected",!0))};