<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PixelArtGenerated implements ShouldBroadcast
{
    use SerializesModels;

    public string $taskId;

    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
    }

    public function broadcastOn()
    {
        return new Channel('pixel-task.' . $this->taskId);
    }
}


