<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoundReset implements ShouldBroadcast
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

    public function broadcastAs(): string
    {
        return 'session.reset'; // ✅ match your frontend `.session.reset` listener
    }

    public function broadcastWith(): array
    {
        return [
            'message' => 'Round has been reset.',
            'sessionCode' => $this->sessionCode,
        ];
    }
}
