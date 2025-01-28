<?php

namespace App\Http\Controllers;

use App\Models\SubjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SubjectRequestController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', SubjectRequest::class);

        return SubjectRequest::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', SubjectRequest::class);

        $data = $request->validate([
            'negotiation_id' => ['required', 'exists:negotiations'],
            'tenant_id' => ['required', 'exists:tenants'],
            'user_id' => ['required', 'exists:users'],
            'timestamp' => ['required', 'date'],
            'subject_request' => ['required'],
            'rational' => ['required'],
            'status' => ['required'],
            'approver_comments' => ['required'],
            'priority_level' => ['required', 'integer'],
            'request_history' => ['required'],
        ]);

        return SubjectRequest::create($data);
    }

    public function show(SubjectRequest $subjectRequest)
    {
        $this->authorize('view', $subjectRequest);

        return $subjectRequest;
    }

    public function update(Request $request, SubjectRequest $subjectRequest)
    {
        $this->authorize('update', $subjectRequest);

        $data = $request->validate([
            'negotiation_id' => ['required', 'exists:negotiations'],
            'tenant_id' => ['required', 'exists:tenants'],
            'user_id' => ['required', 'exists:users'],
            'timestamp' => ['required', 'date'],
            'subject_request' => ['required'],
            'rational' => ['required'],
            'status' => ['required'],
            'approver_comments' => ['required'],
            'priority_level' => ['required', 'integer'],
            'request_history' => ['required'],
        ]);

        $subjectRequest->update($data);

        return $subjectRequest;
    }

    public function destroy(SubjectRequest $subjectRequest)
    {
        $this->authorize('delete', $subjectRequest);

        $subjectRequest->delete();

        return response()->json();
    }
}
