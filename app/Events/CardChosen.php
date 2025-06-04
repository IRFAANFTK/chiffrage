<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardChosen implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $sessionCode;
    public int $playerId;
    public int $cardValue;

    /**
     * Create a new event instance.
     *
     * @param string $sessionCode The session code to broadcast on
     * @param int $playerId The ID of the player who chose the card
     * @param int $cardValue The value of the chosen card
     */
    public function __construct(string $sessionCode, int $playerId, int $cardValue)
    {
        $this->sessionCode = $sessionCode;
        $this->playerId = $playerId;
        $this->cardValue = $cardValue;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel("session.{$this->sessionCode}");
    }

    /**
     * Customize the event name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'card.chosen';
    }

    /**
     * Define the data sent with the event.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'player_id' => $this->playerId,
            'card_value' => $this->cardValue,
        ];
    }
}
