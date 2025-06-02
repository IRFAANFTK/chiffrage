<?php

namespace App\Events;

use App\Models\GameSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PlayerJoined implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $players;
    public $sessionCode;

    public function __construct(GameSession $session)
    {
        $this->players = $session->players()->get(['id', 'name']);
        $this->sessionCode = $session->code;
    }

    public function broadcastOn(): Channel
    {
        return new Channel("session.{$this->sessionCode}");
    }
}
