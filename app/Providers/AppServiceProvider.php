<?php

namespace App\Providers;

use App\Models\RumahSakit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('admin.*', function($view){
            $view->with('admin', auth()->user()->admin);
        });

        View::composer('petugas.*', function($view){
            $view->with('petugas', auth()->user()->petugas);
        });

        View::composer('layout.footer', function ($view) {
        $rumahsakits = cache()->remember('rs_mitra_footer', 3600, function () {
            $q = RumahSakit::query()->orderBy('nama');

            // Hanya filter 'aktif' kalau kolomnya memang ada
            if (Schema::hasColumn('rumah_sakits', 'aktif')) {
                $q->where('aktif', 1);
            }

            return $q->get(['id','nama']); // footer cuma butuh ini
        });

        $view->with('rumahsakits', $rumahsakits);
        });
    }
}
