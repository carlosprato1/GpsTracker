<?php

class androidEscribir{

 function addReporte($con,$ID_A,$latitud,$longitud,$altitud,$fecha,$speed,$direccion,$disUlt,$precision){

	 $sql = "insert into areporte_".$ID_A." (latitud,longitud,altitud,TimeGPS,direccion,disUlt,error,speed) values('$latitud','$longitud','$altitud','$fecha','$direccion','$disUlt','$precision','$speed')";

//esta funcion ejecuta una sentencia: mysql_query(p1,$conexion)
//p1= (INSERT,UPDATE,DELETE,DROP) --> return true en exito y false si hay error.
//p1= (SELECT) --> return una variable de la BD y false si hubo error.
	  $ok=mysqli_query($con,$sql);
    
	if ($ok == false) {echo " Error en la Base de datos";} 
 }// 

function consultaAndroid($con,$nombre_a,$appID){
	$sql = "SELECT nombre_a,ID_A,appID FROM android WHERE nombre_a='$nombre_a'"; 
    $ok=mysqli_query($con,$sql);

    if($datos = mysqli_fetch_array($ok)){
    	if($datos["appID"] == "no"){
    		$sql1 = "UPDATE android SET appID = '$appID' WHERE nombre_a='$nombre_a'";
    		$okey=mysqli_query($con,$sql1);
    		return $datos["ID_A"];
    	}
    	if($datos["appID"] == $appID){return $datos["ID_A"];}

    	else{return "usado";}
    }

    else{return "invalido";}


}//consultaAndroid


}//class
?>


