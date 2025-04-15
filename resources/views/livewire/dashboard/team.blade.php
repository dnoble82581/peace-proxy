<?php

	use App\Models\User;
	use Illuminate\Support\Collection;
	use Livewire\WithPagination;


	new class extends \Livewire\Volt\Component {
		public Collection $users;

		public function mount()
		{
			$this->users = User::all();
		}

	}

?>

<div>
	<flux:table>
		<flux:table.columns>
			<flux:table.column>Customer</flux:table.column>
			<flux:table.column>Date</flux:table.column>
			<flux:table.column>Status</flux:table.column>
			<flux:table.column>Amount</flux:table.column>
		</flux:table.columns>

		<flux:table.rows>
			@foreach ($users as $user)
				<flux:table.row>
					<flux:table.cell>{{ $user->name }}</flux:table.cell>
					<flux:table.cell>{{ $user->created_at }}</flux:table.cell>
					<flux:table.cell>
						<flux:badge
								color="green"
								size="sm"
								inset="top bottom">Active
						</flux:badge>
					</flux:table.cell>
					<flux:table.cell variant="strong">$49.00</flux:table.cell>
				</flux:table.row>
			@endforeach
		</flux:table.rows>
	</flux:table>
</div>
