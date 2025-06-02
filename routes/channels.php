<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('session.{code}', function ($user, $code) {
    return true; // Or add your own logic to verify
});
