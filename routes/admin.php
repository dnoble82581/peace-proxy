<?php

use App\Http\Controllers\PagesController;

Route::get('{tenantId}/admin', [PagesController::class, 'admin'])->name('admin');
