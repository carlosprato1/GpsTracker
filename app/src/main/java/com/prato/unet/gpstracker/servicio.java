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

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.TimeZone;
//probanco github
public class servicio extends Service implements ConnectionCallbacks, OnConnectionFailedListener, LocationListener {
    private static final String TAG = "servicio";
    String current = "";
    String URL = "http://pratowebhoster.hol.es/controlador/reporteAndroid.php";
    private boolean servicioActivo = false;//si llama sin ser cerrado no pasa de nuevo por aqui
    private LocationRequest locationRequest;
    private GoogleApiClient googleApiClient;
    float disulti = 0.0F;
    float distanciaTotal = 0.0F;
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
            if(location.getAccuracy() < 100.0F) {
                boolean primeraVezPosicion = sharedPreferences.getBoolean("primeraVezPosicion", true);
                if(primeraVezPosicion) {//no pedir posicion anterior
                    editor.putBoolean("primeraVezPosicion", false);
                    this.stopLocationUpdates();
                    this.prepararHttpClient(location);
                    editor.apply();
                } else {
                    Location posicionAnterior = new Location("");
                    posicionAnterior.setLatitude((double)sharedPreferences.getFloat("latitudAnterior", 0.0F));
                    posicionAnterior.setLongitude((double)sharedPreferences.getFloat("LongitudAnterior", 0.0F));
                    this.disulti = location.distanceTo(posicionAnterior);
                    Log.d(TAG, " Distancia " + this.disulti);
                    if(this.disulti >= 18.0F) {
                        this.distanciaTotal += this.disulti;
                        this.stopLocationUpdates();
                        this.prepararHttpClient(location);
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
        String fechaGPS = "";
        final SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", 0);
        Editor editor = sharedPreferences.edit();
        SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss",java.util.Locale.getDefault());
        dateFormat.setTimeZone(TimeZone.getDefault());
        Date fecha = new Date(location.getTime());

        try {
            fechaGPS = URLEncoder.encode(dateFormat.format(fecha), "UTF-8");
        } catch (UnsupportedEncodingException var19) {
            var19.printStackTrace();
        }

        this.distanciaTotal = sharedPreferences.getFloat("distanciaTotal", 0.0F);
        editor.putFloat("distanciaTotal", this.distanciaTotal);
        editor.putFloat("latitudAnterior", (float)location.getLatitude());
        editor.putFloat("LongitudAnterior", (float)location.getLongitude());
        editor.apply();
        String metodo = location.getProvider();
        float speed = location.getSpeed();
        float precision = location.getAccuracy();
        Double altitud = location.getAltitude();
        Float direccion = location.getBearing();
        String sesionId = sharedPreferences.getString("userName", "");
        String telefonoId = sharedPreferences.getString("appID", "");
        String latitud = Double.toString(location.getLatitude());
        String longitud = Double.toString(location.getLongitude());
        String nombre = sharedPreferences.getString("nombreRuta", "sinNombre");
        final String URI = "?m=" + metodo + "&s=" + speed + "&p=" + precision + "&a=" + altitud + "&r=" + direccion + "&e=" + sesionId + "&l=" + latitud + "&i=" + telefonoId + "&o=" + longitud + "&t=" + this.distanciaTotal + "&d=" + this.disulti + "&n=" + nombre + "&f=" + fechaGPS;

        Thread thread = new Thread(new Runnable() {


            public void run() {
                ConnectivityManager connMgr = (ConnectivityManager)servicio.this.getSystemService(servicio.CONNECTIVITY_SERVICE);
                NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
                if(networkInfo != null && networkInfo.isConnected()) {
                    try {
                        URL e = new URL(servicio.this.URL + "/interfaz/controlador/reporteAndroid.php" + URI);
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


                        Intent intent1 = new Intent();
                        intent1.putExtra("data", servicio.this.current);
                        intent1.setAction("test.UPDATE");
                        getBaseContext().sendBroadcast(intent1);


                    } catch (IOException var8) {
                        Log.d(TAG, "No se pudo conectar con el Servidor");
                        var8.printStackTrace();
                    }
                } else {
                    Log.d(TAG, "No hay internet");
                }

            }
        });
        thread.start();
        this.stopSelf();
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

    private void stopLocationUpdates() {
        if(this.googleApiClient != null && this.googleApiClient.isConnected()) {
            this.googleApiClient.disconnect();
        }

    }
}
