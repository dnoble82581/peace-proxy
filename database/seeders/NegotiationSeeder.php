<?php

namespace Database\Seeders;

use App\Models\Associate;
use App\Models\CallLog;
use App\Models\Demand;
use App\Models\Hook;
use App\Models\MoodLog;
use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
use App\Models\Trigger;
use App\Models\User;
use App\Models\Warrant;
use Exception;
use Illuminate\Database\Seeder;

class NegotiationSeeder extends Seeder
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
        $negotiations = Negotiation::factory(20)->make()->each(function ($negotiation) use ($tenants, $allUsers) {
            $negotiation->tenant_id = $tenants->random()->id; // Randomly assign tenant
            $negotiation->user_id = $allUsers->random()->id; // Randomly assign user
            $negotiation->subject_motivation = fake()->paragraph();
            $negotiation->initial_complaint = fake()->paragraph();
            $negotiation->initial_complainant = fake()->name();
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
                'name' => fake()->name(),
                'room_id' => $room->id,
                'tenant_id' => $room->tenant_id,
            ]);

            MoodLog::factory(30)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
                'room_id' => $room->id,
                'negotiation_id' => $negotiation->id,
            ]);

            CallLog::factory(30)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
                'room_id' => $room->id,
                'negotiation_id' => $negotiation->id,
            ]);

            // Link the subject to the room
            $room->update(['subject_id' => $subject->id]);

            // Create hooks
            Hook::factory(4)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
            ]);

            Associate::factory(4)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
                'room_id' => $room->id,
                'negotiation_id' => $negotiation->id,
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

            Warrant::factory(4)->create([
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
            'privileges' => 'Web Master',
            'tenant_id' => null,
        ]);

    }
}
