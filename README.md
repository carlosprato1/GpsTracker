seguimiento GPS de Telefonos android.
  
  sitio web: http://www.pratowebhoster.hol.es/ 
 
caracteristicas del sitio web:

- uso de php7 y mysql.
- Rastrea multiples telefonos android
- uso de API de GoogleMaps para vizualizar las posiciones simulando recorridos.
- previo registro de los telefonos Android por "nombre"

Caracteristicas de la aplicacion Android.

- Android Studio, Java.
- GPS (localizacion precisa)
- servicio de google play location.
- alarManager para programar intervalos de llamadas a la clase tipo service (que se ocupa de obtener la informacion del GPS y enviarla al sitio web)
- HTTP GET para enviar la cadena con la informacion del GPS.
- respalda datos del gps cuando no hay conexion para luego enviarlos al servidor por HTTP POST
- interfaz para encender/apagar y asignar "nombre"