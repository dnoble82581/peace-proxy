<?php

	use App\Models\Room;
	use App\Models\Subject;
	use Illuminate\Foundation\Application;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Routing\Redirector;
	use Livewire\Volt\Component;

	new class extends Component {
		public Room $room;
		public Subject $subject;

		public function mount(Room $room):void
		{
			$this->room = $room;
			$this->subject = $this->getSubject();
		}

		public function showWarrants():void
		{
			$this->dispatch('modal.open', component: 'modals.show-warrants',
				arguments: ['subjectId' => $this->subject->id]);
		}

		private function getSubject():Subject
		{
			return $this->room->subject;
		}

		public function addWarrant():void
		{
			$this->dispatch('modal.open', component: 'modals.add-warrant-form',
				arguments: ['subjectId' => $this->subject->id]);
		}

		public function getListeners():array
		{
			return [
				"echo-presence:chart.{$this->room->id},ChartUpdatedEvent" => 'refresh',
			];
		}
	}
?>

<div
		x-data="{ card: 'general'}"
		class="rounded-lg bg-white dark:bg-gray-800 relative flex-1">
	<div class="px-4">
		<div class="">
			<div class="grid grid-cols-1 sm:hidden">
				<!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
				<select
						aria-label="Select a tab"
						class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
					<option>Subject</option>
					<option>Negotiation</option>
					<option>Weapons</option>
					<option>Mental Health</option>
				</select>
			</div>
			<div class="hidden sm:block">
				<div class="border-b border-gray-200">
					<nav
							class="-mb-px flex space-x-8"
							aria-label="Tabs">
						<button
								@click="card = 'general'"
								type="button"
								class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
								:class="card === 'general' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'"
						>
							<svg
									:class="card === 'general' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'"
									class="-ml-0.5 mr-2 size-5 text-gray-400 group-hover:text-gray-500"
									viewBox="0 0 20 20"
									fill="currentColor"
									aria-hidden="true"
									data-slot="icon">
								<path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
							</svg>
							<span>Subject</span>
						</button>
						<button
								@click="card = 'warrants'"
								type="button"
								class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
								:class="card === 'warrants' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
							<x-heroicons::micro.solid.exclamation-circle class="h-5 w-5" />
							<span class="dark-light-text">Warrants({{ $subject->warrants->count() }})</span>
						</button>
						<button
								@click="card = 'warnings'"
								type="button"
								class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
								:class="card === 'warnings' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
							<x-heroicons::micro.solid.shield-exclamation class="h-5 w-5" />
							<span class="dark-light-text">Warnings({{ $subject->warnings->count() }})</span>
						</button>
						<button
								@click="card = 'documents'"
								type="button"
								class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
								:class="card === 'documents' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
							<x-heroicons::micro.solid.paper-clip class="h-5 w-5" />
							<span class="dark-light-text">Documents({{ $subject->documents->count() }})</span>
						</button>
						<button
								@click="card = 'social-media'"
								type="button"
								class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
								:class="card === 'social-media' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
							<x-heroicons::micro.solid.code-bracket-square class="h-5 w-5" />
							<span class="">Social({{ $subject->documents->count() }})</span>
						</button>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="h-48 p-2 overflow-y-auto overflow-x-hidden">
		<div
				x-show="card === 'general'"
				class="rounded-lg dark:bg-gray-800">
			<livewire:cards.subject-card :subject="$subject" />
		</div>
		<div
				x-show="card === 'warrants'"
				class="rounded-lg dark:bg-gray-800">
			<livewire:cards.warrants-card :subject="$subject" />
		</div>
		<div
				x-show="card === 'warnings'">
			<div class="h-48">
				<livewire:cards.warnings-card :subject="$subject" />
			</div>
		</div>
		<div
				x-show="card === 'documents'">
			<div class="h-48">
				<livewire:cards.documents-card :subject="$subject" />
			</div>
		</div>
		<div
				class=""
				x-show="card === 'social-media'">
			<div class="py-5 sm:p-6 h-48">
				<livewire:cards.social-card :subject="$subject" />
			</div>
		</div>
	</div>
</div>

