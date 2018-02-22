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

$("#date").data("DateTimePicker").date(fechaActual);




}


function calendar(){

	 $(function () {
         $("#date").datetimepicker({             
             format: 'DD/MM/YYYY',
             defaultDate: fechaActual
          });
     });


$("#date").on("dp.change", function (e) {


  nocambie2_seguidos++;
if (nocambie2_seguidos != 1) { 

$("#roca").html( "");
fechaActual = e.date;
var fechaAux = moment(e.date, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');

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

                 $("#roca").append( "<div class='row' id='descripcion'><div class='col-xs-11 col-sm-11' id='arena"+id+"'><br><h4><a href='agregarEvento.php?editFecha="+fechaAux+"&cod_des="+json[key].fky_des+"' style='color:#043651'>"+json[key].descri+"</a> </h4></div></div>");
               }
               var docehoras = moment(json[key].tiempo, 'YYYY-MM-DD HH:mm:ss').format('h:mm a');

               $("#arena"+id).append("<div class='col-xs-4 col-sm-2'><h5>Hora: "+docehoras+"</h5><h5>Rutas: "+json[key].vehiculo+"</h5></div>");
               
               last = json[key].fky_des;
             }

             if (last != 678) {
         $("#roca").append( "<button type='button' class='btn btn-secondary' onClick='copiarSiguiente("+ '"' +fechaAux+ '"' +")' style='margin-top: 4%;'>Copiar para el dia siguiente</button>");
         $("#roca").append( "<br><button type='button' class='btn btn-secondary' onClick='copiarPara("+ '"' +fechaAux+ '"' +")' style='margin-top: 4%;'>Copiar para el dia ...</button>");
             }


           }//succes
        }); //ajax


}
     


    });


}
//no colocare el remove por fila en listarEvento
function copiarSiguiente(fechaCopiar){

         $.ajax({
         async:  true, 
         type: "POST",
         url: "../controlador/cronograma.php",
         data: "&accion=copiarASiguiente&fecha="+fechaCopiar,
         dataType:"html",
           success: function(data){ 

       
//alert(data);

           }//succes
        }); //ajax

 
}
function copiarPara (fechaCopiar){
   
var fechaEscogida = prompt("Por favor Introduce la Fecha (Ej. dd-mm-yyyy)", "");
    if (fechaEscogida == null || fechaEscogida == "" || fechaEscogida.length != 10) {

       return;
    } else {
     
  $.ajax({
         async:  true, 
         type: "POST",
         url: "../controlador/cronograma.php",
         data: "&accion=copiarASiguiente&fecha="+fechaCopiar+"&escogida="+fechaEscogida,
         dataType:"html",
           success: function(data){ 

           }//succes
        }); //ajax

    }

 



}
