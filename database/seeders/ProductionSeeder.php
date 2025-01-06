<?php

namespace Database\Seeders;

use App\Models\CallLog;
use App\Models\Demand;
use App\Models\Hook;
use App\Models\Hostage;
use App\Models\MoodLog;
use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
use App\Models\Trigger;
use App\Models\User;
use App\Models\Warrant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Create tenants
        $tenants = Tenant::factory(5)->create();

        // Create users
        $allUsers = $tenants->flatMap(function ($tenant) {
            return User::factory(rand(1, 50))->create(['tenant_id' => $tenant->id]);
        });

        // Create negotiations
        $negotiations = Negotiation::factory(10)->make()->each(function ($negotiation) use ($tenants, $allUsers) {
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

            Hostage::factory(4)->create([
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

            Hostage::factory(4)->create([
                'subject_id' => $subject->id,
                'tenant_id' => $room->tenant_id,
                'room_id' => $room->id,
                'negotiation_id' => $negotiation->id,
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

        User::factory()->create([
            'name' => 'Clayton Penrod',
            'email' => 'cpenrod@coralville.org',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Negotiator',
            'tenant_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Chris Kapfer',
            'email' => 'ckapfer@coralville.org',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Negotiator',
            'tenant_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Austin Jiras',
            'email' => 'ajiras@johnsoncountyiowa.gov',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Negotiator',
            'tenant_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Scott Sammons',
            'email' => 'ssammons@johnsoncountyiowa.gov',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Negotiator',
            'tenant_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Steven Nash',
            'email' => 'snash@johnsoncountyiowa.gov',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Negotiator',
            'tenant_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Katrina Rudish',
            'email' => 'krudish@johnsoncountyiowa.gov',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => null,
            'status' => true,
            'title' => 'Negotiator',
            'tenant_id' => 1,
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create([
            'name' => 'chat',
        ]);
        Permission::create([
            'name' => 'post',
        ]);
        Permission::create([
            'name' => 'request',
        ]);

        $role = Role::create([
            'name' => 'admin',
        ])->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'team-coordinator',
        ])->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'team-leader',
        ])->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'primary-negotiator',
        ])->givePermissionTo(['chat']);

        $role = Role::create([
            'name' => 'secondary-negotiator',
        ])->givePermissionTo(['chat']);

        $role = Role::create([
            'name' => 'recorder',
        ])->givePermissionTo(['post']);

        $role = Role::create([
            'name' => 'intelligence-coordinator',
        ])->givePermissionTo(['request', 'post']);

        $role = Role::create([
            'name' => 'mental-health-coordinator',
        ]);

        $role = Role::create([
            'name' => 'tactical-lead',
        ])->givePermissionTo(['chat', 'post']);
    }
}
