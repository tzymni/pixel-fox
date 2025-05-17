<?php

use App\Http\Controllers\GeneratePixel;
use Illuminate\Support\Facades\Route;


Route::controller(GeneratePixel::class)->group(function () {
    Route::post('/generate_pixel', 'generate')->name('pixel.generate');
    Route::get('/check_status/{taskId}', [GeneratePixel::class, 'checkStatus']);

});

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
