<?php

class tabla_terminales{

 function buscar_terminales($con){


	$sql = "SELECT imei,nombre_t,telefono,ID_T FROM terminales";
 		$ok=mysql_query($sql,$con);
 		return $ok;

 }

function agregar_terminal($con,$imei,$nombre,$telefono){


	$sql1 = "INSERT INTO terminales(imei,nombre_t,telefono) VALUES('$imei','$nombre','$telefono')";
 		$ok=mysql_query($sql1,$con);

 				$sql = "SELECT ID_T FROM terminales ORDER BY ID_T DESC LIMIT 1";
 				$ultimo=mysql_query($sql,$con);
 				 while($datos = mysql_fetch_array($ultimo)) {
           			$ID_T= $datos["ID_T"];
            	}
            	$sql2  = "CREATE TABLE reporte_".$ID_T."(latitud decimal(10,7) NOT NULL DEFAULT 0.0000000,
                         longitud decimal(10,7) NOT NULL DEFAULT 0.0000000,
                         ID_T int(10) NOT NULL DEFAULT ".$ID_T.",
                         ID_A int(10) NOT NULL auto_increment primary key,
                         TimeCarga timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         speed int(10) DEFAULT 0,
                         TimeGPS timestamp,
                         statusGPS varchar(5) NOT NULL DEFAULT 0,
                         tipo varchar(20) NOT NULL DEFAULT 0,
                         GMT time,
                         motor int(5) DEFAULT NULL)engine=innoDB;";		
				$okey = mysql_query($sql2,$con);
 

 		return $okey;


 }

 function eliminar_terminal($con,$ID_T){
      $sql = "DELETE FROM terminales WHERE ID_T='$ID_T'";
      $ok=mysql_query($sql,$con);

      $sql1 = "DROP TABLE reporte_".$ID_T;
      $ok=mysql_query($sql1,$con);

      return $ok;
 }
	

}//class
?>


