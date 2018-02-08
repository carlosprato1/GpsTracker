<?php
require("../clases/terminalesAndroid.class.php");
require("../clases/utilidades.class.php");

$objAndroid = new terminalesAndroid;
$objUtilities = new utilidades;

$con=$objUtilities->conexion();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
	<title>Terminales - Android</title>
	<script src="js/terAndroid.js" language="javascript" type="text/javascript"></script>
	<script src="Bootstrap/jquery-3.1.1.min.js"></script>
	<script src="Bootstrap/bootbox.min.js" language="javascript" type="text/javascript"></script>
</head>
<body>
	<br>
<div class="container">
  
<table class="table table-striped table-hover" id="tabla_terminal">

    <tr>
      <th>Nombre</th>
      <th>Telefono</th>
    </tr>

    <?php 
         $ban=false;
  			$ok=$objAndroid->buscar_android($con);
	  while(($datos = mysqli_fetch_assoc($ok))>0){ 
	  	$ban=true;
  		echo "<tr>
					<td>$datos[nombre_a]</td>
					<td>$datos[telefono]</td>
					<td><a class='btn btn-danger btn-xs' onClick='eliminar_android($datos[ID_A])'>Eliminar</a></td>
          <td><a class='btn btn-warning btn-xs' onClick='liberar_android($datos[ID_A])'>Liberar</a></td>
			</tr>";	
  			}
  			if (!$ban) {
  				echo "<tr><td>No hay dispositivos agregados al sistema</td></tr>";
  			}
 		  ?>

</table>

   <div class="col-xs-3"></div> 
   <div class="col-xs-9">
     <a class="btn btn-success btn-sm" onClick="agregar_android()">Agregar Android</a>
   </div>


<div class="col-xs-12">
<table class="table table-striped table-hover">
 <tr>
   <th><input type="text" size="9" class="form-control input-sm" maxlength="20" id="nnombre_a" name="nnombre_a" placeholder="Nuevo Dispositivo"></th>
    <th><input type="text" size="10" class="form-control input-sm" maxlength="20" id="ntelefono" name="ntelefono" placeholder="Nuevo Telefono"></th>
 </tr>
</table>
</div>


</div>
<script src="Bootstrap/bootstrap.min.js"></script>


</body>
</html>