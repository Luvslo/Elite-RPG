<?php

namespace App\Events;

use App\Map;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerMoving implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $map;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Map $map, User $user)
    {
        $this->map = $map;
        $this->user = $user;
    }

    /**
     * Get channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('eliteworld');
    }
}
