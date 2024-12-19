<?php

namespace Database\Seeders;

use App\Models\CallLog;
use App\Models\Demand;
use App\Models\Hook;
use App\Models\MoodLog;
use App\Models\Trigger;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        User::factory(10)->create(['tenant_id' => 5]);
        User::factory(10)->create(['tenant_id' => 6]);
        User::factory(10)->create(['tenant_id' => 7]);
        User::factory(10)->create(['tenant_id' => 8]);
        User::factory(10)->create(['tenant_id' => 9]);
        User::factory(10)->create(['tenant_id' => 10]);

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
        Hook::factory(15)->create([
            'subject_id' => 1, 'tenant_id' => 5,
        ]);
        Trigger::factory(15)->create([
            'subject_id' => 1, 'tenant_id' => 5,
        ]);
        MoodLog::factory(20)->create(['subject_id' => 1, 'tenant_id' => 5, 'room_id' => 1, 'negotiation_id' => 1]);
        CallLog::factory(20)->create(['subject_id' => 1, 'tenant_id' => 5, 'room_id' => 1, 'negotiation_id' => 1]);
        Demand::factory(10)->create([
            'subject_id' => 1, 'tenant_id' => 5, 'room_id' => 1, 'negotiation_id' => 1, 'user_id' => 28,
        ]);

    }
}
