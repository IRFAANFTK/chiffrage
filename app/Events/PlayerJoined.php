<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerJoined implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $player;
    public $sessionCode;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->sessionCode = $player->gameSession->code;
    }

    public function broadcastOn()
    {
        return new \Illuminate\Broadcasting\Channel("session.{$this->sessionCode}");
    }

    public function broadcastAs()
    {
        return 'player.joined';
    }
}
