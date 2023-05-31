<?php

namespace App\Events;

use App\Models\Picture;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PictureStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Picture $picture;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Picture $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
