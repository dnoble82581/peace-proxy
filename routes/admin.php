<?php

use App\Http\Controllers\PagesController;

Route::get('{negotiationId}/admin/negotiation', [PagesController::class, 'negotiation'])->name('show.negotiation');
Route::get('{tenantId}/admin', [PagesController::class, 'admin'])->name('admin');
