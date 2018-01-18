<?php

class terminalesAndroid
{

 function buscar_android($con){

	$sql = "SELECT nombre_a,telefono,ID_A FROM android";
 		$ok=mysql_query($sql,$con);
 		return $ok;
 }

function agregar_android($con,$nombre,$telefono){


	$sql1 = "INSERT INTO android(nombre_a,telefono) VALUES('$nombre','$telefono')";

 		$ok=mysql_query($sql1,$con);

 				$sql = "SELECT ID_A FROM android ORDER BY ID_A DESC LIMIT 1";
                        $ultimo=mysql_query($sql,$con);
                         while($datos = mysql_fetch_array($ultimo)) {
           			$ID_A= $datos["ID_A"];
            	}

            	$sql2  = "CREATE TABLE areporte_".$ID_A."(latitud decimal(10,7) NOT NULL DEFAULT 0.0000000,
                         longitud decimal(10,7) NOT NULL DEFAULT 0.0000000,
                         ID_A int(10) NOT NULL DEFAULT ".$ID_A.",
                         ID_U int(10) NOT NULL auto_increment primary key,
                         TimeCarga timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         speed int(10) DEFAULT 0,
                         TimeGPS timestamp,
                         altitud decimal(10,1) DEFAULT 0,
                         direccion decimal(10,1) DEFAULT 0,
                         disUlt decimal(10,1) DEFAULT 0.0,
                         dtotal decimal(50,1) DEFAULT 0.0,
                         error decimal(10,2) NOT NULL DEFAULT 0.0);";	
                         echo $sql2;	
				$okey = mysql_query($sql2,$con);
 	
 		return $okey;
                     
 }

 function eliminar_android($con,$ID_A){
      $sql = "DELETE FROM android WHERE ID_A='$ID_A'";
      $ok=mysql_query($sql,$con);

      $sql1 = "DROP TABLE areporte_".$ID_A;
      $ok=mysql_query($sql1,$con);
      return $ok;
 }
	
 function liberar_android($con,$ID_A){
     $sql = "UPDATE android SET appID = 'no' WHERE ID_A = '$ID_A'";
     $ok=mysql_query($sql,$con);
     return $ok;
 }

}//class
?>

