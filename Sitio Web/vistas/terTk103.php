<?php

require("../clases/tabla_terminales.class.php");
require("../clases/utilidades.class.php");

$objTerminales = new tabla_terminales;
$objUtilities = new utilidades;


$con=$objUtilities->conexion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Terminales - Tk103</title>
	<script src="js/tabla_terminales.js" language="javascript" type="text/javascript"></script>
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootbox.min.js" language="javascript" type="text/javascript"></script>
</head>
<body>
	

<table class="table table-striped table-hover" id="tabla_terminal">

    <tr>
      <th>IMEI</th>
      <th>Nombre</th>
      <th>Telefono</th>
    </tr>

    <?php 
         $ban=false;
  			$ok=$objTerminales->buscar_terminales($con);
	  while(($datos = mysql_fetch_assoc($ok))>0){ 
	  	$ban=true;
  		echo "<tr>
  					<td>$datos[imei]</td>
					<td>$datos[nombre_t]</td>
					<td>$datos[telefono]</td>
					<td><a class='btn btn-danger btn-xs' onClick='eliminar_terminal($datos[ID_T])'>Eliminar</a></td>
			</tr>";	
  			}
  			if (!$ban) {
  				echo "<tr><td>No hay dispositivos agregados al sistema</td></tr>";
  			}
 		  ?>
<tr>
<th></th>
	<th><a class="btn btn-success btn-sm" onClick="agregar_terminal()">Agregar Terminal</a><th>
<th></th>
</tr>

<tr>
	<th><input class="form-control input-sm" type="text" name="nimei" id="nimei" value="0" size="14" maxlength="15"></th>
	<th><input class="form-control input-sm" type="text" name="nnombre_t" id="nnombre_t" value="na" size="14" maxlength="20"></th>
	<th><input class="form-control input-sm" type="text" name="ntelefono" id="ntelefono" value="0" size="14" maxlength="20"></th>
</tr>


</table> 

<script src="js/bootstrap.min.js"></script>


</body>
</html>