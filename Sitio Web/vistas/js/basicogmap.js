//variables globales
  var map; //se guarda el mapa.
  var markers = [];//este vector simplemente es para volver a aparecer los puntos en un futuro.
  var json;
  //var info;
  var titulo;
  var ya_infowindow = null;
  var direccion = 0;
  var speed = 0;

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

  if(speed == "0"){tipo = "speedCero";  }
  else{
    if(direccion == null){tipo = "speedCero";}
    if((direccion >=0 && direccion<=11.2) || (direccion > 348.7 && direccion<360)){tipo = "dir0";}
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
  recorrer_markers(null);//limpiar mapa
  markers = [];//borrar vector

  $.ajax({
  async:  true, 
    type: "POST",
    url: "../controlador/reportes.php",
    data: "&accion=ultimo_todos",
  dataType:"html",
    success: function(data){ 
     json  = eval("(" + data + ")");  
     for (var key in json) {
   
        var coor =  {lat: parseFloat(json[key].latitud), lng: parseFloat(json[key].longitud)};
    //json toma los key del primer registro y le da los mismo valores a los demas key (ID_A,longitud).
    //el ID_T de los tk los puede tomar como ID_A.

        titulo     = $("#"+json[key].ID_A).text();
        if (json[key].ID_A == null ){
          titulo     = $("#"+json[key].ID_T).text();
        }

        if(json[key].speed=="1" || json[key].speed =="2"){
          json[key].speed = "0";
        }
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
         

     }
    }//succes
  }); //ajax

}//function

//para luego: actualizar el tiempo real cada 1min.
//para luego: en el caso de ver que se actualice un solo terminal, llenar una variable global "ID_T" en escoger() para que
//ultimos_todos() sepa que se estaba mostrando ese terminal, buscarlo y colocarlo.
//para luego: traer del boton una bandera para que si se una ignorar 1 terminal y mostrarlos todos.
//para luego: crear linea con flechas en recorridos
//para luego:traer speed otros datos que se desea saber.
function escoger(ID_T){
    for (var key in json) { 
      if (parseInt(json[key].ID_T)==ID_T){
           recorrer_markers(null);
           markers = [];
           var coor =  {lat: parseFloat(json[key].latitud), lng: parseFloat(json[key].longitud)};
           titulo     = $("#"+json[key].ID_T).text();
           var info = "<h4>"+titulo+"</h4>"+json[key].TimeGPS;
      
           addMarker(coor,info);
       
      }  
  }
 
}//escoger

function recorridoTk(ID_T){

hora1 = $("#hora1"+ID_T).val();
hora2 = $("#hora2"+ID_T).val();
date  = $("#date"+ID_T).val();

if (date==""){bootbox.alert({
              message: "Ingrese la Fecha",
              size: 'small'});
              return}
if (hora2=="0") {hora2="23"}

if (parseInt(hora1) >= parseInt(hora2)){bootbox.alert({
                       message: "Hora 1 tiene que ser menor a hora 2",
                       size: 'small'});
                       return}

recorrer_markers(null);//limpiar mapa
markers = [];//borrar vector

  $.ajax({
  async:  true, 
    type: "POST",
    url: "../controlador/reportes.php",
    data: "&accion=recorrido&h1="+hora1+"&h2="+hora2+"&date="+date+"&ID_T="+ID_T+"&tipo=1",
  dataType:"html",
    success: function(data){ 
alert(data);
     json_r  = eval("(" + data + ")");
     if (json_r == "nada") {bootbox.alert({
                            message: "No Hay Recorridos",
                            size: 'small'});
                            return}
 var key=0;
 var max = json_r.length;  
 
 punto_timer(json_r,key,ID_T,max);

    }//succes
  }); //ajax
}

function recorridoAndroid(ID_A){

hora1 = $("#ahora1"+ID_A).val();
hora2 = $("#ahora2"+ID_A).val();
date  = $("#adate"+ID_A).val();

if (date==""){bootbox.alert({
              message: "Ingrese la Fecha",
              size: 'small'});
              return}
if (hora2=="0") {hora2="23"}

if (parseInt(hora1) >= parseInt(hora2)){bootbox.alert({
                       message: "Hora 1 tiene que ser menor a hora 2",
                       size: 'small'});
                       return}

recorrer_markers(null);//limpiar mapa
markers = [];//borrar vector

  $.ajax({
  async:  true, 
    type: "POST",
    url: "../controlador/reportes.php",
    data: "&accion=recorrido&h1="+hora1+"&h2="+hora2+"&date="+date+"&ID_T="+ID_A+"&tipo=2",
  dataType:"html",
    success: function(data){ 
 
     json_r  = eval("(" + data + ")");
     if (json_r == "nada") {bootbox.alert({
                            message: "No Hay Recorridos",
                            size: 'small'});
                            return}
 var key=0;
 var max = json_r.length;  
 
 punto_timerAndroid(json_r,key,ID_A,max);

    }//succes
  }); //ajax
}

function punto_timerAndroid(json_r,key,ID_T,max){//cree esta funcion solo por no haber cambiado la palabra longuitud del TK
  var coor =  {lat: parseFloat(json_r[key].latitud), lng: parseFloat(json_r[key].longitud)};
 
  var info = "<h4>"+titulo+"</h4>"+json_r[key].TimeGPS;

        titulo     = $("#"+ID_T).text();
        if(json_r[key].speed=="1" || json_r[key].speed =="2"){
          json_r[key].speed = "0";
        }
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
    punto_timerAndroid(json_r,key,ID_T,max);
  },1000);
}



function punto_timer(json_r,key,ID_T,max){
  var coor =  {lat: parseFloat(json_r[key].latitud), lng: parseFloat(json_r[key].longitud)};
  titulo   = $("#"+ID_T).text();
  var info = "<h4>"+titulo+"</h4>"+json_r[key].TimeGPS;
  addMarker(coor,info);

 setTimeout(function() {
    key++;
    if (key >= max) {return}
    punto_timer(json_r,key,ID_T,max);
  },1000);
}
