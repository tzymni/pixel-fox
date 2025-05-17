<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('pixel-task.{taskId}', function ($user = null, $taskId) {
    return true; // todo after adding login to the page it should be changed
});
