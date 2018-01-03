package com.prato.unet.gpstracker;


import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.SystemClock;

public class bootReceiver extends BroadcastReceiver {
    private static final String TAG = "bootReceiver";
    @Override
    public void onReceive(Context context, Intent intent) {
        AlarmManager alarmManager = (AlarmManager)context.getSystemService(Context.ALARM_SERVICE);
        Intent gpsTrackerIntent = new Intent(context, AlarmReceiver.class);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, 0, gpsTrackerIntent, 0);

        SharedPreferences sharedPreferences = context.getSharedPreferences("com.prato.unet.gpstracker.prefs", Context.MODE_PRIVATE);
        int intervalInMinutes = sharedPreferences.getInt("Minutos", 1);
        Boolean currentlyTracking = sharedPreferences.getBoolean("activo", false);

        if (currentlyTracking) {
            alarmManager.setRepeating(AlarmManager.ELAPSED_REALTIME_WAKEUP,
                    SystemClock.elapsedRealtime(),
                    intervalInMinutes * 60000, // 60000 = 1 min
                    pendingIntent);
        } else {
            alarmManager.cancel(pendingIntent);
        }
    }
}
