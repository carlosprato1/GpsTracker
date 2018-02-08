<?php

require("../clases/utilidades.class.php");
require("../clases/terminalesAndroid.class.php");

$objUtilidades = new utilidades;
$objAndroid = new terminalesAndroid;

$con=$objUtilidades->conexion();

	switch($_REQUEST["accion"]){

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