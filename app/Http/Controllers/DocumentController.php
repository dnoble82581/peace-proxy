<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Plan;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Log;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Document::class);

        return Document::all();
    }

    public function showUserDocument(User $user, $filename)
    {
        return $this->showDocument($user, $filename);
    }

    private function showDocument($entity, $filename)
    {
        if (! ($entity instanceof User || $entity instanceof Subject || $entity instanceof Plan)) {
            abort(400, 'Invalid entity type.');
        }

        // Find the document from DB
        $document = $entity->documents()->where('filename', $filename)->first();
        if (! $document) {
            abort(404, 'Document not found.');
        }

        // Authorize the user making the request
        if (! request()->user()->can('view', $document)) {
            abort(403, 'You are not authorized to view this document.');
        }

        // Build the file path based on entity type
        if (class_basename($entity) === 'User') {
            $filePath = 'documents/user/'.$entity->id.'/'.$filename;
        } elseif (class_basename($entity) === 'Plan') {
            $filePath = 'documents/plan/'.$entity->id.'/'.$filename;
        } else {
            $filePath = 'documents/subject/'.$entity->id.'/'.$filename;
        }

        // Log file path for debugging
        Log::info("Attempting to access file: {$filePath}");

        // Verify if the file exists on S3
        if (! Storage::disk('s3')->exists($filePath)) {
            abort(404, 'File not found on S3.');
        }

        // Stream the file to the browser
        if ($document->extension === 'pdf') {
            // Optionally use a signed URL for secure access
            //            $signedUrl = Storage::disk('s3')->temporaryUrl($filePath, now()->addMinutes(10));
            //
            //            return redirect($signedUrl);

            // Or directly stream the content
            return response(Storage::disk('s3')->get($filePath))
                ->header('Content-Type', 'application/pdf');
        }

        return '#';

    }

    public function showSubjectDocument(Subject $subject, $filename)
    {
        return $this->showDocument($subject, $filename);
    }

    public function showDeliveryPlanDocument(Plan $deliveryPlan, $filename)
    {
        return $this->showDocument($deliveryPlan, $filename);
    }
}
