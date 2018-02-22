<?php


require("../clases/cronograma.class.php");
require("../clases/cronoUtilidades.class.php");

$objcronograma = new cronograma;
$objUtilities = new utilidades;

$con=$objUtilities->conexion();

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Cronograma Privado</title>
  
 <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
 <link rel="stylesheet" href="Boostrap-editable/css/bootstrap-editable.css">
 <script src="Bootstrap/jquery-3.1.1.min.js"></script> 


  <script src="Bootstrap/bootstrap.min.js"></script>

  <link rel="stylesheet" href="datepicker/bootstrap-datetimepicker.min.css">
  <script src="datepicker/moment.js"></script>
  <script src="datepicker/moment-es.js"></script>
  <script src="datepicker/bootstrap-datetimepicker.min.js"></script>
  <script src="js/agregarEvento.js"></script>
   <script src="Boostrap-editable/js/bootstrap-editable.min.js"></script>

<style>
#firstname {
    background-color: #1C3E4D;
    border:2px solid #293D54;
    border-radius: 10px;
     margin: 0.2%;

}
#secondname {
    background-color:#C70039;
    border:2px solid black;
    border-radius: 10px;
     margin: 0.2%;
}
</style>

</head>

<body>

  <div class="container">
 <div class="row justify-content-start">

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
                            <input type='text' class='form-control' id='picker'/>
                     </div>
                 </div>
        </div>


        <div class='col-xs-2'>
            <button type="button" class="btn btn-primary" onClick='cambiarFecha(2)'>></button>
        </div>

      </div>  
<!--            Cronograma     --> 


<div class='row' id="evento">
  <div class='col-xs-12 col-sm-12' id="firstname">

    <div class="form-group">
        <select class="form-control" id="select" onchange="traer_datos()" style='height:40px;'>
          <option value ='0'>[Seleccione Recorrido...]</option>
          <?php


          $ok=$objcronograma->buscarRecorridos($con);
          while(($datos = mysqli_fetch_assoc($ok))>0){ 
          echo "
            <option value ='$datos[cod_des]'>$datos[descri]</option>
   
          ";}//while 
          ?>
        </select>
      </div>

  <div id="roca">
    <div class='col-xs-4 col-sm-2' id="secondname">
      <div class="col-xs-offset-11 col-md-offset-11">
        <div class='glyphicon glyphicon-remove' style='color:yellow' onclick="eliminar_col(-1)"></div>
      </div>
          <div class='row'>

            <div class='col-xs-12 col-sm-1'>
              <label for="appt-time">Tiempo</label>
              <input type="time" name="appt-time" id="time">
              <label for="vehiculo">Ruta: </label>
              <input type="text" name="vehiculo" id="vehiculo" maxlength="30" size="5">
              <div class='glyphicon glyphicon-plus' style='color:green' onclick="agregar_col(-1)"></div>
            </div>  

          </div>
    </div>
  </div>  
  
     <div id="roca0"></div>
     <div id="roca1"></div>
     <div id="roca2"></div>
     <div id="roca3"></div>
     <div id="roca4"></div>
  </div>
</div>


<div class="col-xs-12 col-sm-12" align="center">
  <button type="button" class="btn btn-primary btn-sm" onclick="guardar_evento()">Guardar Evento</button>
</div>


 </div>
</div>		
                   
<?php
           
          
          if (isset($_GET["editFecha"])) {

               $f   = $_GET["editFecha"];
               $cod = $_GET["cod_des"];
            
           echo " <script type='text/javascript'>
                        calendar1('$f',$cod);
                    </script>";
           
          }else {
            echo " <script type='text/javascript'>
                        calendar1(0,0);
                    </script>";

          }
?>



</body>
</html>