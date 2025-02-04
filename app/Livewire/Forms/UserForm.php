<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Services\DocumentProcessor;
use Exception;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

/**
 * Class UserForm
 *
 * A Livewire form class for handling creation and editing of user data.
 */
class UserForm extends Form
{
    /**
     * The user model instance being edited.
     */
    public ?User $user;

    /**
     * Uploaded photo/avatar file.
     *
     * @var mixed
     */
    #[Validate(['nullable', 'image', 'max:1024'])]
    public $photo;

    /**
     * User's name.
     *
     * @var string
     */
    #[Validate(['required'])]
    public $name = '';

    /**
     * User's email address.
     *
     * @var string
     */
    #[Validate(['required', 'email', 'max:254'])]
    public $email = '';

    /**
     * User's primary phone number.
     *
     * @var string|null
     */
    #[Validate(['nullable'])]
    public $primary_phone = '';

    /**
     * User's secondary phone number.
     *
     * @var string|null
     */
    #[Validate(['nullable'])]
    public $secondary_phone = '';

    /**
     * User's avatar file path stored in the system.
     *
     * @var string|null
     */
    #[Validate(['nullable'])]
    public $avatar = '';

    /**
     * User's role in the system.
     *
     * @var string
     */
    #[Validate(['required'])]
    public $role = 'User';

    /**
     * User's title or job position.
     *
     * @var string|null
     */
    #[Validate(['nullable'])]
    public $title = '';

    /**
     * User's account status (active/inactive).
     *
     * @var bool
     */
    #[Validate(['boolean'])]
    public $status = false;

    //    #[Validate(['file', 'max:10000', 'mimes:pdf', 'nullable'])]
    public $application;

    /**
     * Create a new user in the system using the form's data.
     */
    public function create()
    {
        $this->validate();

        $userData = $this->collectUserData();

        if ($this->photo) {
            $userData['avatar'] = $this->saveUserAvatar();
        }

        $user = User::create($userData);

        $this->handleFileUploads($user);

        return redirect('/team');
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
            'title' => $this->title,
            'status' => $this->status,
            'password' => $this->user ?? bcrypt('Password'), // Only set password for new users
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
        $documentProcessor->processDocuments($this->application, $user, auth()->user()->id);
    }

    /**
     * Update the existing user's data in the system.
     */
    public function update(): void
    {
        $this->validate();

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
            'title' => $user->title,
            'status' => $user->status,
        ]);
    }
}
