<?php

namespace App\Livewire\Forms;

use App\Events\AssociateEvent;
use App\Models\Associate;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AssociateForm extends Form
{
    public ?Associate $associate;

    #[Validate(['images.*' => 'image|max:1024'])]
    public $images = [];

    #[Validate(['required'])]
    public $name = '';

    #[Validate(['nullable'])]
    public $phone = '';

    #[Validate(['nullable', 'email', 'max:254'])]
    public $email = '';

    #[Validate(['nullable'])]
    public $race = '';

    #[Validate(['nullable'])]
    public $gender = '';

    #[Validate(['nullable'])]
    public $address = '';

    #[Validate(['nullable'])]
    public $city = '';

    #[Validate(['nullable'])]
    public $state = '';

    #[Validate(['nullable'])]
    public $zipcode = '';

    #[Validate(['nullable'])]
    public $dob = '';

    #[Validate(['nullable', 'integer'])]
    public $age = 0;

    #[Validate(['nullable', 'integer'])]
    public $children = 0;

    #[Validate(['nullable'])]
    public $veteran = 'Unknown';

    #[Validate(['nullable'])]
    public $facebook_url = '';

    #[Validate(['nullable'])]
    public $x_url = '';

    #[Validate(['nullable'])]
    public $instagram_url = '';

    #[Validate(['nullable'])]
    public $youtube_url = '';

    #[Validate(['nullable'])]
    public $snapchat_url = '';

    #[Validate(['nullable'])]
    public $notes = '';

    #[Validate(['nullable'])]
    public $physical_description = '';

    #[Validate(['nullable'])]
    public $relationship_to_subject = '';

    #[Validate(['nullable'])]
    public $weapons = '';

    #[Validate(['nullable'])]
    public $highest_education = '';

    #[Validate(['nullable'])]
    public $medical_issues = '';

    #[Validate(['nullable'])]
    public $mental_health_history = '';

    #[Validate(['nullable'])]
    public $substance_abuse = '';

    #[Validate(['nullable', 'date'])]
    public $last_contacted_at = null;

    public function update()
    {
        $this->validate();

        if ($this->images) {
            $this->processImages();
        }
        $this->associate->update($this->all());
        event(new AssociateEvent($this->associate->room_id, $this->associate->id, 'edited'));

    }

    private function processImages(): void
    {
        foreach ($this->images as $image) {
            $this->associate->images()->create([
                'image' => $this->saveImage($image),
                'associate_id' => $this->associate->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function create($room)
    {
        $this->validate();

        $newAssociate = $this->associate = $room->associates()->create([
            'negotiation_id' => $room->negotiation_id,
            'room_id' => $room->id,
            'subject_id' => $room->subject_id,
            'tenant_id' => $room->tenant_id,
            'user_id' => auth()->user()->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'race' => $this->race,
            'gender' => $this->gender,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
            'dob' => $this->dob,
            'age' => $this->age,
            'children' => $this->children,
            'veteran' => $this->veteran,
            'facebook_url' => $this->facebook_url,
            'x_url' => $this->x_url,
            'instagram_url' => $this->instagram_url,
            'youtube_url' => $this->youtube_url,
            'snapchat_url' => $this->snapchat_url,
            'notes' => $this->notes,
            'physical_description' => $this->physical_description,
            'substance_abuse' => $this->substance_abuse,
            'last_contacted_at' => $this->last_contacted_at,
            'relationship_to_subject' => $this->relationship_to_subject,
            'weapons' => $this->weapons,
            'highest_education' => $this->highest_education,
            'medical_issues' => $this->medical_issues,
            'mental_health_history' => $this->mental_health_history,
        ]);

        if ($this->images) {
            $this->processImages();
        }

        event(new AssociateEvent($room->id, $newAssociate->id, 'created'));
    }

    private function saveImage($image)
    {
        return $image->store('associates/'.$this->associate->id, 's3-public');
    }

    public function setForm(Associate $associate): void
    {
        $this->associate = $associate;
        $this->name = $associate->name;
        $this->phone = $associate->phone;
        $this->email = $associate->email;
        $this->race = $associate->race;
        $this->gender = $associate->gender;
        $this->address = $associate->address;
        $this->city = $associate->city;
        $this->state = $associate->state;
        $this->zipcode = $associate->zipcode;
        $this->dob = $associate->dob;
        $this->age = $associate->age;
        $this->children = $associate->children;
        $this->veteran = $associate->veteran;
        $this->facebook_url = $associate->facebook_url;
        $this->x_url = $associate->x_url;
        $this->instagram_url = $associate->instagram_url;
        $this->youtube_url = $associate->youtube_url;
        $this->snapchat_url = $associate->snapchat_url;
        $this->notes = $associate->notes;
        $this->physical_description = $associate->physical_description;
        $this->relationship_to_subject = $associate->relationship_to_subject;
        $this->weapons = $associate->weapons;
        $this->highest_education = $associate->highest_education;
        $this->medical_issues = $associate->medical_issues;
        $this->mental_health_history = $associate->mental_health_history;
        $this->substance_abuse = $associate->substance_abuse;
        $this->last_contacted_at = $associate->last_contacted_at;
    }

    private function processDocuments() {}
}
