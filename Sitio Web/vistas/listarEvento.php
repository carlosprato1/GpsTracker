<?php
require("../clases/cronograma.class.php");
require("../clases/cronoUtilidades.class.php");

$objcronograma = new cronograma;
$objUtilities = new utilidades;

$con=$objUtilities->conexion();
?>


<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cronograma privado</title>

 <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
 <script src="Bootstrap/jquery-3.1.1.min.js"></script> 
  <script src="Bootstrap/bootstrap.min.js"></script>

  <link rel="stylesheet" href="datepicker/bootstrap-datetimepicker.min.css">
  <script src="datepicker/moment.js"></script>
  <script src="datepicker/moment-es.js"></script>
  <script src="datepicker/bootstrap-datetimepicker.min.js"></script>
  <script src="js/listarEvento.js"></script>

<style type="text/css">

  #descripcion:hover {
    background-color: #F3F3F3;
    border:1px solid #DEDEDE ;
    border-radius: 5px;
  
}

</style>

</head>

<body>
	   
<div class="container">
  <div class="row align-items-start">

      <div class='row'>
         <div  class='col-xs-12 col-sm-12'><br></div>
      </div>


      <div class='row'>
        <div  class='col-xs-2'></div>

        <div  class='col-xs-1'>
            <button type="button" class="btn btn-primary" onClick='cambiarFecha(1)'><</button>
        </div>

        <div class='col-xs-6'>
                 <div class='container'>
                     <div class='col-xs-12 col-sm-6' style='height:50px;'>
                            <input type='text' class='form-control' id='date' />
                     </div>
                 </div>
        </div>

        <div class='col-xs-2'>
            <button type="button" class="btn btn-primary" onClick='cambiarFecha(2)'>></button>
        </div>

      </div> 

    <div id="roca"></div>


          
    
      <!--    <div class='row' id="descripcion">
            <div class='col-xs-12 col-sm-12' id='arena'>
               <br><h4><a href = "www.google.com">Ruta 2: Salida: UNET - LLegada: San Josecito.</a></h4>

               <div class='col-xs-4 col-sm-2'>
                <h5>Hora: 4:50pm</h5>
                <h5>Rutas: 12,53</h5>
               </div>

             </div>
            </div>   -->
	 

  </div>
</div>
			
            <script type='text/javascript'>
                        calendar();
                    </script>

		</body>


</html>

