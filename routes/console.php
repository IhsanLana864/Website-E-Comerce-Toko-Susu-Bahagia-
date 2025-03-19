<?php
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('tes-schedule', function () {
    Log::info("Scheduler command dijalankan pada: " . now());
    $this->info("Scheduler command executed!");
})->describe('Command untuk testing schedule');
