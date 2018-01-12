<?php

class tk_escribir
{

 function add_info($con,$ID_T,$tipo,$TimeGPS,$statusGPS,$GMT,$latitud,$longitud,$speed_in_mph,$motor){


	 $sql = "insert into reporte".$ID_T."(tipo,TimeGPS,statusGPS,GMT,latitud,longitud,speed,motor)
     				 values('$tipo','$TimeGPS','$statusGPS','$GMT','$latitud','$longitud','$speed_in_mph','$motor')";

//esta funcion ejecuta una sentencia: mysql_query(p1,$conexion)
//p1= (INSERT,UPDATE,DELETE,DROP) --> return true en exito y false si hay error.
//p1= (SELECT) --> return una variable de la BD y false si hubo error.
	  $ok=mysql_query($sql,$con);
      echo $sql;
		if($ok == true)
			return 1;
			 else 
			 	return 0;
	
 }// 

 function cambiar_inte($con,$imei,$conexion){

 $sql = "UPDATE terminal SET conexion = '$conexion' WHERE imei = '$imei'";
 echo $sql;
 $ok=mysql_query($sql,$con);
 
}


}
?>


