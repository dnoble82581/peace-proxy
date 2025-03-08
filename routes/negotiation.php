<?php

use App\Http\Controllers\AssociateController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SubjectController;

Route::get('/negotiation/room/{room}/edit-subject/{subject:name}',
    [SubjectController::class, 'update'])->name('edit.subject');
Route::get('/negotiation/room/{room}/show/{subject}',
    [SubjectController::class, 'show'])->name('show.subject');

Route::get('/negotiation/room/{room}/edit-associate/{associate}/edit',
    [AssociateController::class, 'update'])->name('edit.associate');
Route::get('negotiation/room/{room}/create-associate',
    [AssociateController::class, 'store'])->name('create.associate');
Route::get('/negotiation/room/{room}/show-associate/{associate}',
    [AssociateController::class, 'show'])->name('show.associate');

Route::view('/create-negotiation', 'pages.create-negotiation')->name('create.negotiation');
Route::get('/negotiation/room/{room}', [RoomController::class, 'index'])->name('negotiation.room');

Route::get('/negotiation/tactical/{room}',
    [RoomController::class, 'tacticalRoom'])->name('tactical.room');

Route::get('/risk-assessment', function () {
    return view('pdfs.on-scene-risk-assessment');
})->name('risk.assessment');
