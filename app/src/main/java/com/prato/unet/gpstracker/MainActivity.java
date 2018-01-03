//
// Source code recreated from a .class file by IntelliJ IDEA
// (powered by Fernflower decompiler)
//

package com.prato.unet.gpstracker;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;
import android.os.SystemClock;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.GoogleApiAvailability;

import java.util.UUID;

public class MainActivity extends AppCompatActivity {
    private static final String TAG = "activity";

                                  
    //private static final int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;
    private Button boton;
    private boolean activo;
    private TextView nombreMovil;
    private TextView cdcorta;
    private TextView creportado;
    private int Minutos = 1;


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.setContentView(R.layout.activity_main);

        //getSupportActionBar().setDisplayShowHomeEnabled(true);
        //getSupportActionBar().setLogo(R.mipmap.ic_launcher);
        //getSupportActionBar().setDisplayUseLogoEnabled(true);

        this.boton = (Button)this.findViewById(R.id.boton);
        this.nombreMovil = (TextView)this.findViewById(R.id.nombreMovil);
        this.cdcorta = (TextView)this.findViewById(R.id.cdcorta);
        this.creportado = (TextView)this.findViewById(R.id.creportado);
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE );
        this.activo = sharedPreferences.getBoolean("activo", false);
        boolean PrimeraVes = sharedPreferences.getBoolean("PrimeraVes", true);
        if(PrimeraVes) {
            Editor editor = sharedPreferences.edit();
            editor.putBoolean("PrimeraVes", false);
            editor.putString("appID", UUID.randomUUID().toString());
            editor.apply();
        }

        this.boton.setOnClickListener(new OnClickListener() {
            public void onClick(View view) {
                MainActivity.this.BotonEmpezar(view);
            }
        });
    }

    protected void BotonEmpezar(View v) {
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE);
        Editor editor = sharedPreferences.edit();
        editor.putInt("DisCorta", 0);
        editor.putInt("reportado", 0);
        if(this.verificarInfo()) {
            if(this.verificarGoogle()) {
                if(this.activo) {
                    this.cancelAlarmManager();
                    this.activo = false;
                    editor.putBoolean("activo", false);
                    editor.putString("sessionID", "");
                } else {
                    this.startAlarmManager();
                    this.activo = true;
                    editor.putBoolean("activo", true);
                    editor.putFloat("distanciaTotal", 0.0F);
                    editor.putBoolean("firstTimeGettingPosition", true);
                    editor.putString("sessionID", UUID.randomUUID().toString());
                }

                editor.apply();
                this.BotonEstado();
            }
        }
    }

    private boolean verificarInfo() {
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", Context.MODE_PRIVATE);
        Editor editor = sharedPreferences.edit();
        String ruta = this.nombreMovil.getText().toString().trim();
        if(ruta.length() != 0 && !this.espacios(ruta)) {
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

            Log.e(TAG, "no hay cinexion con los servicios de GooglePlay");
            Toast.makeText(this.getApplicationContext(), "ServicesGoogle No Disponible", Toast.LENGTH_SHORT).show();
            return false;
        } else {
            return true;
        }
    }

    private void BotonEstado() {
        if(this.activo) {
            this.boton.setText(R.string.Encendido);
            this.boton.setBackgroundColor(getResources().getColor(R.color.colorPrimary));
        } else {
            this.boton.setText(R.string.Apagado);
            this.boton.setBackgroundColor(getResources().getColor(R.color.colorPrimaryDark));
        }
    }

    private void startAlarmManager() {
        Log.d(TAG, "startAlarmManager");
        Context context = this.getBaseContext();
        AlarmManager alarmManager = (AlarmManager) context.getSystemService(Context.ALARM_SERVICE);
        Intent activityIntent = new Intent(context, AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, 0, activityIntent, 0);
        SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs",Context.MODE_PRIVATE );
        this.Minutos = sharedPreferences.getInt("Minutos", 1);
        alarmManager.setRepeating(AlarmManager.ELAPSED_REALTIME_WAKEUP, SystemClock.elapsedRealtime(), Minutos * 60000, pendingIntent);
    }

    private void cancelAlarmManager() {
        Log.d(TAG, "cancelAlarmManager");
        Context context = this.getBaseContext();
        Intent gpsTrackerIntent = new Intent(context, AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, 0, gpsTrackerIntent, 0);
        AlarmManager alarmManager = (AlarmManager)context.getSystemService(Context.ALARM_SERVICE);
        alarmManager.cancel(pendingIntent);
    }
    @Override
    public void onResume() {
        Log.d(TAG, "onResume");
        super.onResume();
          SharedPreferences sharedPreferences = this.getSharedPreferences("com.prato.unet.gpstracker.prefs", Context.MODE_PRIVATE);
        //Minutos = sharedPreferences.getInt("Minutos", 1);
          nombreMovil.setText(sharedPreferences.getString("nombreRuta", ""));
          creportado.setText(String.valueOf(sharedPreferences.getInt("reportado", 0)));
          cdcorta.setText(String.valueOf(sharedPreferences.getInt("DisCorta", 0)));

        //BotonEstado();
    }
    @Override
    protected void onStop() {
        super.onStop();
    }
}
