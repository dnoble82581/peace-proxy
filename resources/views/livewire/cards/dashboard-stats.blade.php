<?php

use App\Models\Negotiation;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {

    public function users():int
    {
        return User::count();
    }

    public function negotiations()
    {
        return Negotiation::count();
    }

}


?>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
	<div class="divide-y divide-gray-200 overflow-hidden rounded-lg col-span-2 shadow-lg">
		<div class="px-4 py-5 sm:px-6 bg-violet-400">
			<h2 class="text-xl">
				Your Team
			</h2>
		</div>
		<div class="px-4 py-5 sm:p-6 bg-violet-200">
			<p class="text-3xl text-center">
				{{ $this->users() }}
			</p>
		</div>
	</div>
	<div class="divide-y divide-gray-200 overflow-hidden rounded-lg col-span-2 shadow-lg">
		<div class="px-4 py-5 sm:px-6 bg-teal-400">
			<h2 class="text-xl">
				Your Team
			</h2>
		</div>
		<div class="px-4 py-5 sm:p-6 bg-teal-200">
			<p class="text-3xl text-center">
				{{ $this->users() }}
			</p>
		</div>
	</div>
	<div class="divide-y divide-gray-200 overflow-hidden rounded-lg col-span-2 shadow-lg">
		<div class="px-4 py-5 sm:px-6 bg-blue-400">
			<h2 class="text-xl">
				Your Team
			</h2>
		</div>
		<div class="px-4 py-5 sm:p-6 bg-blue-200">
			<p class="text-3xl text-center">
				{{ $this->users() }}
			</p>
		</div>
	</div>
	<div class="divide-y divide-gray-200 overflow-hidden rounded-lg col-span-2 shadow-lg">
		<div class="px-4 py-5 sm:px-6 bg-blue-400">
			<h2 class="text-xl">
				Your Negotiations
			</h2>
		</div>
		<div class="px-4 py-5 sm:p-6 bg-blue-200">
			<p class="text-3xl text-center">
				{{ $this->negotiations() }}
			</p>
		</div>
	</div>
</div>
