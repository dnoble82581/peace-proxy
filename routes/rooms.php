<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::domain('negotiation'.config('app.url'))->group(function () {
    Route::get('/room/{room}', [PagesController::class, 'negotiationRoom'])->name('negotiation.room');
});
