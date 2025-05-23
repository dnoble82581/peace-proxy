<?php

use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::view('/', 'pages.welcome')->name('home');

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

Route::middleware(['auth'])->group(function () {
    require __DIR__.'/admin.php';
    require __DIR__.'/dashboard.php';
    require __DIR__.'/documents.php';
    require __DIR__.'/negotiation.php';
    require __DIR__.'/impersonation.php';
    require __DIR__.'/profile.php';
    require __DIR__.'/subscriptions.php';
    Route::post('/send-sms', [SmsController::class, 'sendSms'])->name('send.sms');

});

require __DIR__.'/auth.php';
