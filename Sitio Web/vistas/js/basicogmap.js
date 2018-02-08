//*********variables globales***////////////////////
  var fechaActual = moment().format();
  var key;
  var max;
  var pause = false;
  var json_rReanudar
  var ID_AReanudar
  var maxReanudar
  var map; //se guarda el mapa.
  var markers = [];//este vector simplemente es para volver a aparecer los puntos en un futuro.
  var json;
  //var info;
  var titulo;
  var ya_infowindow = null;
  var direccion = 0;
  var speed = 0;
//////****************/////////////////////
function initMap() {

     var a = {lat: 7.78706, lng: -72.21060};
     map = new google.maps.Map(document.getElementById('map'), {
     zoom: 12,
     center: a
  });

}//initmap
//*************Colocar la Direccion IP del Servidor***************
 var baseimagen= 'http://www.pratowebhoster.hol.es/vistas/imagenes/';
        var icons = {
          speedCero: {
            icon: baseimagen + 'circuloTrans.png'
          },
          dir0: {
            icon: baseimagen + 'flecha0.png'
          },
          dir22: {
            icon: baseimagen + 'flecha22.png'
          },
           dir45: {
            icon: baseimagen + 'flecha45.png'
          },
           dir67: {
            icon: baseimagen + 'flecha67.png'
          },
           dir90: {
            icon: baseimagen + 'flecha90.png'
          },
           dir112: {
            icon: baseimagen + 'flecha112.png'
          },
           dir135: {
            icon: baseimagen + 'flecha135.png'
          },
           dir157: {
            icon: baseimagen + 'flecha157.png'
          },
           dir180: {
            icon: baseimagen + 'flecha180.png'
          },
           dir202: {
            icon: baseimagen + 'flecha202.png'
          },
           dir225: {
            icon: baseimagen + 'flecha225.png'
          },
           dir247: {
            icon: baseimagen + 'flecha247.png'
          },
           dir270: {
            icon: baseimagen + 'flecha270.png'
          },
           dir292: {
            icon: baseimagen + 'flecha292.png'
          },
           dir315: {
            icon: baseimagen + 'flecha315.png'
          },
           dir337: {
            icon: baseimagen + 'flecha337.png'
          }
        };

function addMarker(coordenada,info){

  if(speed == "0.000"){tipo = "speedCero";  }
  else{
    if(direccion == null || direccion == 0.0 ){tipo = "speedCero";}
    if((direccion >0 && direccion<=11.2) || (direccion > 348.7 && direccion<360)){tipo = "dir0";}
    if(direccion > 11.2 && direccion<=33.7){tipo = "dir22";}
    if(direccion > 33.7 && direccion<=56.2){tipo = "dir45";}
    if(direccion > 56.2 && direccion<=78.7){tipo = "dir67";}
    if(direccion > 78.7 && direccion<=101.2){tipo = "dir90";}
    if(direccion > 101.2 && direccion<=123.7){tipo = "dir112";}
    if(direccion > 123.7 && direccion<=146.2){tipo = "dir135";}
    if(direccion > 146.2 && direccion<=168.7){tipo = "dir157";}
    if(direccion > 168.7 && direccion<=191.2){tipo = "dir180";}
    if(direccion > 191.2 && direccion<=213.7){tipo = "dir202";}
    if(direccion > 213.7 && direccion<=236.2){tipo = "dir225";}
    if(direccion > 236.2 && direccion<=258.7){tipo = "dir247";}
    if(direccion > 258.7 && direccion<=281.2){tipo = "dir270";}
    if(direccion > 281.2 && direccion<=303.7){tipo = "dir292";}
    if(direccion > 303.7 && direccion<=326.2){tipo = "dir315";}
    if(direccion > 326.2 && direccion<=348.7){tipo = "dir337";}
  }
    
     var marker = new google.maps.Marker({//agrega un marcador en el mapa
     position: coordenada,
     map: map,
    title: titulo,
    icon: icons[tipo].icon
  });
 
      marker.addListener('click', function() {//guarda las variables del click cuando corre.
       infowindow = new google.maps.InfoWindow({
          content: info
       });
       if (ya_infowindow != null) {ya_infowindow.close();}
          infowindow.open(map, marker);
          ya_infowindow=infowindow;
    });

       markers.push(marker);//agrega al final
  
}



function recorrer_markers(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
}

function ultimo_todos(band){
 stop();

  $.ajax({
  async:  true, 
    type: "POST",
    url: "../controlador/reportes.php",
    data: "&accion=ultimo_todos",
  dataType:"html",
    success: function(data){ 
      //alert(data);
     json  = eval("(" + data + ")");  

    if (json == "nada") {return}

     for (var key in json) {
   
        var coor =  {lat: parseFloat(json[key].latitud), lng: parseFloat(json[key].longitud)};
    //json toma los key del primer registro y le da los mismo valores a los demas key (ID_A,longitud).
    //el ID_T de los tk los puede tomar como ID_A.

        titulo     = $("#"+json[key].ID_A).text();

        var info = "<h4>"+titulo+"</h4>"+"Fecha: "+json[key].TimeGPS+"<br>Velocidad: "+json[key].speed+" m/s<br>Altitud: "+json[key].altitud+" m"+"<br>Distancia: "+json[key].disUlt+" m"+"<br>Precision: "+json[key].error;
        if(json[key].altitud==null){
          info = info.replace("<br>Altitud: undefined m","");
        }
        if(json[key].disUlt==null){
          info = info.replace("<br>Distancia: undefined m","");
        }
        if(json[key].error==null){
          info = info.replace("<br>Precision: undefined","");
        }
        direccion = parseFloat(json[key].direccion);
        speed = json[key].speed;
           addMarker(coor,info);
         
     }//for

    }//succes
  }); //ajax

}//function

//para luego: actualizar el tiempo real cada 1min.

//hora 1: 19:00:00  hora2: 00:00:00  date:25/01/2018
function recorridoAndroid(ID_A){



hora1 = $("#ahora1"+ID_A).data("DateTimePicker").date().format("HH:mm:ss").substr(0,2);
hora2 = $("#ahora2"+ID_A).data("DateTimePicker").date().format("HH:mm:ss").substr(0,2);
date  = $("#adate"+ID_A).data("DateTimePicker").date().format();


if (parseInt(hora2) >= parseInt(hora1)){bootbox.alert({
                       message: "Hora 1 debe ser mayor a hora 2",
                       size: 'small'});
                       return}



  $.ajax({
  async:  true, 
    type: "POST",
    url: "../controlador/reportes.php",
    data: "&accion=recorrido&h1="+hora2+"&h2="+hora1+"&date="+date+"&ID_A="+ID_A,
  dataType:"html",
    success: function(data){ 
 
     json_r  = eval("(" + data + ")");
     if (json_r == "nada") {bootbox.alert({
                            message: "No Hay Recorridos",
                            size: 'small'});
                            return}




    if (key<max){return}  
     pause = false;                    
 key=0;
 max = json_r.length;  
recorrer_markers(null);//limpiar mapa
markers = [];//borrar vector
 punto_timerAndroid(json_r,ID_A);

    }//succes
  }); //ajax
}

function punto_timerAndroid(json_r,ID_A){
  var coor =  {lat: parseFloat(json_r[key].latitud), lng: parseFloat(json_r[key].longitud)};
 
  var info = "<h4>"+titulo+"</h4>"+json_r[key].TimeGPS;

        titulo     = $("#"+ID_A).text();
     
        var info = "<h4>"+titulo+"</h4>"+"Fecha: "+json_r[key].TimeGPS+"<br>Velocidad: "+json_r[key].speed+" m/s<br>Altitud: "+json_r[key].altitud+" m"+"<br>Distancia: "+json_r[key].disUlt+" m"+"<br>Precision: "+json_r[key].error;
        if(json_r[key].altitud==null){
          info = info.replace("<br>Altitud: undefined m","");
        }
        if(json_r[key].disUlt==null){
          info = info.replace("<br>Distancia: undefined m","");
        }
        if(json_r[key].error==null){
          info = info.replace("<br>Precision: undefined","");
        }
        direccion = parseFloat(json_r[key].direccion);
        speed = json_r[key].speed;
        addMarker(coor,info);


 setTimeout(function() {
    key++;
    if (key >= max) {return}

    if (pause) {
   json_rReanudar = json_r
   ID_AReanudar   = ID_A 
   maxReanudar    = max
      return}

    punto_timerAndroid(json_r,ID_A);
  },1000);
}

 function pause1(){

    pause = !pause;
    if (!pause){punto_timerAndroid(json_rReanudar,ID_AReanudar,maxReanudar);}
  }

function stop(){
  key = max;
  recorrer_markers(null);//limpiar mapa
  markers = [];//borrar vector
}

function calendar(ID_A){


    $(function () {
         $("#adate"+ID_A).datetimepicker({             
             format: 'DD/MM/YYYY',
             defaultDate: fechaActual
          });
     });

    $(function () {
          $("#ahora1"+ID_A).datetimepicker({             
             format : 'hh a',
             defaultDate: fechaActual
          });
    });

    $(function () {
          $("#ahora2"+ID_A).datetimepicker({             
             format: 'hh a',
             defaultDate: '2018-01-21 00:00:00'
          });
    });
//*******************************************************************************
//Avento al cambiar la fecha del Date, se queria deshabilitar dias o traer una marca
 // para saber automaticamente si hay recorridos en el dia seleccionado.
    /*$("#adate"+ID_A).on('dp.change', function(e){ 
        $.ajax({
         async:  true, 
         type: "POST",
         url: "../controlador/reportes.php",
         data: "&accion=diasActivos",
         dataType:"html",
           success: function(data){ 
           //alert(data);
           //json  = eval("(" + data + ")"); 

           }//succes
        }); //ajax
    })*/
     //disabledDates: [moment("12/25/2013"),moment("12/25/2013")]
///////////*******************************************************************
 }