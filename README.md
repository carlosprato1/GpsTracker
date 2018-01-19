Rastrador o seguimiento GPS de Telefonos android por medio de una aplicacion Android y un sitio web.
  El seguimiento se hace de los datos obtenidos del GPS como velocidad, rumbo, coordenadas (altitud,latitud,altura)
  tiempo de la lectura.
  
  sitio web: http://www.pratowebhoster.hol.es/ 
 
caracteristicas del sitio web:

- uso de php7 y mysql.
- permite rastrear multiples aplicaciones android.
- uso de API de GoogleMaps para vizualizar las posiciones. permitiendo simular recorrido en intervalo de fechas y horas.
- registro de dispositivos Android asignando un "Nombre".

Caracteristicas de la aplicacion Android.

- Uso de Android Studio con Java.
- Uso del GPS (localizacion precisa)
- uso del servicio de google play location.
- uso de alarManager para programar intervalos de llamadas a la clase tipo service (que se ocupa de obtener la informacion del GPS   y enviarla al sitio web)
- uso de GET para enviar una cadena con la informacion del GPS.

- en caso que se pierda la conexion a internet se almacenan los datos del GPS en un sharedreference tipo String apoyandose en JSON.

- cuando se retoma la conexion a internet se envia la informacion almacenada (JSON) por el cuerpo de una petion HTTP (metodo POST)

- interfaz para agregar el "Nombre" del dispositivo previamente registrado en el sitio web (esto con la finalidad de llevar un       control desde el sitio web. como por ejemplo limitando el uso de la plataforma a cualquiera que tenga la aplicacion android,       evita multiples aplicaciones con el mismo nombre. etc).
