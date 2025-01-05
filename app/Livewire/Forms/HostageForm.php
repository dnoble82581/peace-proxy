<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class HostageForm extends Form
{
    #[Validate(['required', 'integer'])]
    public $negotiation_id = '';

    #[Validate(['required', 'integer'])]
    public $subject_id = '';

    #[Validate(['required', 'integer'])]
    public $room_id = '';

    #[Validate(['required', 'integer'])]
    public $tenant_id = '';

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
    public $age = '';

    #[Validate(['nullable', 'integer'])]
    public $children = '';

    #[Validate(['nullable'])]
    public $veteran = '';

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
}
