<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $tenants = Tenant::factory(10)->create();

		foreach ($tenants as $tenant) {
			User::factory(10)->create(['tenant_id' => $tenant->id]);
		}
    }
}
