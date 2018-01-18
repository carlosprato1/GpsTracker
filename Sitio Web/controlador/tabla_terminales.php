<?php


require("../clases/utilidades.class.php");
require("../clases/tabla_terminales.class.php");
require("../clases/terminalesAndroid.class.php");

$objUtilidades = new utilidades;
$objTerminales = new tabla_terminales;
$objAndroid = new terminalesAndroid;

$con=$objUtilidades->conexion();

	switch($_REQUEST["accion"]){
		
		case 'buscar_terminales':
			$respuesta=$objTerminales->buscar_terminales($con); 
		break;	
	
		case 'agregar_terminal':
			$respuesta=$objTerminales->agregar_terminal($con,$_POST["imei"],$_POST["nombre_t"],$_POST["telefono"]);
		break;
		case 'agregar_terminal':
			$respuesta=$objTerminales->agregar_terminal($con,$_POST["imei"],$_POST["nombre_t"],$_POST["telefono"]);
		break;

		case 'buscar_android':
			$respuesta=$objAndroid->buscar_android($con);
		break;
		case 'agregar_android':
			$respuesta=$objAndroid->agregar_android($con,$_POST["nombre_a"],$_POST["telefono"]);
		break;

		case 'eliminar_android':
			$respuesta=$objAndroid->eliminar_android($con,$_POST["ID_A"]);
		break;
		
		case 'liberar_android':
			$respuesta=$objAndroid->liberar_android($con,$_POST["ID_A"]);
		break;
	}

	if ($respuesta == false) {echo "ERROR_BD"; }

?>