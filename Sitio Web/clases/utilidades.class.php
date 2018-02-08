<?php

class utilidades {
	
	function conexion(){ //funcion de conexion
		
		//las comillas dobles y simples son diferentes "$x 1" acepta el valor '$x 1' continuo
//abre conexion con servidor Mysql (direccion,usuario,contraseña). retorna un enlace de si no conecta retorna false.	
	$con=@mysqli_connect("localhost","phpmyadmin","carlos","android_tracker");
	 if($con==false){
		echo "imposible conectarse con el servidor: ".PHP_EOL;
	    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
			}else{
//slecciona la base de datos. (false-error true-succes.)	

			/*$con_bd=@mysqli_select_db("android_tracker",$con);
				
				if($con_bd == false)
					echo "Imposible conectarse a la base de datos";
						else*/
							return $con; //ya esta conectado  a la BD. $con es el ticket que me identifica la conexion. 
	
						}
		}//conexion


}//class



?>
