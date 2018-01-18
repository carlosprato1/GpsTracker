function agregar_terminal(){

  var imei     = document.getElementById("nimei").value;
  var nombre_t = document.getElementById("nnombre_t").value;
  var telefono = document.getElementById("ntelefono").value;
 
 if (imei.length<15) {
    bootbox.alert({
    message: "Ingrese un IMEI valido.",
    size: 'small'});
     document.getElementById("nimei").style.borderColor="#FF0000"
     document.getElementById("nimei").focus()
     return
 }else{document.getElementById("nimei").style.borderColor="#DCE4EC"}

if (nombre_t.length<3){  
    bootbox.alert({
    message: "Nombre Invalido.",
    size: 'small'});
     document.getElementById("nnombre_t").style.borderColor="#FF0000"
     document.getElementById("nnombre_t").focus()
     return
 }else{document.getElementById("nnombre_t").style.borderColor="#DCE4EC"}

if (telefono.length<3){
    bootbox.alert({
    message: "Telefono Invalido.",
    size: 'small'}); 
     document.getElementById("ntelefono").style.borderColor="#FF0000"
     document.getElementById("ntelefono").focus()
     return
 }else{document.getElementById("ntelefono").style.borderColor="#DCE4EC"}



$.ajax({
	async:	true, 
    type: "POST",
    url: "../controlador/tabla_terminales.php",
    data: "&accion=agregar_terminal"+"&imei="+imei+"&nombre_t="+nombre_t+"&telefono="+telefono,
	dataType:"html",
    success: function(data)
	{	

       if(data.lenght==7){alert("Error: no se pudo almacenar los datos - verfique conexion a la red o sistema caido")}
        location.reload();

    }
	});	


}

function eliminar_terminal(ID_T){

bootbox.confirm({
    title: "¿Esta seguro?",
    message: "Se borrara permanentemente todos los registros del terminal como el historial de ubicaciones.",
    buttons: {
         confirm: {
            label: 'Si',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {

        if (result) {

            $.ajax({
            async:  true, 
            type: "POST",
            url: "../controlador/tabla_terminales.php",
            data: "accion=eliminar_terminal"+"&ID_T="+ID_T,
            dataType:"html",
         success: function(data)
            {   
                
               if(data.lenght==7){alert("Error: no se pudo almacenar los datos - verfique conexion a la red o sistema caido")}
                location.reload();
            }
            }); //ajax
        }//if
        
    }//calback
});//bootbox



}//function
