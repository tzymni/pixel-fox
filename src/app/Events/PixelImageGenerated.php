<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

/**
 * Event to inform frontend about generated pixel image.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
class PixelImageGenerated implements ShouldBroadcast
{
    use SerializesModels;

    public string $taskId;

    public string $pixelImageName;

    public function __construct(string $taskId, string $pixelImageName)
    {
        $this->taskId = $taskId;
        $this->pixelImageName = $pixelImageName;
    }

    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('pixel-task.' . $this->taskId);
    }
}


