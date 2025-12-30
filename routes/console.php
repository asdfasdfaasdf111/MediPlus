<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:auto-cancel-pendaftaran')
    ->everyMinute()
    ->withoutOverlapping();

Schedule::command('app:pengingat-pemeriksaan')
    ->everyMinute()
    ->withoutOverlapping();
