<?php

	//metodo, sessionid eliminar completamente.

 $latitud       = isset($_GET['l']) ? $_GET['l'] : '0';  //si latitud existe dale latitud si no existe que sea 0
 //$latitude       = (float)str_replace(",", ".", $latitude); // to handle European locale decimals
 $longitud      = isset($_GET['o']) ? $_GET['o'] : '0';
 //$longitud      = (float)str_replace(",", ".", $longitude);    
 $speed          = isset($_GET['s']) ? $_GET['s'] : 0;
 $direccion      = isset($_GET['r']) ? $_GET['r'] : 0;
 $distotal       = isset($_GET['t']) ? $_GET['t'] : '0';
 //$distotal       = (float)str_replace(",", ".", $distotal);
 $disUlt       = isset($_GET['d']) ? $_GET['d'] : '0';
 $fecha           = isset($_GET['f']) ? $_GET['f'] : '0000-00-00 00:00:00';
 //$fecha           = urldecode($fecha);
 $nombre       = isset($_GET['n']) ? $_GET['n'] : 0;
 $appID    = isset($_GET['i']) ? $_GET['i'] : '';
 $precision       = isset($_GET['p']) ? $_GET['p'] : 0;
 $altitud      = isset($_GET['a']) ? $_GET['a'] : 0;



if ($latitud == 0 || $longitud == 0) {
        exit('-1');
 }

require("../clases/utilidades.class.php");
require("../clases/androidEscribir.class.php");

$objUtilidades = new utilidades; 
$objandroidEscribir = new androidEscribir;
$con = $objUtilidades->conexion(); 


$respuesta=$objandroidEscribir->consultaAndroid($con,$nombre,$appID);

if($respuesta == "usado"){
	echo "usado";
}
elseif($respuesta == "invalido"){
	echo "invalido";
}
else{
	$objandroidEscribir->addReporte($con,$respuesta,$latitud,$longitud,$altitud,$fecha,$speed,$direccion,$disUlt,$distotal,$precision);
	echo "reportado";
}


?>