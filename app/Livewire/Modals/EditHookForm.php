<?php

namespace App\Livewire\Modals;

use App\Events\HookEvent;
use App\Models\Hook;
use App\Models\Room;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

/**
 * A Livewire modal component for editing a hook.
 * This modal allows users to modify the title and description of an existing hook associated with a room.
 */
class EditHookForm extends Modal
{
    /**
     * The title of the hook being edited.
     */
    #[Validate('string|required|min:3|max:255')]
    public string $title;

    /**
     * The description of the hook being edited.
     */
    #[Validate('string|required|min:3|max:755')]
    public string $description;

    /**
     * The current hook being edited.
     */
    public Hook $hook;

    /**
     * The authenticated user performing the edit action.
     */
    public User $user;

    /**
     * The room to which the hook belongs.
     */
    public Room $room;

    /**
     * Define the modal's behavior settings.
     *
     * @return array Key-value pairs of modal behavior settings.
     */
    public static function behavior(): array
    {
        return [
            // Close the modal if the escape key is pressed
            'close-on-escape' => true,
            // Close the modal if someone clicks outside the modal
            'close-on-backdrop-click' => true,
            // Trap the users focus inside the modal (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => true,
            // Remove all unsaved changes once someone closes the modal
            'remove-state-on-close' => false,
        ];
    }

    /**
     * Define the modal's visual attributes.
     *
     * @return array Key-value pairs of modal attributes.
     */
    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, fullscreen
            'size' => '2xl',
        ];
    }

    /**
     * Mount the component with the provided hook ID and room ID.
     * This method retrieves the hook and room from the database and initializes the form.
     *
     * @param  int  $hookId  ID of the hook being edited.
     * @param  int  $roomId  ID of the room associated with the hook.
     */
    public function mount(int $hookId, int $roomId)
    {
        $this->hook = $this->getHook($hookId);
        $this->room = $this->getRoom($roomId);
        $this->user = auth()->user();
        $this->setForm($this->hook);
    }

    /**
     * Retrieve a hook by its ID, or throw an exception if not found.
     *
     * @param  int  $hookId  ID of the hook being retrieved.
     * @return Hook The retrieved hook.
     */
    public function getHook($hookId)
    {
        return Hook::findorfail($hookId);
    }

    /**
     * Retrieve a room by its ID, or throw an exception if not found.
     *
     * @param  int  $roomId  ID of the room being retrieved.
     * @return Room The retrieved room.
     */
    public function getRoom($roomId)
    {
        return Room::findorfail($roomId);
    }

    /**
     * Populate the form fields with the details of the given hook.
     *
     * @param  Hook  $hook  The hook being used to populate the form.
     */
    public function setForm($hook)
    {
        $this->title = $hook->title;
        $this->description = $hook->description;
    }

    /**
     * Validate and update the hook with the edited data.
     * Emits the HookEditedEvent, updates the database, and closes the modal.
     *
     * @return void
     */
    public function updateHook()
    {
        // Validate the form fields using Livewire's validation rules
        $this->validate();

        // Update the hook's data in the database
        $this->hook->update([
            'title' => $this->title,
            'description' => $this->description,
            'tenant_id' => $this->room->tenant_id,
            'subject_id' => $this->room->subject_id,
        ]);

        // Fire a HookEditedEvent to notify listeners of the update
        event(new HookEvent($this->room->id, $this->hook->id, 'edited'));

        // Close the modal after the update is complete
        $this->close();
    }

    /**
     * Render the modal's view.
     *
     * @return View The view file associated with the modal component.
     */
    public function render()
    {
        return view('livewire.modals.edit-hook-form');
    }
}
