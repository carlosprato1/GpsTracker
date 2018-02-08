<?php

class utilidades {
	
	function conexion(){
		

	$con=@mysqli_connect("localhost","phpmyadmin","carlos","cronograma");
	 if($con==false){
		echo "imposible conectarse con el servidor: ".PHP_EOL;
	    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
			}else{
							return $con; 
	
						}
		}//conexion


}//class



?>
