<?php

use Livewire\Volt\Volt;

Volt::route('/{tenantId}/admin/dashboard', 'pages.admin')->name('admin');
// Route::get('/{tenant}/admin/dashboard', [PagesController::class, 'admin'])->name('admin')->middleware('admin');
