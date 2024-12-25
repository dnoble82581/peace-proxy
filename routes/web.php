<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/leave-impersonation',
        [ImpersonationController::class, 'leave'])->name('leave-impersonation');
    route::view('team', 'pages.team')->name('team');
    route::view('create-user', 'pages.create-user')->name('create.user');
    route::get('edit-user/{id}', [PagesController::class, 'editUser'])->name('edit.user');
    Route::get('/documents/{user}/{filename}', [DocumentController::class, 'show']);
    Route::view('/create-negotiation', 'pages.create-negotiation')->name('create.negotiation');
    Route::get('/negotiation/room/{room}', [PagesController::class, 'negotiationRoom'])->name('negotiation.room');
    Route::get('/command', [PagesController::class, 'command'])->name('command');
    route::get('/negotiation/room/tactical/{room}', [PagesController::class, 'tacticalRoom'])->name('tactical.room');
});

Route::view('dashboard', 'pages.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'pages.profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
