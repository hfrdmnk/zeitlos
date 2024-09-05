<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Scheduling backups
Schedule::command('backup:run --only-db')->daily()->at('04:00');
Schedule::command('backup:clean')->daily()->at('04:30');
Schedule::command('backup:monitor')->daily()->at('05:00');
