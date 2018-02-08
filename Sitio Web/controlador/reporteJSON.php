<?php
//ver fechas en la BD
$inputJSON = file_get_contents('php://input');
$json= json_decode( $inputJSON, TRUE ); //convert JSON into array
//print_r(json_encode($json)); //Para ver este json en el logcat del emulador android.
$length  = count($json);

require("../clases/utilidades.class.php");
require("../clases/androidEscribir.class.php");
$objUtilidades = new utilidades; 
$objandroidEscribir = new androidEscribir;
$con = $objUtilidades->conexion(); 

$appID   = $json[0]['i'];
$nombre = $json[0]['n'];

$respuesta=$objandroidEscribir->consultaAndroid($con,$nombre,$appID);

if($respuesta == "usado"){
	echo "usado";
}
  elseif($respuesta == "invalido"){
	  echo "invalido";
  } 
else{
	  
   for ($i=0; $i < $length ; $i++) { 
   
	    $speed      = $json[$i]['s'];
	    $error      = $json[$i]['p'];
    	$altitud    = $json[$i]['a'];
	    $direccion  = $json[$i]['r'];
	    $latitud    = $json[$i]['l'];
	    $longitud   = $json[$i]['o'];
	    $disUlt     = $json[$i]['d'];

        //2018-01-18+22%3A52%3A15 tenia unos problemas con la fecha para estar seguro la cambio a yyyy-MM-dd HH:mm:ss
        $aux  = str_replace("%3A",":",$json[$i]['f']);
        $TimeGPS    = str_replace("+"," ",$aux);

//json -> 0 entro por aqui "no conexion"

        $sqlaux[$i] = "('$latitud','$longitud','$altitud','$TimeGPS','$direccion','$disUlt','$error','$speed',0)";
    }//for

	$sqlaux1 = join(", ",$sqlaux);
    $sql = "INSERT INTO areporte_".$respuesta." (latitud,longitud,altitud,TimeGPS,direccion,disUlt,error,speed,json) VALUES ". $sqlaux1;
	$ok = mysqli_query($con,$sql);
 //echo $sql;
	if ($ok == false) {echo "  Error en la Base de datos...  ";return;} 
	echo "json reportado";

}//else


?>