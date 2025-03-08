<?php

use App\Http\Controllers\PagesController;

Route::get('/{tenant}/admin/dashboard', [PagesController::class, 'admin'])->name('admin')->middleware('admin');
