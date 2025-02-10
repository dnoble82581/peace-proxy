<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(
            [
                'name' => 'Team Coordinator',
                'description' => 'Coordinates the response to a crisis incident.',
            ]
        );
        Role::create([
            'name' => 'Team Leader',
            'description' => 'Leads a team of responders.',
        ]);
        Role::create([
            'name' => 'Primary Negotiator',
            'description' => 'Establishes contact with the subject.',
        ]);
        Role::create([
            'name' => 'Secondary Negotiator',
            'description' => 'Supports the primary negotiator as coach.',
        ]);
        Role::create([
            'name' => 'Recorder',
            'description' => 'Maintains the incident information and monitors negotiation.',
        ]);
        Role::create([
            'name' => 'Intelligence Coordinator',
            'description' => 'Generates intelligence leads (interviews, follow-up, pursuit of investigative leads',
        ]);
        Role::create([
            'name' => 'Mental Health Coordinator',
            'description' => 'Provides support to the team in the development of a mental health plan.',
        ]);
        Role::create([
            'name' => 'Tactical User',
            'description' => 'Member of the entry/tactical team.',
        ]);
        Role::create([
            'name' => 'Tactical Lead',
            'description' => 'Tactical team lead.',
        ]);
        Role::create([
            'name' => 'Incident Command',
            'description' => 'Incident commander is responsible for the overall response to the incident and approves all actions.',
        ]);
    }
}
