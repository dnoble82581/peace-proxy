<?php

use App\Http\Controllers\DocumentController;
use App\Models\Plan;

Route::get('/documents/user/{user}/{filename}', [DocumentController::class, 'showUserDocument']);
Route::get('/documents/subject/{subject}/{filename}', [DocumentController::class, 'showSubjectDocument']);
Route::get('/documents/negotiation/{negotiation}/{filename}',
    [DocumentController::class, 'showNegotiationDocument']);
Route::get('/documents/plan/{plan}/{filename}', function ($deliveryPlanId, $filename) {
    $deliveryPlan = Plan::findOrFail($deliveryPlanId);

    return app(DocumentController::class)->showDeliveryPlanDocument($deliveryPlan, $filename);
});
Route::get('/negotiations/{id}/download-pdf', [DocumentController::class, 'downloadPdf'])->name('download-pdf');
