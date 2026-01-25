<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Membuat helper function untuk format tanggal
        if (!function_exists('formatTanggal')) {
            function formatTanggal($tanggal)
            {
                if (is_object($tanggal) && method_exists($tanggal, 'format')) {
                    return $tanggal->format('d/m/Y');
                } else {
                    return date('d/m/Y', strtotime($tanggal));
                }
            }
        }
    }
}