// JavaScript Document
$.fn.dado = function(){
	var i=0;
	var dados=0;
	data=0;
		dados= $(this).children();
		if(arregloDados != undefined){
			//alert(arregloDados['ataque']);
			//alert(arregloDados['defensa']);
		//$.getJSON( 'ajax/__dados.php?de='+$(this).attr('id'), function( data ) {
		if($(this).attr('id') == 'dados_atacante')
			data=arregloDados['ataque'];
		else
			data=arregloDados['defensa'];
			
			if(data!=null){
				dados.each(function (){
					if(i==0){
						if(data[0] != null)
							$(this).css({'background-image':'url(fondos/dado'+data[0]+'.png)'});
						else
							$(this).css({'background-image':'none'});
					}
					if(i==1){
						if(data[1] != null)
							$(this).css({'background-image':'url(fondos/dado'+data[1]+'.png)'});
						else
							$(this).css({'background-image':'none'});
					}
					if(i==2){
						if(data[2] != null)
							$(this).css({'background-image':'url(fondos/dado'+data[2]+'.png)'});
						else
							$(this).css({'background-image':'none'});
					}
					
					i++;
					
				});
			}
			else{
				dados.each(function (){
					$(this).css({'background-image':'none'});
					
				});
			}
   		// }); 
		}
else{
				dados.each(function (){
					$(this).css({'background-image':'none	'});
					
				});
			}
};