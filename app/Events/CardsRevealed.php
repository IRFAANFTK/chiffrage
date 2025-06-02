<?php

namespace App\Events;

use App\Models\GameSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CardsRevealed implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $cards;
    public $average;
    public $sessionCode;

    public function __construct(GameSession $session)
    {
        $this->sessionCode = $session->code;
        $this->cards = $session->cards()->with('player:id,name')->get()->map(function ($card) {
            return [
                'player' => $card->player->name,
                'card' => $card->card_number,
            ];
        });
        $this->average = round($session->cards()->avg('card_number'), 2);
    }

    public function broadcastOn(): Channel
    {
        return new Channel("session.{$this->sessionCode}");
    }
}
