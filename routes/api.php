<?php

use App\Http\Controllers\AssociateRelationshipController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SocialMediaProviderController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::get('/user', function (Request $request) {
    return $request->user()->id;
})->middleware('auth:sanctum');

Route::post('/sms/inbound', [SmsController::class, 'receiveSms'])->name('sms.inbound');
Route::get('/tenants', [TenantController::class, 'index'])->name('api.tenants.index');
Route::get('/relationships', [AssociateRelationshipController::class, 'index'])->name('api.relationships.index');
Route::get('/social-media', [SocialMediaProviderController::class, 'index'])->name('api.social-media.index');
Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);
