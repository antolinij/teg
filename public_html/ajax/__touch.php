<?php

session_start();	
	if(isset($_SESSION['usuario'])){
		system('touch ../../partidas/'.$_SESSION['id_partida']);
	}
	
?>
