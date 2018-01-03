package com.prato.unet.gpstracker;

import android.content.Context;
import android.content.Intent;
import android.support.v4.content.WakefulBroadcastReceiver;

public class AlarmReceiver extends WakefulBroadcastReceiver{
    private static final String TAG = "AlarmReceiver";

    public void onReceive(Context context, Intent intent) {
        context.startService(new Intent(context, servicio.class));
    }

}
