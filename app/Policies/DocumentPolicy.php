<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Document $document): bool
    {
        return $user->privileges === 'admin' && $document->tenant_id === $user->tenant_id;
    }

    public function create(User $user): bool {}

    public function update(User $user, Document $document): bool {}

    public function delete(User $user, Document $document): bool {}

    public function restore(User $user, Document $document): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Document $document): bool {}
}
