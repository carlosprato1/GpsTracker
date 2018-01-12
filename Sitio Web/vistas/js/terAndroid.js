function agregar_android(){

  var nombre_a = document.getElementById("nnombre_a").value;
  var telefono = document.getElementById("ntelefono").value;
 

if (nombre_a.length<3){  
    bootbox.alert({
    message: "Nombre Invalido.",
    size: 'small'});
     document.getElementById("nnombre_a").style.borderColor="#FF0000"
     document.getElementById("nnombre_a").focus()
     return
 }else{document.getElementById("nnombre_a").style.borderColor="#DCE4EC"}

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
    data: "&accion=agregar_android"+"&nombre_a="+nombre_a+"&telefono="+telefono,
	dataType:"html",
    success: function(data)
	{	
       alert(data)
       if(data.lenght==7){alert("Error: no se pudo almacenar los datos - verfique conexion a la red o sistema caido")}
        location.reload();

    }
	});	


}

function eliminar_android(ID_A){

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
            data: "&accion=eliminar_android"+"&ID_A="+ID_A,
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

function liberar_android(ID_A){

$.ajax({
            async:  true, 
            type: "POST",
            url: "../controlador/tabla_terminales.php",
            data: "&accion=liberar_android"+"&ID_A="+ID_A,
            dataType:"html",
         success: function(data)
            {   
               if(data.lenght==7){alert("Error: no se pudo almacenar los datos - verfique conexion a la red o sistema caido")}
               else{ bootbox.alert({message: "Liberado",size: 'small'});}
                
            }
}); //ajax

    
    

}
