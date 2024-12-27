<?php

namespace App\Livewire\Forms;

use App\Models\Subject;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SubjectForm extends Form
{
    public ?Subject $subject;

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
    public $zip = '';

    #[Validate(['nullable', 'date'])]
    public $date_of_birth = '';

    #[Validate(['nullable', 'integer'])]
    public $age = '';

    #[Validate(['nullable', 'integer'])]
    public $children = '';

    #[Validate(['nullable'])]
    public $veteran = '';

    #[Validate(['nullable'])]
    public $highest_education = '';

    #[Validate(['nullable'])]
    public $substance_abuse = '';

    #[Validate(['nullable'])]
    public $mental_health_history = '';

    #[Validate(['nullable'])]
    public $physical_description = '';

    #[Validate(['nullable'])]
    public $notes = '';

    #[Validate(['nullable'])]
    public $facebook_url = '';

    #[Validate(['nullable'])]
    public $x_url = '';

    #[Validate(['nullable'])]
    public $instagram_url = '';

    #[Validate(['nullable'])]
    public $snapchat_url = '';

    public function setForm($subject): void
    {
        $this->subject = $subject;
        $this->name = $this->subject->name;
        $this->phone = $this->subject->phone;
        $this->email = $this->subject->email;
        $this->race = $this->subject->race;
        $this->gender = $this->subject->gender;
        $this->address = $this->subject->address;
        $this->city = $this->subject->city;
        $this->state = $this->subject->state;
        $this->zip = $this->subject->zip;
        $this->date_of_birth = $this->subject->date_of_birth;
        $this->age = $this->subject->age;
        $this->children = $this->subject->children;
        $this->veteran = $this->subject->veteran;
        $this->highest_education = $this->subject->highest_education;
        $this->substance_abuse = $this->subject->substance_abuse;
        $this->mental_health_history = $this->subject->mental_health_history;
        $this->physical_description = $this->subject->physical_description;
        $this->notes = $this->subject->notes;
        $this->facebook_url = $this->subject->facebook_url;
        $this->x_url = $this->subject->x_url;
        $this->instagram_url = $this->subject->instagram_url;
        $this->snapchat_url = $this->subject->snapchat_url;
    }

    public function update()
    {
        if ($this->images) {
            $this->processImages();
        }
        $this->subject->update($this->all());
    }

    private function processImages()
    {
        foreach ($this->images as $image) {
            $this->subject->images()->create([
                'image' => $this->saveImage($image),
                'subject_id' => $this->subject->id,
            ]);
        }
    }

    private function saveImage($image)
    {
        return $image->store('subjects', 's3-public');
    }
}
