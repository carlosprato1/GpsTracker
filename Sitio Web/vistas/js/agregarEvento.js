var fechaActual = moment().format();

function cambiarFecha(boton){
  if (boton == 2) {
  	var nuevaFecha = moment(fechaActual, "YYYY-MM-DD").add(1,"days");
  }
   if (boton == 1) {
  	var nuevaFecha = moment(fechaActual, "YYYY-MM-DD").subtract(1,"days");
  }
  fechaActual = nuevaFecha;

$("#date1").data("DateTimePicker").date(nuevaFecha);
}


function calendar1(){

	 $(function () {
         $("#date1").datetimepicker({             
             format: 'DD/MM/YYYY',
             defaultDate: fechaActual
          });
     });


}

function agregar_col(num){

    for (var i = 0; i < 5; i++) {

      if ($("#roca"+i).text() == "")  {
          if(num == i-1){
    document.getElementById("roca"+i).innerHTML = "<div class='col-xs-4 col-sm-2' id='secondname'><div class='col-xs-offset-11 col-md-offset-11'><div class='glyphicon glyphicon-remove' style='color:yellow' onclick='eliminar_col("+i+")''></div></div><div class='row'><div class='col-xs-12 col-sm-1'><label for='appt-time'>Tiempo:</label><input type='time' name='appt-time' id='time"+i+"'><label for='vehiculo'>Ruta: </label><input type='text' name='vehiculo' id='vehiculo"+i+"'maxlength='50' size='5'><div class='glyphicon glyphicon-plus' style='color:green' onclick='agregar_col("+i+")'></div></div></div></div>";
      break;
         }
      }
    }
}
function eliminar_col(num){
    if (num == (-1)) {//borrar vehiculo y tiempo
      $("#time").val("");
      $("#vehiculo").val("");
      return;
    }

    document.getElementById("roca"+num).innerHTML = "";
}



//select,time,vehiculo

function guardar_evento(){
//'2018-01-21 00:00:00'

var band6 = false;
//original
  var cod_des =  $("#select").val();
  var time = $("#time").val();
  var vehiculo = $("#vehiculo").val();

  if (cod_des == 0) {alert("Seleccione Descripcion");return;}

 var fechaAux = moment(fechaActual, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');
 fechaAux = fechaAux.concat(" ");
 var timeAux  = time.concat(":00");
 var fechatime = fechaAux.concat(timeAux);

    $.ajax({
    async:  true, 
    type: "POST",
    url: "../controlador/cronograma.php",
    data: "&accion=eliminar_evento&fecha="+fechaAux+"&cod_des="+cod_des,
    dataType:"html",
    success: function(data){ 
 

      }//succes
     }); //ajax

  
  if (time == "") { 
      var dataAux = "&accion=agregar_evento&cod="+cod_des;
   }else{

  if (vehiculo == "") {vehiculo = "x";}
  var dataAux = "&accion=agregar_evento&cod="+cod_des+"&t="+fechatime+"&v="+vehiculo;
  band6 = true;

  }
  

// 0-4
   for (var i = 0; i < 5; i++) {
      if ($("#roca"+i).text() != "")  {

                time = $("#time"+i).val();
                vehiculo = $("#vehiculo"+i).val();


             if (time == "") {}else{
              band6 = true;

                 var fechaAux = moment(fechaActual, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');
                 fechaAux = fechaAux.concat(" ");
                 timeAux  = time.concat(":00");
                 fechatime = fechaAux.concat(timeAux);

              if (vehiculo == "") {vehiculo = "x";}
                dataAux = dataAux.concat("&t"+i+"="+fechatime+"&v"+i+"="+vehiculo);
              }   
      }
    }


if (band6) {
    $.ajax({
    async:  true, 
    type: "POST",
    url: "../controlador/cronograma.php",
    data: dataAux,
    dataType:"html",
    success: function(data){  
alert(data);
      }//succes
     }); //ajax

 }else{ alert("Evento Eliminado");}

}


function traer_datos(){

$( "#vehiculo" ).val("");
$( "#time" ).val("");

 for (var i = 0; i < 5; i++) {
    $( "#vehiculo"+i ).val("");
    $( "#time"+i ).val("");
   document.getElementById("roca"+i).innerHTML = "";
 
 }
  

 var cod_des =  $("#select").val();
 var fechaAux = moment(fechaActual, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');

    $.ajax({
    async:  true, 
    type: "POST",
    url: "../controlador/cronograma.php",
    data: "&accion=consulta_evento&cod_des="+cod_des+"&fecha="+fechaAux,
    dataType:"html",
    success: function(data){ 

       json  = eval("(" + data + ")");
       if (json == "nada") {return}

     for (var key in json) {

          if (key == 0 ){
            $("#time").val(moment(json[key].tiempo, 'YYYY-MM-DD HH:mm:ss').format('HH:mm'));//este formato esta en 12horas
            $("#vehiculo").val(json[key].vehiculo);
          }else{

            document.getElementById("roca"+(key-1)).innerHTML = "<div class='col-xs-4 col-sm-2' id='secondname'><div class='col-xs-offset-11 col-md-offset-11'><div class='glyphicon glyphicon-remove' style='color:yellow' onclick='eliminar_col("+(key-1)+")''></div></div><div class='row'><div class='col-xs-12 col-sm-1'><label for='appt-time'>Tiempo:</label><input type='time' name='appt-time' id='time"+(key-1)+"'><label for='vehiculo'>Ruta: </label><input type='text' name='vehiculo' id='vehiculo"+(key-1)+"'maxlength='50' size='5'><div class='glyphicon glyphicon-plus' style='color:green' onclick='agregar_col("+(key-1)+")'></div></div></div></div>";
            $("#time"+(key-1)).val(moment(json[key].tiempo, 'YYYY-MM-DD HH:mm:ss').format('HH:mm'));
            $("#vehiculo"+(key-1)).val(json[key].vehiculo);
          } 
          
          
     }

      }//succes
     }); //ajax



}