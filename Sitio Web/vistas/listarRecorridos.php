<?php

require("../clases/cronograma.class.php");
require("../clases/cronoUtilidades.class.php");

$objcronograma = new cronograma;
$objUtilities = new utilidades;

$con=$objUtilities->conexion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="Boostrap-editable/css/bootstrap-editable.css">
	<title>Recorridos</title>
	<script src="js/listarRecorrido.js" language="javascript" type="text/javascript"></script>
	<script src="Bootstrap/jquery-3.1.1.min.js"></script>
  
</head>
<body>
	
<div class="container">

  <div class="row align-items-center">

    
        <div class='row top-buffer'>
          <div  class='col-xs-12 col-sm-12'>
            <h4>Recorridos</h4>
          </div>
        </div>   

        <div class='row'>
          <div class='col-xs-1 col-sm-1'>
            <span></span>
          </div>
           <div class='col-xs-3 col-sm-4'>
            <h5>Descripcion</h5>
          </div>
          <div class='col-xs-2 col-sm-2'>
            <h5>Tipo</h5>
          </div>
          <div class='col-xs-2 col-sm-1'>
            <h5>Estado</h5>
          </div>
           <div class='col-xs-2 col-sm-1'>
            <span></span>
          </div>
          
        </div>  

          
     
   <?php 
        $ban=false;
        $tipo="Foranea"; $estado = "Activo";
$ok=$objcronograma->buscarRecorridos($con);
    while(($datos = mysqli_fetch_assoc($ok))>0){ 
      $ban=true;
      if ($datos["tipo"] == "f") { $tipo = "Foranea";} else{$tipo = "Urbana";}
      if ($datos["est_des"] == "i") { $estado = "Inactivo";} else{$estado = "Activo";}

 echo " 
    <div class='row top-buffer'>
          <div class='col-xs-2 col-sm-1'>
            <span></span>
          </div>

       <div class='col-xs-2 col-sm-4'>

       <a href='#' id='$datos[cod_des]' data-type='text' data-pk='editar_recorrido' data-url='../controlador/cronograma.php' data-title='Descripcion'>$datos[descri]</a>
          <script type='text/javascript'>editar($datos[cod_des])</script>

       </div>
       
       <div class='col-xs-2 col-sm-2'> 
     <a href='#' id='$datos[cod_des]select' data-type='select' data-pk='editar_recorrido1' data-url='../controlador/cronograma.php' data-title='Tipo'>$tipo</a>
           <script type='text/javascript'>editarselect($datos[cod_des])</script>
       </div>

       <div class='col-xs-2 col-sm-1'>  
        <a href='#' id='$datos[cod_des]estado' data-type='select' data-pk='editar_recorrido2' data-url='../controlador/cronograma.php' data-title='Estado'>$estado</a>
           <script type='text/javascript'>editarselect1($datos[cod_des])</script>

       </div>

          <div class='col-xs-2 col-sm-1'>
            <span class='glyphicon glyphicon-remove' style='color:red' onClick='eliminar($datos[cod_des])'></span>
          </div>
       </div>";

        }//while
        if (!$ban) { echo "<tr><td>No hay Recorridos Registrados</td></tr>";}
      ?>
 

<div align="center">
  <div><br></div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Agregar Recorrido
</button>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Recorrido</h4>
      </div>
      <div class="modal-body">
        

  <div class="container">

 
     <form method="POST" action="../controlador/cronograma.php" name="formulario" id="formulario">
      <input type="hidden" name="accion" value="add_recorrido"> 
  <fieldset>
 
<div class="form-group col-sm-6">

  <label class="col-form-label" for="inputDefault">Descripcion</label>
  <input type="text" class="form-control" name="recoDescri" placeholder="Nombre.   Salida:          llegada:" id="descrip" maxlength="50">
</div>

<div class="col-sm-7">
    <fieldset class="form-group">
      <legend>Tipo de recorrido</legend>
      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="tipoR" id="foranea" value="f" checked="">
          Foranea
        </label>
      </div>
      <div class="form-check">
      <label class="form-check-label">
          <input type="radio" class="form-check-input" name="tipoR" id="urbana" value="u">
          Urbana
        </label>
      </div>
    </fieldset>
</div>

    

<div class="col-sm-7">
        <fieldset class="form-group">
       <legend>Estado</legend>
        <div class="form-check">
         <label class="form-check-label">
          <input type="radio" class="form-check-input" name="estadoR" id="activo" value="a" checked="">
          Activo
          </label>
          </div>
        <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="estadoR" id="inactivo" value="i">
          Inactivo
        </label>
      </div>
      </fieldset>
</div>
<div class="col-sm-7">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
</div>  
  </fieldset>

</form>



    
</div>



      </div>

    </div>
  </div>
</div>

</div>
</div>






<script src="Bootstrap/bootstrap.min.js"></script>
<script src="Boostrap-editable/js/bootstrap-editable.min.js"></script>
</body>
</html>