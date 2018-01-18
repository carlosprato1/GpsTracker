<?php

class recorridos
{

  function ultimo_todos($con){

  $sql5 = "SHOW FULL TABLES FROM u973417145_curso";

  $oktable = mysql_query($sql5,$con);
  $r=0;
  $i=0;
  while(($datos = mysql_fetch_assoc($oktable))>0){
  if (substr($datos["Tables_in_u973417145_curso"],0,7)=="reporte") {

  	   $sql_aux[$r] = "SELECT latitud,longitud,ID_T,speed,TimeGPS
				       FROM ".$datos['Tables_in_u973417145_curso']."
				       WHERE TimeGPS = (SELECT MAX(TimeGPS) FROM ".$datos['Tables_in_u973417145_curso'].")";
       $r++;
   }
 }//while
 if($r!=0){

    $sql = join(" UNION ALL ",$sql_aux);

    $ok = mysql_query($sql,$con);
    
    while(($datos1 = mysql_fetch_assoc($ok))>0){
      $row1[$i] = $datos1;
      $i++;
    }
    }

      $sql5 = "SHOW FULL TABLES FROM u973417145_curso";
  $oktable = mysql_query($sql5,$con);

  $r=0;

 while(($datos = mysql_fetch_assoc($oktable))>0){

   if(substr($datos['Tables_in_u973417145_curso'],0,3)=="are"){

$sql_aux1[$r] = "SELECT latitud,longitud,ID_A,speed,altitud,direccion,disUlt,error,TimeGPS
               FROM ".$datos['Tables_in_u973417145_curso']."
               WHERE TimeGPS = (SELECT MAX(TimeGPS) FROM ".$datos['Tables_in_u973417145_curso'].")";
      $r++;
   }
 }//while

if($r!=0){
  if($r == 1){$sql = $sql_aux1[0];}
  else{$sql = join(" UNION ALL ",$sql_aux1);}
		$ok = mysql_query($sql,$con);
 	
		while(($datos1 = mysql_fetch_assoc($ok))>0){
			$row1[$i] = $datos1;
			$i++;
		}
}
		$json = json_encode($row1); //validar si no hay ningun dato error.
        echo $json;

  }//ultimo_todos

function recorrido($con,$h1,$h2,$date_aux,$ID_T,$tipo) {
 

 $año = substr($date_aux,2,2);
 $mes = substr($date_aux,5,2);
 $dia = substr($date_aux,8,2);
 $date1 = date("Y-m-d H:i:s", mktime($h1,0,0,$mes,$dia,$año));
 $date2 = date("Y-m-d H:i:s", mktime($h2,0,0,$mes,$dia,$año));

if($tipo == 1){//reporte , areporte
  $sql = "SELECT latitud,longitud,TimeGPS FROM reporte_".$ID_T." WHERE TimeGPS > '".$date1."' AND TimeGPS < '".$date2."'";
}else{
  $sql = "SELECT latitud,longitud,TimeGPS,speed,altitud,direccion,disUlt,error FROM areporte_".$ID_T." WHERE TimeGPS > '".$date1."' AND TimeGPS < '".$date2."'";
}
//echo $sql;
  $ok = mysql_query($sql,$con);
  $i=0;
    while(($datos1 = mysql_fetch_assoc($ok))>0){
      $row1[$i] = $datos1;
      $i++;
    }
    if (!$i){$row1="nada";}

    $json = json_encode($row1);
    echo $json;

}



}//class
?>


