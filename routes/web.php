<?php

use App\Http\Controllers\AssociateController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\DeliveryPlan;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/leave-impersonation',
        [ImpersonationController::class, 'leave'])->name('leave-impersonation');
    Route::view('dashboard/team', 'pages.team')->name('team');
    Route::view('create-user', 'pages.create-user')->name('create.user');
    Route::get('dashboard/team/edit-user/{id}', [UserController::class, 'update'])->name('edit.user');

    Route::get('/documents/user/{user}/{filename}', [DocumentController::class, 'showUserDocument']);
    Route::get('/documents/subject/{subject}/{filename}', [DocumentController::class, 'showSubjectDocument']);
    Route::get('/documents/deliveryplan/{deliveryplan}/{filename}', function ($deliveryPlanId, $filename) {
        $deliveryPlan = DeliveryPlan::findOrFail($deliveryPlanId);

        return app(DocumentController::class)->showDeliveryPlanDocument($deliveryPlan, $filename);
    });

    Route::view('/create-negotiation', 'pages.create-negotiation')->name('create.negotiation');
    Route::get('/negotiation/room/{room}', [RoomController::class, 'index'])->name('negotiation.room');

    Route::get('/negotiation/tactical/{room}',
        [RoomController::class, 'tacticalRoom'])->name('tactical.room');

    Route::get('/{tenant}/admin/dashboard', [PagesController::class, 'admin'])->name('admin')->middleware('admin');

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

    Route::get('/risk-assessment', function () {
        return view('pdfs.on-scene-risk-assessment');
    })->name('risk.assessment');

});

Route::view('dashboard', 'pages.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'pages.profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
