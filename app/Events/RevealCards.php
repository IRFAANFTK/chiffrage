<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class RevealCards implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $sessionCode;

    public function __construct(string $sessionCode)
    {
        $this->sessionCode = $sessionCode;
    }

    public function broadcastOn()
    {
        return new Channel("session.{$this->sessionCode}");
    }

    public function broadcastAs()
    {
        return 'cards.revealed';
    }
}
