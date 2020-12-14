<?php
function dados($cantidad,&$dados){
	
		$dados=array($cantidad);
		switch($cantidad){
			case(1):
				$dados[0]=mt_rand(1,6);
			break;
			case(2):
				$dados[0]=mt_rand(1,6);
				$dados[1]=mt_rand(1,6);
			
			break;
			case(3):
				$dados[0]=mt_rand(1,6);
				$dados[1]=mt_rand(1,6);
				$dados[2]=mt_rand(1,6);
			
			break;
		}
		$tmp=0;
		$j=0;
		for($i=0;$i<$cantidad;$i++){
			for($j=$i;$j<$cantidad;$j++){
				if($dados[$i]<$dados[$j]){
					$tmp=$dados[$i];
					$dados[$i]=$dados[$j];
					$dados[$j]=$tmp;
				}
			}
			
		}									
}
?>