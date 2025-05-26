<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PixelArtGenerated implements ShouldBroadcast
{
    use SerializesModels;

    public string $taskId;

    public string $pixelImageName;

    public function __construct(string $taskId, string $pixelImageName)
    {
        $this->taskId = $taskId;
        $this->pixelImageName = $pixelImageName;
    }

    public function broadcastOn()
    {
        return new Channel('pixel-task.' . $this->taskId);
    }
}


