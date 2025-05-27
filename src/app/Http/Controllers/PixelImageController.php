<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePixelImageRequest;
use App\Jobs\ProcessPixelRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\{JsonResponse, Request};

/**
 * Controller to send the request of generating image from the frontend to the RabbitMQ.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
class PixelImageController extends Controller
{

    /**
     * Controller to send request to generate image in pixel art.
     *
     * @param GeneratePixelImageRequest $request
     * @return JsonResponse
     */
    public function generate(GeneratePixelImageRequest $request): JsonResponse
    {
        $imagePath = $request->file('image')->store('uploads', 'public');

        // remove expired files
        Artisan::call('files:cleanup-expired');
        $taskId = uniqid('pixel_', true);
        ProcessPixelRequest::dispatch($taskId, $imagePath);

        return response()->json([
            'task_id' => $taskId,
            'status' => 'queued',
        ]);
    }


    /**
     * Generate index view.
     *
     * @return object
     */
    public function index(): object
    {
        return view('index')->with([
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
        ]);

    }
}
