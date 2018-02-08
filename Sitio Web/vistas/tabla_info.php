<?php
require("../clases/utilidades.class.php");
require("../clases/terminalesAndroid.class.php");

$objAndroid = new terminalesAndroid;
$objUtilities = new utilidades;

$con=$objUtilities->conexion();
?>


<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dispositivos conectados</title>
<link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
<script src="Bootstrap/jquery-3.1.1.min.js"></script>

<script src="Bootstrap/bootbox.min.js" language="javascript" type="text/javascript"></script>

  <link rel="stylesheet" href="datepicker/bootstrap-datetimepicker.min.css">
  <script src="datepicker/moment.js"></script>
  <script src="datepicker/moment-es.js"></script>
  <script src="datepicker/bootstrap-datetimepicker.min.js"></script>
<script src="js/basicogmap.js" language="javascript" type="text/javascript"></script>


  <style>
       #map {
        height:50vh;
        width: 100%;
       }
    </style>
</head>

<body>
	   
<div class="container-fluid">

  <div class="row align-items-start">

    <div id="map"></div>
    
	      <div class='row'>
          <div  class='col-xs-4 col-sm-3'>
            <a class="btn btn-success btn-sm" onClick="ultimo_todos(true)">Ult. Posicion</a>
          </div>

           <div class='col-xs-1 col-sm-1'>
            <span class='glyphicon glyphicon-pause' style='color:#DAA836' onClick='pause1()'></span>

          </div>
          <div class='col-xs-1 col-sm-1'>
            <span class='glyphicon glyphicon-stop' style='color:#E13E1B' onClick='stop()'></span>
          </div>
        </div>  

          
     
   <?php 
        $ban=false;

$ok=$objAndroid->buscar_android($con);
    while(($datos = mysqli_fetch_assoc($ok))>0){ 
      $ban=true;
      $hora1 = "ahora1".$datos['ID_A'];
      $hora2 = "ahora2".$datos['ID_A'];
      $date  = "adate".$datos['ID_A'];

 echo " 
    <div class='row'>

       <div id='$datos[ID_A]' class='col-xs-3 col-sm-1'>
            <strong id='$datos[ID_A]'>$datos[nombre_a]</strong>
       </div>
       
         <div class='col-xs-12 col-sm-4'>  
            
                 <div class='container'>
                     <div class='col-xs-12 col-sm-4' style='height:50px;'>
                         <div class='form-group'>
                             <div class='input-group date' id='$date'>
                                 <input type='text' class='form-control' />
                                 <span class='input-group-addon' >
                                     <span class='glyphicon glyphicon-calendar'>
                                     </span>
                                 </span>
                             </div>
                         </div>
                     </div>
                 </div>

        </div>

          <div class='col-xs-6 col-sm-3'>  
           
                 <div class='container'>
                  <div class='row'>
                    <div class='col-xs-12 col-sm-3'>
                      <div class='form-group'>
                        <div class='input-group date' id='$hora1'>
                          <input type='text' class='form-control'/>
                          <span class='input-group-addon'>
                             <span class='glyphicon glyphicon-time'></span>        
                          </span>
                        </div>
                      </div>
                    </div>
                
                  </div>
                </div>

          </div>

          <div class='col-xs-6 col-sm-3'>
            
                <div class='container'>
                  <div class='row'>
                    <div class='col-xs-12 col-sm-3'>
                      <div class='form-group'>
                        <div class='input-group date' id='$hora2'>
                          <input type='text' class='form-control'/>
                          <span class='input-group-addon' >
                             <span class='glyphicon glyphicon-time'></span>        
                          </span>
                        </div>
                      </div>
                    </div>
                
                  </div>
                </div>

          </div>

          <div class='col-xs-1 col-sm-1'>
            <a class='glyphicon glyphicon-play' onClick='recorridoAndroid($datos[ID_A])'></a>
          </div>

                    <script type='text/javascript'>
                        calendar($datos[ID_A]);
                    </script>

    </div>";

        }//while
        
        if (!$ban) {
          echo "<tr><td>No hay dispositivos agregados</td></tr>";
        }

      ?>
 
</div>
</div>
			
            <script src="Bootstrap/bootstrap.min.js"></script>
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

