//
// Source code recreated from a .class file by IntelliJ IDEA
// (powered by Fernflower decompiler)
//

package com.prato.unet.gpstracker;
//probando github1
import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.SystemClock;
import android.provider.Settings;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.GoogleApiAvailability;

import java.util.UUID;

public class MainActivity extends AppCompatActivity {
    private static final String TAG = "activity";


    //private static final int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;
    private Button boton;
    private TextView nombreMovil;
    private TextView cdcorta;
    private TextView creportado;
    private TextView alerta;
    private TextView alerta1;
    boolean activo=false;
    private String response = "vacio";
    String nombreAux = "vacio";
    boolean error = false;

    public class UpdateReceiver extends BroadcastReceiver {
        public UpdateReceiver() {
            super();
        }
        @Override
        public void onReceive(Context context, Intent intent1) {
            response = intent1.getStringExtra("data");
            SharedPreferences sharedPreferences = getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE);
            Editor editor = sharedPreferences.edit();
            cdcorta.setText(String.valueOf(sharedPreferences.getInt("DisCorta", 0)));
            if(activo && ("invalido".equals(response) || "usado".equals(response) )){
                Toast.makeText(context, response, Toast.LENGTH_LONG).show();
                activo = false; error = true;
                BotonEstado();
                cancelAlarmManager();
                if("invalido".equals(response)){alerta.setText(R.string.incorrecto);}
                if("usado".equals(response)){alerta.setText(R.string.usado);}
            }if(activo && "reportado".equals(response)){
                editor.putInt("reportado", sharedPreferences.getInt("reportado", 0) + 1);
                editor.apply();
                creportado.setText(String.valueOf(sharedPreferences.getInt("reportado", 0)));
            }
        }
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.setContentView(R.layout.activity_main);


        IntentFilter filter = new IntentFilter();
        filter.addAction("test.UPDATE");
        BroadcastReceiver receiver = new UpdateReceiver();
        registerReceiver(receiver, filter);

        //getSupportActionBar().setDisplayShowHomeEnabled(true);
        //getSupportActionBar().setLogo(R.mipmap.ic_launcher);
        //getSupportActionBar().setDisplayUseLogoEnabled(true);

        boton       = (Button)  findViewById(R.id.boton);
        nombreMovil = (TextView)findViewById(R.id.nombreMovil);
        cdcorta     = (TextView)findViewById(R.id.cdcorta);
        creportado  = (TextView)findViewById(R.id.creportado);
        alerta      = (TextView)findViewById(R.id.alerta);
        alerta1     = (TextView)findViewById(R.id.alerta1);



        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE );
        Editor editor = sharedPreferences.edit();
        boolean PrimeraVes = sharedPreferences.getBoolean("PrimeraVesID", true);

        if(PrimeraVes) {
            editor.putString("appID", UUID.randomUUID().toString());
            editor.putBoolean("PrimeraVesID",false);
            editor.apply();
        }

        this.boton.setOnClickListener(new OnClickListener() {
            public void onClick(View view) {
                MainActivity.this.BotonEmpezar();
            }
        });
        nombreMovil.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                if(activo){alerta1.setText(R.string.presionar);}
            }
        });
        creportado.setOnClickListener(new OnClickListener() {
            int borrarVariables = 0;
            @Override
            public void onClick(View view) {
               borrarVariables =borrarVariables+1;
               if(borrarVariables == 6){
                   SharedPreferences sharedPreferences = getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE);
                   Editor editor = sharedPreferences.edit();
                   editor.putInt("DisCorta", 0);
                   editor.putInt("reportado", 0);
                   editor.apply();
                   creportado.setText(String.valueOf(sharedPreferences.getInt("reportado", 0)));
                   cdcorta.setText(String.valueOf(sharedPreferences.getInt("DisCorta", 0)));
               }
            }
        });
    }

    protected void BotonEmpezar() {
        SharedPreferences sharedPreferences = getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE);
        Editor editor = sharedPreferences.edit();
        //editor.putInt("DisCorta", 0);
        //editor.putInt("reportado", 0);
        //editor.putFloat("distanciaTotal", 0.0F);
        alerta1.setText("");
       String NombreActual= nombreMovil.getText().toString().trim();

       if(!nombreAux.equals(NombreActual)){
           editor.putBoolean("primeraVezPosicion", true);
           error=false;
       }

        if(activo) {
                cancelAlarmManager();
                activo = false;
                BotonEstado();

            } else if("vacio".equals(response) || "reportado".equals(response) || !error)  {
            alerta.setText("");
                if(verificarInfo()) {
                    if (verificarGoogle()) {
                     startAlarmManager();
                     activo = true;
                     BotonEstado();
                   }
                }
            }
            editor.apply();
    }

    private boolean verificarInfo() {
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", Context.MODE_PRIVATE);
        Editor editor = sharedPreferences.edit();
        nombreAux = this.nombreMovil.getText().toString().trim();
        if(nombreAux.length() != 0 && !this.espacios(nombreAux)) {
            editor.putString("nombreRuta", this.nombreMovil.getText().toString().trim());
            editor.apply();
            return true;
        } else {
            Toast.makeText(this, "Nombre vacio o con espacios",Toast.LENGTH_SHORT).show();
            return false;
        }
    }

    private boolean espacios(String str) {
        return str.split(" ").length > 1;
    }

    private boolean verificarGoogle() {
        GoogleApiAvailability googleAPI = GoogleApiAvailability.getInstance();
        int result = googleAPI.isGooglePlayServicesAvailable(this);
        if(result != 0) {
            if(googleAPI.isUserResolvableError(result)) {
                googleAPI.getErrorDialog(this, result, 9000).show();
            }

            Log.e(TAG, "no hay conexion con los servicios de GooglePlay");
            Toast.makeText(this.getApplicationContext(), "ServicesGoogle No Disponible", Toast.LENGTH_SHORT).show();
            return false;
        } else {
            return true;
        }
    }

    private void BotonEstado() {
        if(activo) {
            this.boton.setText(R.string.Encendido);
            this.boton.setBackgroundColor(getResources().getColor(R.color.colorAccent));
        } else{
            this.boton.setText(R.string.Apagado);
            this.boton.setBackgroundColor(getResources().getColor(R.color.colorPrimary));
        }
    }

    private void startAlarmManager() {
        Log.d(TAG, "startAlarmManager");
        Context context = this.getBaseContext();
        AlarmManager alarmManager = (AlarmManager) context.getSystemService(Context.ALARM_SERVICE);
        Intent activityIntent = new Intent(context, AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, 0, activityIntent, 0);
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE );
        int minutos = sharedPreferences.getInt("Minutos", 1);
        assert alarmManager != null;
        alarmManager.setRepeating(AlarmManager.ELAPSED_REALTIME_WAKEUP, SystemClock.elapsedRealtime(), minutos * 60000, pendingIntent);
    }

    private void cancelAlarmManager() {
        Log.d(TAG, "cancelAlarmManager");
        Context context = this.getBaseContext();
        Intent gpsTrackerIntent = new Intent(context, AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, 0, gpsTrackerIntent, 0);
        AlarmManager alarmManager = (AlarmManager)context.getSystemService(Context.ALARM_SERVICE);
        assert alarmManager != null;
        alarmManager.cancel(pendingIntent);
    }
    @Override
    public void onResume() {
        Log.d(TAG, "onResume");
        super.onResume();

        LocationManager GPSStatus = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        assert GPSStatus != null;
        if (!GPSStatus.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setMessage("GPS Deshabilitado")
                    .setCancelable(false)
                    .setPositiveButton("Habilitar", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            Intent intent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                            startActivity(intent);
                        }
                    });
            AlertDialog alert = builder.create();
            alert.show();
        }

          SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", Context.MODE_PRIVATE);
          //minutos = sharedPreferences.getInt("Minutos", 1);
          nombreMovil.setText(sharedPreferences.getString("nombreRuta", ""));
          activo = sharedPreferences.getBoolean("activo", false);
          creportado.setText(String.valueOf(sharedPreferences.getInt("reportado", 0)));
          cdcorta.setText(String.valueOf(sharedPreferences.getInt("DisCorta", 0)));
          BotonEstado();
    }
    @Override
    protected void onStop() {
        super.onStop();
        Log.d(TAG, "onStop");
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE );
        Editor editor = sharedPreferences.edit();
        editor.putBoolean("activo",activo);
        editor.apply();
    }
    @Override
    protected void onDestroy(){
        super.onDestroy();
        Log.d(TAG, "onDestroy");

    }
}
