<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('session.{code}', function ($user, $code) {
    return true; // Optional: Replace with auth logic
});

/*Broadcast::channel('test-channel', function () {
    return true;
});*/
