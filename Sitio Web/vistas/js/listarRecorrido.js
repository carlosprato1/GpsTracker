function editar (cod_des){

}

function eliminar(cod_des){

	  $.ajax({
  async:  true, 
    type: "POST",
    url: "../controlador/cronograma.php",
    data: "&accion=eliminar_recorrido&cod_des="+cod_des,
  dataType:"html",
    success: function(data){ 
         location.reload();
    	  }//succes
  }); //ajax

}

function editar(cod_des){

$(document).ready(function() {

    $('#'+cod_des).editable();
});


}
function editarselect (cod_des){

  $(function(){
    $('#'+cod_des+'select').editable({
        value: 2,    
        source: [
              {value: 1, text: 'Foranea'},
              {value: 2, text: 'Urbana'}
           ]
    });
});
}

function editarselect1 (cod_des){
  $(function(){
    $('#'+cod_des+'estado').editable({
        value: 1,    
        source: [
              {value: 1, text: 'Activo'},
              {value: 2, text: 'Inactivo'}
           ]
    });
});

}