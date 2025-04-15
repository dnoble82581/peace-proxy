<?php

	namespace App\Policies;

	use App\Models\Tenant;
	use App\Models\User;
	use Illuminate\Auth\Access\HandlesAuthorization;

	class TenantPolicy
	{
		use HandlesAuthorization;

		public function viewAny(User $user)
		{

		}

		public function view(User $user, Tenant $tenant) {}

		public function create(User $user) {}

		public function update(User $user, Tenant $tenant) {}

		public function delete(User $user, Tenant $tenant) {}

		public function restore(User $user, Tenant $tenant) {}

		public function forceDelete(User $user, Tenant $tenant) {}
	}
