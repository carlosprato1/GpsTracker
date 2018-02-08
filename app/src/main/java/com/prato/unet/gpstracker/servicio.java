package com.prato.unet.gpstracker;

import android.app.Service;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.location.Location;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.os.IBinder;
import android.support.v4.app.ActivityCompat;
import android.util.Log;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.GoogleApiClient.Builder;
import com.google.android.gms.common.api.GoogleApiClient.ConnectionCallbacks;
import com.google.android.gms.common.api.GoogleApiClient.OnConnectionFailedListener;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.TimeZone;
//probanco github1
public class servicio extends Service implements ConnectionCallbacks, OnConnectionFailedListener, LocationListener {
    private static final String TAG = "servicio";
    Location locationAux;
    String current = "";
    String current1 = "";
    String URL = "http://pratowebhoster.hol.es";
    //String URL = "http://192.168.1.4/interfaz";
    private boolean servicioActivo = false;//si llama sin ser cerrado no pasa de nuevo por aqui
    private LocationRequest locationRequest;
    private GoogleApiClient googleApiClient;
    float disulti = 0.0F;

    Float speed;
    Float precision;
    Double altitud;
    Float direccion;
    String telefonoId;
    String latitud;
    String longitud;
    String nombre;
    String fechaGPS;

    @Override
    public void onCreate() {
        super.onCreate();
        Log.e("servicio", "Oncreate");
    }
    @Override
    public int onStartCommand(Intent intent, int flags, int starId) {
        if(!this.servicioActivo) {
            this.servicioActivo = true;
            this.empezarEnviar();
        }

        return  START_NOT_STICKY;
    }

    private void empezarEnviar() {
        Log.e("servicio", "Empezar a enviar");
        GoogleApiAvailability googleAPI = GoogleApiAvailability.getInstance();
        int result = googleAPI.isGooglePlayServicesAvailable(this);
        if(result != 0) {
            Log.e("servicio", "servicio Google no disponible");
            Toast.makeText(this.getApplicationContext(), "ServicesGoogle No Disponible", Toast.LENGTH_SHORT).show();
        } else {
            this.googleApiClient = (new Builder(this)).addApi(LocationServices.API).addConnectionCallbacks(this).addOnConnectionFailedListener(this).build();
            if(!this.googleApiClient.isConnected() || !this.googleApiClient.isConnecting()) {
                this.googleApiClient.connect();
            }
        }

    }
    @Override
    public void onConnected(Bundle bundle) {
        Log.d(TAG, "onConnected");
        this.locationRequest = LocationRequest.create();
        this.locationRequest.setInterval(1000L);
        this.locationRequest.setFastestInterval(1000L);
        this.locationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        if(ActivityCompat.checkSelfPermission(this, "android.permission.ACCESS_FINE_LOCATION") == 0 || ActivityCompat.checkSelfPermission(this, "android.permission.ACCESS_COARSE_LOCATION") == 0) {
            LocationServices.FusedLocationApi.requestLocationUpdates(this.googleApiClient, this.locationRequest, this);
        }
    }
    @Override
    public void onLocationChanged(Location location) {
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", 0);
        Editor editor = sharedPreferences.edit();

        Log.d(TAG, "LocationChanged");
        if(location != null) {
            Log.e("servicio", " accuracy: " + location.getAccuracy());

            if(location.getAccuracy() < 60.0F ) {
                boolean primeraVezPosicion = sharedPreferences.getBoolean("primeraVezPosicion", true);


                if(primeraVezPosicion) {//no pedir posicion anterior
                    editor.putBoolean("primeraVezPosicion", false);
                    editor.apply();
                    this.stopLocationUpdates();
                    this.prepararHttpClient(location);
                    this.stopSelf();

                } else {
                    Location posicionAnterior = new Location("");
                    posicionAnterior.setLatitude((double)sharedPreferences.getFloat("latitudAnterior", 0.0F));
                    posicionAnterior.setLongitude((double)sharedPreferences.getFloat("LongitudAnterior", 0.0F));
                    this.disulti = location.distanceTo(posicionAnterior);
                    Log.d(TAG, " Distancia " + this.disulti);
                    if(this.disulti >= 17.0F) {

                        this.stopLocationUpdates();
                        this.prepararHttpClient(location);
                        this.stopSelf();

                    } else {
                        editor.putInt("DisCorta", sharedPreferences.getInt("DisCorta", 0) + 1);
                        editor.apply();
                        this.stopLocationUpdates();
                        this.stopSelf();

                        Intent intent1 = new Intent();
                        intent1.setAction("test.UPDATE");
                        getBaseContext().sendBroadcast(intent1);
                    }
                }
            }
        }

    }

    protected void prepararHttpClient(Location location) {
        locationAux = location;
        fechaGPS = "";
        final SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", 0);
        Editor editor = sharedPreferences.edit();
        SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss",java.util.Locale.getDefault());
        dateFormat.setTimeZone(TimeZone.getTimeZone("America/Caracas"));
        Date fecha = Calendar.getInstance().getTime(); // location.getTime() no es el current time del GPS

        try {
            fechaGPS = URLEncoder.encode(dateFormat.format(fecha), "UTF-8");
        } catch (UnsupportedEncodingException var19) {
            var19.printStackTrace();
        }

        editor.putFloat("latitudAnterior", (float)location.getLatitude());
        editor.putFloat("LongitudAnterior", (float)location.getLongitude());
        editor.apply();
        speed = location.getSpeed() * 3.6F; // m/s -> km/h
        precision = location.getAccuracy();
        altitud = location.getAltitude();
        direccion = location.getBearing();
        telefonoId = sharedPreferences.getString("appID", "");
        latitud = Double.toString(location.getLatitude());
        longitud = Double.toString(location.getLongitude());
        nombre = sharedPreferences.getString("nombreRuta", "sinNombre");
        final String URI =  "?s=" + speed + "&p=" + precision + "&a=" + altitud + "&r=" + direccion + "&l=" + latitud + "&i=" + telefonoId + "&o=" + longitud + "&d=" + this.disulti + "&n=" + nombre + "&f=" + fechaGPS;

        Thread thread = new Thread(new Runnable() {

            public void run() {

                ConnectivityManager connMgr = (ConnectivityManager)servicio.this.getSystemService(servicio.CONNECTIVITY_SERVICE);
                NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
                if(networkInfo != null && networkInfo.isConnected()) {
                    try {
                        URL e = new URL(servicio.this.URL + "/controlador/reporteAndroid.php" + URI);
                        HttpURLConnection urlConnection = (HttpURLConnection)e.openConnection();
                        InputStream in = urlConnection.getInputStream();
                        InputStreamReader isw = new InputStreamReader(in);

                        StringBuilder cadena = new StringBuilder();
                        for(int data = isw.read(); data != -1; data = isw.read()) {
                            cadena.append((char)data);
                        }
                        //servicio.this.current = servicio.this.current.replaceAll("\n", "");
                        current = cadena.toString().replaceAll("\n", "");
                        Log.d(TAG, "Respuesta del GET: " + servicio.this.current);
                        urlConnection.disconnect();

                        SharedPreferences sharedPreferences = getSharedPreferences("com.prato.unet.gpstracker.prefs", 0);

                  ///********REGRESO la Conexion*************



                        if (sharedPreferences.getBoolean("trackAlmacenadoAux",false)){
                            Log.e(TAG, "Regreso la Conexion");
                            Editor editor = sharedPreferences.edit();
                            editor.putBoolean("bloquearNombre", false);

                            URL e1 = new URL(servicio.this.URL + "/controlador/reporteJSON.php");
                            HttpURLConnection urlConnection1 = (HttpURLConnection)e1.openConnection();
                            urlConnection1.setDoOutput(true);
                            urlConnection1.setRequestMethod("POST");
                            urlConnection1.setRequestProperty("Content-Type", "application/json; charset=UTF-8");
                            urlConnection1.setRequestProperty("Accept", "application/json");
                            OutputStreamWriter streamWriter = new OutputStreamWriter(urlConnection1.getOutputStream());
                            streamWriter.write(sharedPreferences.getString("dataJSON",""));
                            streamWriter.flush();
//****Leer el response de la peticion POST
                            InputStream in1 = urlConnection1.getInputStream();
                            InputStreamReader isw1 = new InputStreamReader(in1);

                            StringBuilder cadena1 = new StringBuilder();
                            for(int data = isw1.read(); data != -1; data = isw1.read()) {
                                cadena1.append((char)data);
                            }
                            current1 = cadena1.toString().replaceAll("\n", "");
                            Log.d(TAG, "Respuesta del POST " + servicio.this.current1);

                            urlConnection.disconnect();


                            editor.putString("dataJSON","" ); //Borrar Despues de enviar
                            editor.putBoolean("trackAlmacenadoAux", false);
                            editor.apply();

                        }
                        ////****REGRESO la conexion**************
                        Editor editor = sharedPreferences.edit();
                        editor.apply();
                        Intent intent1 = new Intent();
                        intent1.putExtra("data", servicio.this.current);
                        intent1.setAction("test.UPDATE");
                        getBaseContext().sendBroadcast(intent1);

                    } catch (IOException var8) {
                        //error en servidor?
                        noConexion();
                        var8.printStackTrace();
                    }
                } else {
                   //no acceso a la red
                    noConexion();
                }

            }
        });
        thread.start();

    }
    @Override
    public void onConnectionFailed(ConnectionResult connectionResult) {
        this.stopLocationUpdates();
        this.stopSelf();
    }
    @Override
    public void onConnectionSuspended(int i) {
        Log.e(TAG, "GoogleApiClient connection has been suspend");
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
    }
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    private void noConexion(){

        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", 0);
        Editor editor = sharedPreferences.edit();
        //bloquear nombre si esta encendido hasta que regrese el internet.
        editor.putInt("cnointernet", sharedPreferences.getInt("cnointernet", 0)+1);
        editor.apply();

        Intent intent1 = new Intent();
        intent1.setAction("test.UPDATE");
        getBaseContext().sendBroadcast(intent1);

        if (sharedPreferences.getBoolean("activo",false) && !sharedPreferences.getBoolean("bloquearNombre",false)){
            editor.putBoolean("bloquearNombre", true);
            editor.apply();

        }


        Log.e(TAG, "No hay internet");
        //**********ESCRIBIR**************
        try {
            if (!sharedPreferences.getBoolean("trackAlmacenadoAux",false)) {//primera ves
                Log.e(TAG, "primera ves jsonarray");
                JSONArray jArray = new JSONArray();

                Log.e(TAG, " longitud: "+jArray.length());
                JSONObject track = new JSONObject();
                track.put("s", speed);
                track.put("p", precision);
                track.put("a", altitud);
                track.put("r", direccion);
                track.put("l", latitud);
                track.put("i", telefonoId);
                track.put("o", longitud);
                track.put("d", disulti);
                track.put("n", nombre);
                track.put("f", fechaGPS);
                jArray.put(track);
                editor.putString("dataJSON", jArray.toString());
                editor.putBoolean("trackAlmacenadoAux", true);
                editor.apply();
            }else{
                Log.e(TAG, "json array mas de un track");
                JSONArray jArray = new JSONArray(sharedPreferences.getString("dataJSON",""));
                if(jArray.length() > 1000){
                    Log.e(TAG, "cantidad maxima");
                    return;
                }
                Log.e(TAG, " longitud: "+jArray.length());
                JSONObject track = new JSONObject();
                track.put("s", speed);
                track.put("p", precision);
                track.put("a", altitud);
                track.put("r", direccion);
                track.put("l", latitud);
                track.put("i", telefonoId);
                track.put("o", longitud);
                track.put("d", disulti);
                track.put("n", nombre);
                track.put("f", fechaGPS);
                jArray.put(track);
                editor.putString("dataJSON", jArray.toString());
                editor.apply();
            }

        } catch(JSONException e) {
            e.printStackTrace();
        }
    }

    private void stopLocationUpdates() {
        if(this.googleApiClient != null && this.googleApiClient.isConnected()) {
            this.googleApiClient.disconnect();
        }

    }
}
