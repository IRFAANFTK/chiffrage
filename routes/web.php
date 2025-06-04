<?php

use App\Events\PusherTestEvent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/test-pusher', function () {
    broadcast(new PusherTestEvent('Hello from Laravel via Pusher!'));
    return 'Event sent';
});

require __DIR__.'/auth.php';
