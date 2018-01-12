<?php

class utilidades {
	
	function conexion(){ //funcion de conexion
		
		//las comillas dobles y simples son diferentes "$x 1" acepta el valor '$x 1' continuo
//abre conexion con servidor Mysql (direccion,usuario,contraseña). retorna un enlace de si no conecta retorna false.	
	$con=@mysql_connect("mysql.hostinger.es","u973417145_root","genius11");
	 if($con==false)
		echo "imposible conectarse con el servidor";
			else{
//slecciona la base de datos. (false-error true-succes.)	

			$con_bd=@mysql_select_db("u973417145_curso",$con);
				
				if($con_bd == false)
					echo "Imposible conectarse a la base de datos";
						else
							return $con; //ya esta conectado  a la BD. $con es el ticket que me identifica la conexion. 
	
						}
		}//conexion


}//class



?>