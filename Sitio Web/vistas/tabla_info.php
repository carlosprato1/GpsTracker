<?php
require("../clases/tabla_terminales.class.php");
require("../clases/utilidades.class.php");
require("../clases/terminalesAndroid.class.php");

$objTerminales = new tabla_terminales;
$objAndroid = new terminalesAndroid;
$objUtilities = new utilidades;

$con=$objUtilities->conexion();
?>


<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dispositivos conectados</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/tabla_info.js" language="javascript" type="text/javascript"></script>
<script src="js/basicogmap.js" language="javascript" type="text/javascript"></script>
<script src="js/bootbox.min.js" language="javascript" type="text/javascript"></script>
  <style>
       #map {
        height:50vh;
        width: 100%;
       }
    </style>
</head>

<body>
	   
	<div class="container-fluid">
  <div id="map"></div>
	      <div class='row'>
          <div  class='col-xs-12 col-sm-3'>
            <a class="btn btn-success btn-sm" onClick="ultimo_todos(true)">Tiempo Real</a>
          </div>
          <div class='col-xs-6 col-sm-3' aling=center>
             <strong><center>Fecha</center></strong>
          </div>
          <div class='col-xs-2 col-sm-2'>  
            <strong><center>Hora 1</center></strong>
          </div>
            <div class='col-xs-2 col-sm-2'>
            <strong><center>Hora 2</center></strong>
          </div>
            <div class='col-xs-1 col-sm-2'>
          </div>
        </div>

   <?php 
        $ban=false;
        $ok=$objTerminales->buscar_terminales($con);
    while(($datos = mysql_fetch_assoc($ok))>0){ 
      $ban=true;
      $hora1 = "hora1".$datos['ID_T'];
      $hora2 = "hora2".$datos['ID_T'];
      $date  = "date".$datos['ID_T'];
 echo " 
 		<div class='row'>

  		 <div  class='col-xs-12 col-sm-3' onClick='escoger($datos[ID_T])'>
            <strong id='$datos[ID_T]'>$datos[nombre_t]</strong>
          </div>
          <div class='col-xs-6 col-sm-3'>
            <input class='form-control input-sm' type='date' id='$date'>
          </div>
          <div class='col-xs-2 col-sm-2'>  
            <input class='form-control input-sm' type='text' id='$hora1' value='0' size='3' maxlength='2'>
          </div>
            <div class='col-xs-2 col-sm-2'>
            <input class='form-control input-sm' type='text' id='$hora2' value='0' size='3' maxlength='2'>
          </div>
            <div class='col-xs-1 col-sm-2'>
            <a class='btn btn-success btn-xs' onClick='recorridoTk($datos[ID_T])'>Ver</a>
          </div>
        </div>";

        }//while

$ok=$objAndroid->buscar_android($con);
    while(($datos = mysql_fetch_assoc($ok))>0){ 
      $ban=true;
      $hora1 = "ahora1".$datos['ID_A'];
      $hora2 = "ahora2".$datos['ID_A'];
      $date  = "adate".$datos['ID_A'];

 echo " 
    <div class='row'>
       <div id='$datos[ID_A]' class='col-xs-12 col-sm-3' onClick='escoger($datos[ID_A])'>
            <strong id='$datos[ID_A]'>$datos[nombre_a]</strong>
          </div>
          <div class='col-xs-6 col-sm-3'>
            <input class='form-control input-sm' type='date' id='$date'>
          </div>
          <div class='col-xs-2 col-sm-2'>  
            <input class='form-control input-sm' type='text' id='$hora1' value='0' size='3' maxlength='2'>
          </div>
            <div class='col-xs-2 col-sm-2'>
            <input class='form-control input-sm' type='text' id='$hora2' value='0' size='3' maxlength='2'>
          </div>
            <div class='col-xs-1 col-sm-2'>
            <a class='btn btn-success btn-xs' onClick='recorridoAndroid($datos[ID_A])'>Ver</a>
          </div>
        </div>";

        }//while
        
        if (!$ban) {
          echo "<tr><td>No hay dispositivos agregados</td></tr>";
        }

      ?>
 
</div>
			
            <script src="js/bootstrap.min.js"></script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARGsQgVrHbmLJC0Wtdd1XCWfrcuULb5Vw&callback=initMap"></script>
<script>//hay problemas en la primera carga luego de borrar el cache
$(document).ready(function(){
    setTimeout(function() {
      ultimo_todos(true);
//esperar 3 segundos a que descargue la API de gmap(23.9KB aprox. 2.18s. dependiendo de conexion). si ya esta en cache no es necesario esperar.
//probar carga sincrona
    }, 3000);
}); 
</script> 

<!--
callback: carga la funcion initMap cuando se carga la api por completo.
async: seguir procesando el codigo mientras se carga la API
key: clave de la API
-->
		</body>

</html>

