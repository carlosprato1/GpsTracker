var fechaActual = moment().format();
var nocambie2_seguidos= 0;

function cambiarFecha(boton){
  if (boton == 2) {
    var nuevaFecha = moment(fechaActual, "YYYY-MM-DD").add(1,"days");
  }
   if (boton == 1) {
    var nuevaFecha = moment(fechaActual, "YYYY-MM-DD").subtract(1,"days");
  }
  fechaActual = nuevaFecha;

$("#date").data("DateTimePicker").date(nuevaFecha);




}


function calendar(){

	 $(function () {
         $("#date").datetimepicker({             
             format: 'DD/MM/YYYY',
             defaultDate: fechaActual
          });
     });


$("#date").on("dp.change", function (e) {
   $("#roca").html( "");
   var fechaAux = moment(fechaActual, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');

  nocambie2_seguidos++;
if (nocambie2_seguidos != 1) { 

  
       $.ajax({
         async:  true, 
         type: "POST",
         url: "../controlador/cronograma.php",
         data: "&accion=consulta_listar_evento&fecha="+fechaAux,
         dataType:"html",
           success: function(data){ 
            

          json  = eval("(" + data + ")");
          if (json == "nada") {
            $("#roca").html( " <h2>No hay Eventos Cargados</h2>");
            return;}

            var last =678;

             for (var key in json) {
              
               if (json[key].fky_des != last){
                var id = key;

                 $("#roca").append( "<div class='row' id='descripcion'><div class='col-xs-12 col-sm-12' id='arena"+id+"'><br><h4>"+json[key].descri+"</h4></div></div>");
               }
               var docehoras = moment(json[key].tiempo, 'YYYY-MM-DD HH:mm:ss').format('h:mm a');

               $("#arena"+id).append("<div class='col-xs-4 col-sm-2'><h5>Hora: "+docehoras+"</h5><h5>Rutas: "+json[key].vehiculo+"</h5></div>");
               
               last = json[key].fky_des;
             }


           }//succes
        }); //ajax

}
     


    });


}



