<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Rekap bulanan otomatis: setiap tanggal 1 jam 01:00 dini hari
Schedule::command('rekap:bulanan')->monthlyOn(1, '01:00')->withoutOverlapping()->runInBackground();

// Notifikasi harian KIA: setiap hari jam 07:00 pagi
Schedule::command('notif:cek-harian')->dailyAt('07:00')->withoutOverlapping()->runInBackground();
