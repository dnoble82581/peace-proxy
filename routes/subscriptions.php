<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/pricing', [SubscriptionController::class, 'showPricing'])->name('pricing');
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe')->middleware('auth');
Route::get('/billing-portal',
    [SubscriptionController::class, 'billingPortal'])->name('billing.portal')->middleware('auth');
Route::get('/dashboard/pricing', [SubscriptionController::class, 'showPricing'])->name('auth.pricing');
