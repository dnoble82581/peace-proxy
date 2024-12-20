<?php

namespace Database\Seeders;

use App\Models\Demand;
use App\Models\Hook;
use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
use App\Models\Trigger;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @throws Exception
     */
    public function run(): void
    {
        // Create tenants
        $tenants = Tenant::factory(10)->create();

        // Create users
        $allUsers = $tenants->flatMap(function ($tenant) {
            return User::factory(rand(1, 50))->create(['tenant_id' => $tenant->id]);
        });

        // Create negotiations
        $negotiations = Negotiation::factory(100)->make()->each(function ($negotiation) use ($tenants, $allUsers) {
            $negotiation->tenant_id = $tenants->random()->id; // Randomly assign tenant
            $negotiation->user_id = $allUsers->random()->id; // Randomly assign user
            $negotiation->save();
        });

        // Create rooms, subjects, hooks, triggers, and demands
        $negotiations->each(function ($negotiation) {
            // Create a room
            $room = Room::factory()->create([
                'negotiation_id' => $negotiation->id,
                'tenant_id' => $negotiation->tenant_id,
                'subject_id' => null,
            ]);

            // Create a subject
            $subject = Subject::factory()->create([
                'room_id' => $room->id,
                'tenant_id' => $room->tenant_id,
            ]);

            // Link the subject to the room
            $room->update(['subject_id' => $subject->id]);

            // Create hooks
            Hook::factory(4)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
            ]);

            // Create triggers
            Trigger::factory(4)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
            ]);

            // Create demands
            Demand::factory(4)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
            ]);
        });

        // Create a predefined super admin user
        User::factory()->create([
            'name' => 'Dusty Noble',
            'email' => 'dnoble@johnsoncountyiowa.gov',
            'role' => 'super_admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Web Master',
            'tenant_id' => null,
        ]);
    }
}
