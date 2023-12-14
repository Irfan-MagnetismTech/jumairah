<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaleCollectionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $salesCollection;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($salesCollection)
    {
        $this->salesCollection = $salesCollection;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
