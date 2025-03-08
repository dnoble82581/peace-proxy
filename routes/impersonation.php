<?php

use App\Http\Controllers\ImpersonationController;

Route::get('/leave-impersonation',
    [ImpersonationController::class, 'leave'])->name('leave-impersonation');
