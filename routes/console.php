<?php

use App\Jobs\SendReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new SendReminders)->hourly();
//Schedule::job(new SendPending)->hourly();
Schedule::command('queue:work --stop-when-empty')->everyMinute();
