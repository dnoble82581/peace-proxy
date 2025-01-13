<?php

namespace App\Livewire\Forms;

use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NegotiationForm extends Form
{
    // Default constants for improving value readability
    public const DEFAULT_SUBJECT_NAME = 'John Doe';

    public const DEFAULT_STATUS = 'Pending';

    public const DEFAULT_TYPE = 'Live';

    #[Validate(['required'])]
    public $type = self::DEFAULT_TYPE;

    #[Validate(['required'])]
    public $title = '';

    #[Validate(['nullable'])]
    public $address = '';

    #[Validate(['required'])]
    public $city = '';

    #[Validate(['required'])]
    public $state = '';

    #[Validate(['nullable'])]
    public $zip = '';

    #[Validate(['required'])]
    public $status = self::DEFAULT_STATUS;

    #[Validate(['nullable'])]
    public $initial_complainant = '';

    #[Validate(['nullable'])]
    public $initial_complaint = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public $subject_name = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public $subject_sex = '';

    #[Validate(['nullable', 'int'])]
    public $subject_age = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public $subject_phone = '';

    #[Validate(['nullable'])]
    public $subject_motivation = '';

    /**
     * Saves the negotiation form.
     */
    public function save()
    {
        $this->validate();

        $newNegotiation = $this->createNegotiation();
        $assignedRoom = $this->createRoom($newNegotiation->id);
        $newSubject = $this->createSubject($newNegotiation->id, $assignedRoom->id);

        $this->linkNegotiationAndRoomToSubject($newNegotiation, $assignedRoom, $newSubject);
    }

    /**
     * Creates a new negotiation.
     */
    private function createNegotiation(): Negotiation
    {
        return Negotiation::create([
            'type' => $this->type,
            'title' => $this->title,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'status' => $this->status,
            'initial_complainant' => $this->initial_complainant,
            'initial_complaint' => $this->initial_complaint,
            'subject_name' => $this->getSubjectName(),
            'subject_sex' => $this->subject_sex,
            'subject_motivation' => $this->subject_motivation,
            'subject_age' => $this->subject_age,
            'subject_phone' => $this->subject_phone,
            'user_id' => $this->getUserId(),
            'tenant_id' => $this->getTenantId(),
        ]);
    }

    /**
     * Gets the subject name or default value.
     */
    private function getSubjectName(): string
    {
        return $this->subject_name ?: self::DEFAULT_SUBJECT_NAME;
    }

    /**
     * Gets the authenticated user's ID.
     */
    private function getUserId(): int
    {
        return auth()->user()->id;
    }

    /**
     * Gets the authenticated user's tenant ID.
     */
    private function getTenantId(): int
    {
        return auth()->user()->tenant_id;
    }

    /**
     * Creates a room associated with a negotiation.
     */
    private function createRoom(int $negotiationId): Room
    {
        return Room::create([
            'negotiation_id' => $negotiationId,
            'tenant_id' => $this->getTenantId(),
            'subject_id' => null,
        ]);
    }

    /**
     * Creates a subject for the negotiation.
     */
    private function createSubject(int $negotiationId, int $roomId): Subject
    {
        return Subject::create([
            'negotiation_id' => $negotiationId,
            'room_id' => $roomId,
            'tenant_id' => $this->getTenantId(),
            'name' => $this->getSubjectName(),
            'gender' => $this->subject_sex,
            'age' => $this->subject_age ?: null,
            'phone' => $this->subject_phone,
        ]);
    }

    /**
     * Links the subject to both the negotiation and the assigned room.
     */
    private function linkNegotiationAndRoomToSubject(Negotiation $negotiation, Room $room, Subject $subject): void
    {
        $negotiation->update(['subject_id' => $subject->id]);
        $room->update(['subject_id' => $subject->id]);
    }
}
