<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

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
        return $this->showDocument($user, $filename, 'user');
    }

    private function showDocument($entity, $filename, $type)
    {
        // find the document from db
        $document = $entity->documents()->where('filename', $filename)->first();
        if (! $document) {
            abort(404, 'Document not found.');
        }

        // authorize the user making request
        if (! request()->user()->isAdmin()) {
            abort(403);
        }

        // build the file path based on entity type
        $filePath = '/documents/'.$entity->id.'/'.$filename;

        // stream the file to the browser
        if ($document->extension === 'pdf') {
            return response(Storage::disk('s3')->get($filePath))
                ->header('Content-Type', 'application/pdf');
        }

        return '#';
    }

    public function showSubjectDocument(Subject $subject, $filename)
    {
        return $this->showDocument($subject, $filename, 'subject');
    }
}
