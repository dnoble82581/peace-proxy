<?php

use App\Http\Controllers\AssociateRelationshipController;
use App\Http\Controllers\SocialMediaProviderController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->id;
})->middleware('auth:sanctum');

Route::get('/tenants', [TenantController::class, 'index'])->name('api.tenants.index');
Route::get('/relationships', [AssociateRelationshipController::class, 'index'])->name('api.relationships.index');
Route::get('/social-media', [SocialMediaProviderController::class, 'index'])->name('api.social-media.index');
