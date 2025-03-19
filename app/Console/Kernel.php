<?php

namespace App\Console;
use App\Models\BarangMasuk;
use App\Models\Notifikasi;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar perintah Artisan yang tersedia.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tes-schedule')->everyMinute();
        $schedule->command('inspire')->hourly();
    }

    /**
     * Registrasi perintah aplikasi.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
