<?php

use App\Jobs\SendReminders;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/test', function() {
    SendReminders::dispatch();
});