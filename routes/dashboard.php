<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;

Route::view('dashboard/team', 'pages.team')->name('team');
Route::view('create-user', 'pages.create-user')->name('create.user');
Route::get('dashboard/team/edit-user/{id}', [UserController::class, 'update'])->name('edit.user');
// ToDo: Put subscribed middleware back in here
Route::get('dashboard', [PagesController::class, 'dashboard'])
    ->middleware(['verified'])
    ->name('dashboard');
