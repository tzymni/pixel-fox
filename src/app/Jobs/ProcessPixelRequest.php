<?php
namespace App\Jobs;

use App\Events\PixelArtGenerated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

/**
 * Process request from the queue.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
class ProcessPixelRequest implements ShouldQueue
{
    use Dispatchable, Queueable;

    public string $taskId;
    public string $imagePath;

    public function __construct(string $taskId, string $imagePath)
    {
        $this->taskId = $taskId;
        $this->imagePath = $imagePath;
    }

    public function handle(): void
    {
        Log::info("Processing task: {$this->taskId}");

        // Symulacja "generowania"
        sleep(5);
        event(new PixelArtGenerated($this->taskId));

    }
}
