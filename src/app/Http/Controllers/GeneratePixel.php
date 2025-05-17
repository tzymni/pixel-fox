<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPixelRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
/**
 * Controller to send the request of generating image from the frontend to the RabbitMQ.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
class GeneratePixel extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|max:5120', // maks 5MB
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        $taskId = uniqid('pixel_', true);

        ProcessPixelRequest::dispatch($taskId, $imagePath);

        return response()->json([
            'task_id' => $taskId,
            'status' => 'queued',
        ]);
    }

}
