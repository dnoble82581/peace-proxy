<?php

namespace App\Livewire\Forms;

use App\Models\Hostage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class HostageForm extends Form
{
    public ?Hostage $hostage;

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
    public $last_contacted_at = '';

    public function update()
    {
        $this->validate();

        if ($this->images) {
            $this->processImages();
        }
        //        if ($this->documentsToUpload) {
        //            $this->processDocuments();
        //        }

        $this->hostage->update($this->all());
    }

    private function processImages(): void
    {
        foreach ($this->images as $image) {
            $this->hostage->images()->create([
                'image' => $this->saveImage($image),
                'hostage_id' => $this->hostage->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function create($room)
    {
        $this->validate();

        $this->hostage = $room->hostages()->create([
            'negotiation_id' => $room->negotiation_id,
            'room_id' => $room->id,
            'subject_id' => $room->subject_id,
            'tenant_id' => $room->tenant_id,
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
    }

    private function saveImage($image)
    {
        return $image->store('hostages/'.$this->hostage->id, 's3-public');
    }

    public function setForm(Hostage $hostage): void
    {
        $this->hostage = $hostage;
        $this->name = $hostage->name;
        $this->phone = $hostage->phone;
        $this->email = $hostage->email;
        $this->race = $hostage->race;
        $this->gender = $hostage->gender;
        $this->address = $hostage->address;
        $this->city = $hostage->city;
        $this->state = $hostage->state;
        $this->zipcode = $hostage->zipcode;
        $this->dob = $hostage->dob;
        $this->age = $hostage->age;
        $this->children = $hostage->children;
        $this->veteran = $hostage->veteran;
        $this->facebook_url = $hostage->facebook_url;
        $this->x_url = $hostage->x_url;
        $this->instagram_url = $hostage->instagram_url;
        $this->youtube_url = $hostage->youtube_url;
        $this->snapchat_url = $hostage->snapchat_url;
        $this->notes = $hostage->notes;
        $this->physical_description = $hostage->physical_description;
        $this->relationship_to_subject = $hostage->relationship_to_subject;
        $this->weapons = $hostage->weapons;
        $this->highest_education = $hostage->highest_education;
        $this->medical_issues = $hostage->medical_issues;
        $this->mental_health_history = $hostage->mental_health_history;
        $this->substance_abuse = $hostage->substance_abuse;
        $this->last_contacted_at = $hostage->last_contacted_at;
    }

    private function processDocuments() {}
}
