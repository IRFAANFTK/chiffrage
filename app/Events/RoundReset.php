<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoundReset implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $sessionCode;

    /**
     * Create a new event instance.
     *
     * @param string $sessionCode The session code to broadcast on
     */
    public function __construct(string $sessionCode)
    {
        $this->sessionCode = $sessionCode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("session.{$this->sessionCode}");
    }

    /**
     * Optional: Customize the event name for frontend listeners
     */
    public function broadcastAs(): string
    {
        return 'round.reset';
    }

    /**
     * Optional: Define data sent with the event
     */
    public function broadcastWith(): array
    {
        return [
            'message' => 'Round has been reset.',
            'sessionCode' => $this->sessionCode,
        ];
    }
}
