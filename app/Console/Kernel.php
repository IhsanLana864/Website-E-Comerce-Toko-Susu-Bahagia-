<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\BarangMasuk;
use App\Models\Notifikasi;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar perintah Artisan yang tersedia.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:cek-kedaluwarsa')->dailyAt(00.00);
    }

    /**
     * Registrasi perintah aplikasi.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
