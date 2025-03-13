<?php

namespace App\Livewire\Forms;

use App\Models\Tenant;
use App\Models\User;
use App\Services\DocumentProcessor;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Livewire\Form;

// ToDo: fix validation here

/**
 * Class UserForm
 *
 * A Livewire form class for handling creation and editing of user data.
 */
class UserForm extends Form
{
    public ?User $user;

    public ?Tenant $tenant;

    public $photo;

    public $name = '';

    public $email = '';

    public $primary_phone = '';

    public $secondary_phone = '';

    public $avatar;

    public $role = '';

    public $privileges = 'user';

    public $status = true;

    public $application;

    public $password;

    public $password_confirmation;

    /**
     * Create a new user in the system using the form's data.
     *
     * @throws Exception
     */
    public function create(?Tenant $tenant = null): User
    {
        if ($tenant) {
            $this->tenant = $tenant;
            $this->privileges = 'admin';
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'primary_phone' => ['nullable', 'string', 'max:255'],
            'secondary_phone' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'role' => ['nullable', 'string', 'max:255'],
            'privileges' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'application' => ['nullable', 'file', 'max:10000', 'mimes:pdf'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],

        ]);

        $userData = $this->collectUserData();

        if ($this->photo) {
            $userData['avatar'] = $this->saveUserAvatar();
        }

        if ($this->tenant) {
            $userData['tenant_id'] = $this->tenant->id;
        }

        $user = User::create($userData);

        if ($this->application) {
            $this->handleFileUploads($user);
        }

        return $user;
    }

    /**
     * Collect validated user data from the form for creation or updating.
     */
    private function collectUserData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'primary_phone' => $this->primary_phone,
            'secondary_phone' => $this->secondary_phone,
            'avatar' => $this->avatar,
            'role' => $this->role,
            'privileges' => $this->privileges,
            'status' => $this->status,
            'tenant_id' => $this->tenant->id ?? null,
            'password' => $this->user->password ?? bcrypt($this->password), // Only set password for new users
            'password_confirmation' => $this->user->password ?? bcrypt($this->password_confirmation),
        ];
    }

    /**
     * Save the user's avatar file to the storage.
     *
     * @return string The path of the saved avatar.
     */
    public function saveUserAvatar(): string
    {
        return $this->photo->store('avatars', 's3-public');
    }

    /**
     * Handle file uploads submitted with the form.
     *
     * This method saves the uploaded application file, if any, and links it to the user.
     *
     * @param  User  $user  The user instance to associate with the uploaded files.
     *
     * @throws Exception
     */
    private function handleFileUploads(User $user): void
    {
        $documentProcessor = new DocumentProcessor;
        $documentProcessor->processDocuments($this->application, $user, auth()->user()->id, 'application');
    }

    /**
     * Update the existing user's data in the system.
     *
     * @throws Exception
     */
    public function update(): void
    {
        $this->validate([
            'email' => 'required|email|max:254|unique:users,email,'.($this->user->id ?? 'null'),
        ]);

        if ($this->photo) {
            $this->deleteExistingAvatar();
            $this->avatar = $this->saveUserAvatar();
        }

        if ($this->application) {
            $this->handleFileUploads($this->user);
        }
        $this->user->update($this->all());
    }

    /**
     * Delete the existing avatar file from the storage, if it exists.
     */
    private function deleteExistingAvatar(): void
    {
        if ($this->user && $this->user->avatar) {
            if (Storage::disk('s3-public')->exists($this->user->avatar)) {
                Storage::disk('s3-public')->delete($this->user->avatar);
            }
        }
    }

    /**
     * Assign a user model's data to the form fields.
     *
     * @param  User  $user  The user model to load into the form.
     */
    public function setForm(User $user): void
    {
        $this->user = $user;

        $this->fill([
            'name' => $user->name,
            'email' => $user->email,
            'primary_phone' => $user->primary_phone,
            'secondary_phone' => $user->secondary_phone,
            'avatar' => $user->avatar,
            'role' => $user->role,
            'password' => $user->password,
            'privileges' => $user->privileges,
            'title' => $user->title,
            'status' => $user->status,
        ]);
    }
}
