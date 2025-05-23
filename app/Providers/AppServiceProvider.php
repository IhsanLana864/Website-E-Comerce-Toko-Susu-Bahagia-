<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.layouts.main', function ($view) {
            $notifikasis = Notifikasi::where('dibaca', false)->latest()->get();
            $jumlah_notif = Notifikasi::where('dibaca', false)->count();
            
            $view->with(compact('notifikasis', 'jumlah_notif'));
        });
    }
}
