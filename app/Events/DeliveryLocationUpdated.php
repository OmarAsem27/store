<?php

namespace App\Events;

use App\Models\Delivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    protected $delivery;
    /**
     * Create a new event instance.
     */
    public function __construct(Delivery $delivery, public string $longitude, public string $latitude)
    {
        $this->delivery = $delivery;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new Channel('deliveries'),
            new PrivateChannel('deliveries' . $this->delivery->order_id),
        ];
    }

    // send custom data
    public function broadcastwith(): array
    {
        return [
            'longitude' => $this->longitude,
            'latitude' => $this->latitude
        ];
    }

    // set a new name for the event 'location-updated' instead of 'App\Events\DeliveryLocationUpdated'
    public function broadcastAs(): string
    {
        return 'location-updated';
    }
}
