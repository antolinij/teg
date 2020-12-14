<?php

function crear_archivo($nombre_archivo,$objeto){
		
			//serializa el objeto y lo mete en la variable archivo
			$archivo = serialize($objeto);
			//guarda la variable archivo en un archivo cuyo nombre es nombre_archivo
		file_put_contents($nombre_archivo,$archivo);

}

function abrir_archivo($nombre_archivo){

		$archivo = file_get_contents($nombre_archivo);

		$partida = unserialize($archivo);	
		
		return $partida;

}

?>