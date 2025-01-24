<div class="px-5 mt-5 ">
	{{-- Grid container for filtering and search controls --}}
	<div class="grid grid-cols-6 gap-4">
		{{-- Dropdown for selecting number of items displayed per page --}}
		<div class="col-span-1">
			<x-select
					label="Per Page"
					placeholder="Select one status"
					:options="[10, 15, 20, 25, 30]"
					{{-- Options for pagination --}}
					wire:model.live="perPage" {{-- Livewire model binding for real-time updates --}}
			/>
		</div>

		{{-- Dropdown for selecting a tenant (only visible to super users) --}}
		@if($super)
			<div class="col-span-2">
				<x-select
						label="Search Tenants"
						placeholder="Search Tenants"
						{{-- Dropdown placeholder --}}
						wire:model.live="selectedTenant"
						{{-- Livewire model binding --}}
						:async-data="route('api.tenants.index')"
						{{-- Async data loading from tenants API --}}
						option-label="name"
						{{-- Label field for options --}}
						option-value="id"
						{{-- Value field for options --}}
						:searchable="true"
						{{-- Enable search within the dropdown --}}
						:clearable="false"
						{{-- Allow clearing the selected option --}}
						:show-labels="false"
						{{-- Hide dropdown labels --}}
						:show-all-options="false"
						{{-- Do not preload options --}}
						:show-search-icon="true"
						{{-- Show search icon in the dropdown --}}
						:show-clear-icon="false"
						{{-- Show clear icon to reset selection --}}
						:show-no-options-text="true"
						{{-- Show text when no options available --}}
						:no-options-text="__('No Tenants Found')"
						{{-- Text for unavailable options --}}
						:no-search-results-text="__('No Tenants Found')" {{-- Text for no results --}}
				/>
			</div>
		@endif

		{{-- Text input for searching users --}}
		<div class="col-span-2">
			<x-form-elements.text-input
					wire:model.live="search"
					{{-- Livewire model binding for search input --}}
					label="Search"
					id="search"
					name="search"
					placeholder="Search" {{-- Input placeholder --}}
			/>
		</div>
	</div>

	{{-- Table displaying list of users --}}
	<table class="min-w-full mt-6 ">
		{{-- Table header containing sortable columns --}}
		<thead>
		<tr>
			{{-- Column: Name --}}
			<x-table-elements.sortable-column
					label="Name"
					value="name"
					:canSort="true"
					{{-- Column is sortable --}}
					:sortField="$sortField"
					{{-- Current sorting field --}}
					:sortAsc="$sortAsc" {{-- Determines sorting direction --}}
			/>
			{{-- Column: Title --}}
			<x-table-elements.sortable-column
					label="Title"
					value="title"
					:canSort="true"
					:sortField="$sortField"
					:sortAsc="$sortAsc"
			/>
			{{-- Column: Status --}}
			<x-table-elements.sortable-column
					label="Status"
					value="status"
					:canSort="false"
					{{-- Column is not sortable --}}
					:sortField="$sortField"
					:sortAsc="$sortAsc"
			/>
			{{-- Column: Role --}}
			<x-table-elements.sortable-column
					label="Role"
					value="role"
					:canSort="true"
					:sortField="$sortField"
					:sortAsc="$sortAsc"
			/>
			{{-- Column: Application --}}
			<x-table-elements.sortable-column
					label="Application"
					value="application"
					:canSort="false"
					:sortField="$sortField"
					:sortAsc="$sortAsc"
			/>
			{{-- Add Team Member Button --}}
			<th class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                <span class="flex rounded-md justify-end">
                    <x-links.primary-solid-link
		                    href="{{ route('create.user') }}"
		                    {{-- Link to create a new team member --}}
		                    :value="__('Add Team Member')" {{-- Button text --}}
                    />
                </span>
			</th>
		</tr>
		</thead>

		{{-- Table body with user data --}}
		<tbody class="bg-white dark:bg-gray-800">
		@foreach($users as $user)
			<tr wire:key="{{$user->id}}">
				{{-- User Avatar, Name, and Email --}}
				<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
					<div class="flex items-center">
						{{-- User avatar --}}
						<div class="flex-shrink-0 h-10 w-10">
							<img
									class="h-10 w-10 rounded-full"
									src="{{$user->avatarUrl()}}"
									alt="">
						</div>
						{{-- User name and impersonate button --}}
						<div class="ml-4">
							<div>
                                <span
		                                class="text-sm leading-5 font-medium text-gray-900 dark:text-slate-300">
                                    {{$user->name}}
                                </span>
								{{-- Impersonation functionality --}}
								@if($super)
									<button
											wire:click="impersonate({{$user->id}})"
											class="text-xs text-indigo-600 ml-1">Impersonate
									</button>
								@endif
							</div>
							{{-- User email --}}
							<div class="text-sm leading-5 text-gray-500">
								{{$user->email}}
							</div>
						</div>
					</div>
				</td>

				{{-- Title and Department --}}
				<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
					<div class="text-sm leading-5 text-gray-900 dark:text-slate-300">{{$user->title}}</div>
					{{--					<div class="text-sm leading-5 text-gray-500">{{$user->department}}</div>--}}
				</td>

				{{-- Status Badge --}}
				<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
					@if($user->status)
						{{-- Active status --}}
						<span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Active</span>
					@else
						{{-- Inactive status --}}
						<span class="inline-flex items-center rounded-md bg-pink-100 px-2 py-1 text-xs font-medium text-pink-700">Inactive</span>
					@endif
				</td>

				{{-- User Role --}}
				<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 dark:text-slate-300">
					{{$user->role}}
				</td>

				{{-- Application Link --}}
				<td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
					<div class="flex justify-center">
						{{-- Check for associated application and display a link --}}
						@if($application = $user->documents->firstWhere('type', 'form'))
							<a
									href="{{$application->privateUrl()}}"
									target="_blank">
								{{-- Icon for downloading the application --}}
								<svg
										class="h-8 w-8"
										fill="currentColor"
										viewBox="0 0 20 20">
									<path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
									<path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
								</svg>
							</a>
						@endif
					</div>
				</td>

				{{-- Actions: Edit and Delete Buttons --}}
				<td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
					<div class="flex items-center gap-5 justify-end">

						{{-- Super Admin Actions (Edit & Delete) --}}
						@if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
							<a
									href="{{ route('edit.user', $user->id) }}"
									class="text-indigo-600 hover:text-indigo-900">
								<x-heroicons::mini.solid.pencil-square class="w-5 h-5 fill-blue-400" />
							</a>
							<button
									wire:click="deleteUser({{$user->id}})"
									class="text-indigo-600 hover:fill-indigo-900">
								<x-heroicons::mini.solid.trash class="w-5 h-5 fill-rose-300" />
							</button>
						@endif
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	{{-- Pagination for the users table --}}
	<div class="mt-5">
		{{ $users->links() }}
	</div>
</div>