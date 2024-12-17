<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Document::class);

        return Document::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Document::class);

        $data = $request->validate([
            'type' => ['required'],
            'user_id' => ['required', 'exists:users'],
            'filename' => ['required'],
            'extension' => ['required'],
            'size' => ['required', 'integer'],
            'tenant_id' => ['required', 'exists:tenants'],
        ]);

        return Document::create($data);
    }

    public function show(User $user, $filename)
    {
        // find the document from db
        $document = $user->documents()->where('filename', $filename)->get()->first();
        // authorise user making request
        if (! request()->user()->isAdmin() && ! request()->user()->isSuperAdmin()) {
            abort(403);
        }
        // stream the file to the browser
        if ($document->extension == 'pdf') {
            return response(Storage::disk('s3')->get('/documents/'.$user->id.'/'.$filename))
                ->header('Content-Type', 'application/pdf');
        }
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        $data = $request->validate([
            'type' => ['required'],
            'user_id' => ['required', 'exists:users'],
            'filename' => ['required'],
            'extension' => ['required'],
            'size' => ['required', 'integer'],
            'tenant_id' => ['required', 'exists:tenants'],
        ]);

        $document->update($data);

        return $document;
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        $document->delete();

        return response()->json();
    }
}
