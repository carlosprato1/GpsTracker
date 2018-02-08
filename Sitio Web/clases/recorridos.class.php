<?php

class recorridos
{

  function ultimo_todos($con){


  $r=0; //sql_aux1
  $i=0; //row1

  $sql5 = "SHOW FULL TABLES FROM android_tracker";
  $oktable = mysqli_query($con,$sql5);

 while(($datos = mysqli_fetch_assoc($oktable))>0){

   if(substr($datos['Tables_in_android_tracker'],0,3)=="are"){

$ID_A[$r] = substr($datos["Tables_in_android_tracker"],(-1)*strlen($datos["Tables_in_android_tracker"])-9);

$sql_aux1[$r] = "SELECT latitud,longitud,ID_A,speed,altitud,direccion,disUlt,error,TimeGPS
               FROM ".$datos['Tables_in_android_tracker']."
               WHERE TimeGPS = (SELECT MAX(TimeGPS) FROM ".$datos['Tables_in_android_tracker'].")";
      $r++;
   }
 }//while

if($r){
  if($r == 1){$sql = $sql_aux1[0];}
  else{$sql = join(" UNION ALL ",$sql_aux1);}

		$ok = mysqli_query($con,$sql);
 	
		while(($datos1 = mysqli_fetch_assoc($ok))>0){//leo los reportes
			$row1[$i] = $datos1;
			$i++;
		}
    if (!$i) {$row1 = "nada";}
}else{$row1 = "nada";}

		$json = json_encode($row1);

    for ($aux=0; $aux < $i; $aux++) { 
      # code...
    }

    echo $json;

  }//ultimo_todos

function recorrido($con,$h1,$h2,$date_aux,$ID_T) {
 

 $año = substr($date_aux,2,2);
 $mes = substr($date_aux,5,2);
 $dia = substr($date_aux,8,2);
 $date1 = date("Y-m-d H:i:s", mktime($h1,0,0,$mes,$dia,$año));
 $date2 = date("Y-m-d H:i:s", mktime($h2,0,0,$mes,$dia,$año));

  $sql = "SELECT latitud,longitud,TimeGPS,speed,altitud,direccion,disUlt,error FROM areporte_".$ID_T." WHERE TimeGPS > '".$date1."' AND TimeGPS < '".$date2."'";

//echo $sql;
  $ok = mysqli_query($con,$sql);
  $i=0;
    while(($datos1 = mysqli_fetch_assoc($ok))>0){
      $row1[$i] = $datos1;
      $i++;
    }
    if (!$i){$row1="nada";}

    $json = json_encode($row1);

    echo $json;

}// function

function diasActivos($con) {


}


}//class
?>


