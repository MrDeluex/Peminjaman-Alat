<?php

use App\Models\LogAktivitas;
use Carbon\Carbon;

if (!function_exists('logAktivitas')) {
    function logAktivitas($aktivitas)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'waktu' => Carbon::now(),
        ]);
    }
}
