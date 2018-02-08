<?php

class terminalesAndroid
{

 function buscar_android($con){

	$sql = "SELECT nombre_a,telefono,ID_A FROM android";
 		$ok=mysqli_query($con,$sql);
 		return $ok;
 }

function agregar_android($con,$nombre,$telefono){


	$sql1 = "INSERT INTO android(nombre_a,telefono) VALUES('$nombre','$telefono')";

 		$ok=mysqli_query($con,$sql1);

 				$sql = "SELECT ID_A FROM android ORDER BY ID_A DESC LIMIT 1";
                        $ultimo=mysqli_query($con,$sql);
                         while($datos = mysqli_fetch_array($ultimo)) {
           			$ID_A= $datos["ID_A"];
            	}

            	$sql2  = "CREATE TABLE areporte_".$ID_A."(latitud decimal(10,7) NOT NULL DEFAULT 0.0000000,
                         longitud decimal(10,7) NOT NULL DEFAULT 0.0000000,
                         ID_A int(10) NOT NULL DEFAULT ".$ID_A.",
                         TimeCarga timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         speed decimal(10,3) DEFAULT 0.000,
                         TimeGPS timestamp primary key,
                         altitud decimal(10,1) DEFAULT 0,
                         direccion decimal(10,1) DEFAULT 0,
                         disUlt decimal(10,1) DEFAULT 0.0,
                         json tinyint(1) DEFAULT 1,
                         error decimal(10,2) NOT NULL DEFAULT 0.0);";	
                         echo $sql2;	
				$okey = mysqli_query($con,$sql2);
 	
 		return $okey;
                     
 }

 function eliminar_android($con,$ID_A){
      $sql = "DELETE FROM android WHERE ID_A='$ID_A'";
      $ok=mysqli_query($con,$sql);

      $sql1 = "DROP TABLE areporte_".$ID_A;
      $ok=mysqli_query($con,$sql1);
      return $ok;
 }
	
 function liberar_android($con,$ID_A){
     $sql = "UPDATE android SET appID = 'no' WHERE ID_A = '$ID_A'";
     $ok=mysqli_query($con,$sql);
     return $ok;
 }

}//class
?>

