<?php

require("../clases/cronoUtilidades.class.php");
require("../clases/cronograma.class.php");

$objUtilidades = new utilidades; 
$objcronograma = new cronograma;

$con = $objUtilidades->conexion(); 



if (isset($_REQUEST["accion"])) {

	switch($_REQUEST["accion"]){
		
		case 'add_recorrido':
$respuesta=$objcronograma->agregarRecorrido($con, $_POST["recoDescri"], $_POST["tipoR"], $_POST["estadoR"]);
		header('Location: ../vistas/listarRecorridos.php');
		break;	

		case 'eliminar_recorrido':
$respuesta=$objcronograma->eliminarRecorrido($con, $_POST["cod_des"]);
		break;	

		case'agregar_evento':

	$cod =	isset($_POST["cod"]) ? $_POST["cod"] : 'x';
	$t  =	isset($_POST["t"])  ? $_POST["t"]  : 'x';
	$t0 =	isset($_POST["t0"]) ? $_POST["t0"] : 'x';
	$t1 =	isset($_POST["t1"]) ? $_POST["t1"] : 'x';
	$t2 =	isset($_POST["t2"]) ? $_POST["t2"] : 'x';
	$t3 =	isset($_POST["t3"]) ? $_POST["t3"] : 'x';
	$t4 =	isset($_POST["t4"]) ? $_POST["t4"] : 'x';
	$v  =	isset($_POST["v"])  ? $_POST["v"]  : 'x';
	$v0 =	isset($_POST["v0"]) ? $_POST["v0"] : 'x';
	$v1 =	isset($_POST["v1"]) ? $_POST["v1"] : 'x';
	$v2 =	isset($_POST["v2"]) ? $_POST["v2"] : 'x';
	$v3 =	isset($_POST["v3"]) ? $_POST["v3"] : 'x';
	$v4 =	isset($_POST["v4"]) ? $_POST["v4"] : 'x';
$respuesta=$objcronograma->agregarEvento($con,$cod,$t,$v,$t0,$v0,$t1,$v1,$t2,$v2,$t3,$v3,$t4,$v4);
		break;
		case 'consulta_evento':
$respuesta=$objcronograma->consultaEvento($con,$_POST["cod_des"],$_POST["fecha"]);
		break;
		case 'eliminar_evento':
		$respuesta=$objcronograma->eliminarEvento($con,$_POST["cod_des"],$_POST["fecha"]);
		break;
		case 'consulta_listar_evento':
		$respuesta=$objcronograma->listarEvento($con,$_POST["fecha"]);
		break;

}
 //if ($respuesta == false) {echo " Error en la Base de datos...";} 

}else{


switch($_POST["pk"]){
	case 'editar_recorrido':
	$respuesta=$objcronograma->editarRecorrido($con, $_POST["name"], $_POST["value"]);
	break;

	case 'editar_recorrido1':
		if ($_POST["value"] == 1) {
			$value = "f";
		}else{
			$value = "u";
		}
	$respuesta=$objcronograma->editarRecorrido1($con,str_replace("select","",$_POST["name"]),$value );
	break;

case 'editar_recorrido2':
		if ($_POST["value"] == 1) {
			$value = "a";
		}else{
			$value = "i";
		}
	$respuesta=$objcronograma->editarRecorrido2($con,str_replace("estado","",$_POST["name"]),$value );
	break;



}
//if ($respuesta == false) {echo " Error en la Base de datos...";} 
}


?>