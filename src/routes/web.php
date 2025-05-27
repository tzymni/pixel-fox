<?php

use App\Http\Controllers\PixelImageController;
use Illuminate\Support\Facades\Route;

Route::controller(PixelImageController::class)->group(function () {
    Route::post('/generate_pixel', 'generate')->name('pixel.generate');
    Route::get('/check_status/{taskId}', [PixelImageController::class, 'checkStatus']);
    Route::get('/{any}', [PixelImageController::class, 'index'])->where('any', '.*');

});
