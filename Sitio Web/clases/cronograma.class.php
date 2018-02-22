<?php

class cronograma{

 function agregarRecorrido($con,$recoDescri,$tipoR,$estadoR){

	 $sql = "INSERT INTO descripcion (est_des,descri,tipo) VALUES('$estadoR','$recoDescri','$tipoR')";

	  $ok=mysqli_query($con,$sql);
    
	if ($ok == false) {echo " Error en la Base de datos";} 
 }

 function buscarRecorridos($con){

		$sql = "SELECT est_des,descri,tipo,cod_des FROM descripcion";
 		$ok=mysqli_query($con,$sql);
    
	if ($ok == false) {echo " Error en la Base de datos";} 
	return $ok;
 }
  function eliminarRecorrido($con,$cod_des){

		 $sql = "DELETE FROM descripcion WHERE cod_des='$cod_des'";
         $ok=mysqli_query($con,$sql);

   
    
	if ($ok == false) {echo " Error en la Base de datos";} 
	return $ok;
 }


  function editarRecorrido($con,$name,$value){

		$sql = "UPDATE descripcion SET descri='$value' WHERE cod_des='$name'";
         $ok=mysqli_query($con,$sql);

	if ($ok == false) {echo " Error en la Base de datos";} 
	
 }


 function editarRecorrido1($con,$name,$value){

		$sql = "UPDATE descripcion SET tipo='$value' WHERE cod_des='$name'";
         $ok=mysqli_query($con,$sql);

	if ($ok == false) {echo " Error en la Base de datos";} 
	
 }

  function editarRecorrido2($con,$name,$value){

		$sql = "UPDATE descripcion SET est_des='$value' WHERE cod_des='$name'";
         $ok=mysqli_query($con,$sql);

	if ($ok == false) {echo " Error en la Base de datos";} 
	
 }

   function agregarEvento($con,$fky_des,$t,$v,$t0,$v0,$t1,$v1,$t2,$v2,$t3,$v3,$t4,$v4){

$tiempo[]   = $t;
$tiempo[]   = $t0; 
$tiempo[]   = $t1;
$tiempo[]   = $t2;
$tiempo[]   = $t3;
$tiempo[]   = $t4;
$vehiculo[] = $v;
$vehiculo[] = $v0;
$vehiculo[] = $v1;
$vehiculo[] = $v2;
$vehiculo[] = $v3;
$vehiculo[] = $v4;



	for ($i=0; $i < 6; $i++) { 

 		if ($tiempo[$i]  != "x") {

	 		$sqlaux[]= "('$fky_des','$tiempo[$i]','$vehiculo[$i]')";
	 	}	
	}

 $sqlaux1 = join(", ",$sqlaux);
 $sql = "INSERT INTO evento (fky_des,tiempo,vehiculo) VALUES ".$sqlaux1;
 $ok=mysqli_query($con,$sql);


	if ($ok == false) {echo " Error en la Base de datos";} 
	
 }

function consultaEvento($con,$fky_des,$fecha){

$i=0;
	$sql = "SELECT vehiculo,tiempo FROM evento WHERE fky_des='$fky_des' AND tiempo BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";

 	$ok=mysqli_query($con,$sql);

 	  while(($datos = mysqli_fetch_assoc($ok))>0){
      $row[$i] = $datos;
      $i++;
    }

    if (!$i){$row="nada";}

    $json = json_encode($row);

    echo $json;

}


function eliminarEvento($con,$fky_des,$fecha){

$i=0;
	$sql = "DELETE FROM evento WHERE fky_des='$fky_des' AND tiempo BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
//echo $sql;
 	$ok=mysqli_query($con,$sql);

 if ($ok == false) {echo " Error en la Base de datos";} 

}

function listarEvento($con,$fecha,$tipo){
$i=0;
 
 if ($tipo == "x") {
 	$sql="SELECT evento.fky_des, evento.vehiculo, evento.tiempo, descripcion.descri  FROM evento INNER JOIN descripcion ON evento.fky_des=descripcion.cod_des WHERE tiempo BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
 }else{
 	$sql="SELECT evento.fky_des, evento.vehiculo, evento.tiempo, descripcion.descri, descripcion.tipo  FROM evento INNER JOIN descripcion ON evento.fky_des=descripcion.cod_des WHERE tiempo BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
 }

	  $ok=mysqli_query($con,$sql);

 	  while(($datos = mysqli_fetch_assoc($ok))>0){
      $row[$i] = $datos;
      $i++;
    }

    if (!$i){$row="nada";}

    $json = json_encode($row);

    echo $json;

}//2018-02-14 04:05:00

function copiarASiguiente($con,$fechaActual,$escogida){
if ($escogida == 'x') {
 $año = substr($fechaActual,2,2);
 $mes = substr($fechaActual,5,2);
 $dia = substr($fechaActual,8,2)+1;
}else{
 $año = substr($escogida,8,2);
 $mes = substr($escogida,3,2);
 $dia = substr($escogida,0,2);
}

//dd-mm-yyyy
 $siguente = date("Y-m-d H:i:s", mktime(0,0,0,$mes,$dia,$año));


	$sql1 = "SELECT tiempo, fky_des, vehiculo FROM evento WHERE tiempo BETWEEN '$fechaActual 00:00:00' AND '$fechaActual 23:59:59'";

	 $ok=mysqli_query($con,$sql1);
	

 	  while(($datos = mysqli_fetch_assoc($ok))>0){


 $hora   = substr($datos['tiempo'],11,2);
 $minuto = substr($datos['tiempo'],14,2);
 

$siguente = date("Y-m-d H:i:s", mktime($hora,$minuto,0,$mes,$dia,$año)); 



    	$sqlaux[]= "('$siguente','$datos[fky_des]','$datos[vehiculo]')";


    }

 $sqlaux1 = join(", ",$sqlaux);
 $sql = "INSERT INTO evento (tiempo,fky_des,vehiculo) VALUES ".$sqlaux1;
 $ok=mysqli_query($con,$sql);
 //echo $sql;

}


}





