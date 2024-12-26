<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SubjectForm extends Form
{
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

    #[Validate(['required', 'integer'])]
    public $room_id = '';

    #[Validate(['required', 'integer'])]
    public $tenant_id = '';
}
