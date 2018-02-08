<?php

require("../clases/utilidades.class.php");
require("../clases/recorridos.class.php");

$objUtilidades = new utilidades; 
$objRecorridos = new recorridos;

$con = $objUtilidades->conexion(); 


	switch($_REQUEST["accion"]){
		
		case 'ultimo_todos':
$respuesta=$objRecorridos->ultimo_todos($con);
		break;	
		
		case 'recorrido':
$respuesta=$objRecorridos->recorrido($con,$_POST['h1'],$_POST['h2'],$_POST['date'],$_POST['ID_A']);
		break;	
		
		case 'diasActivos':
$respuesta=$objRecorridos->diasActivos($con);
		break;	

if ($respuesta == false) {echo " Error en la Base de datos...";} 

}

?>