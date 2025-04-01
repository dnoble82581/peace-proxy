@php use App\Models\User;use Illuminate\Support\Carbon; @endphp
<x-app-layout>
	<div class="maxw6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

		<a
				href="{{ route('download-pdf', $negotiation->id) }}"
				class="mt-4 bg-blue-500 text-white px-4 py-2 rounded inline-block mb-8">
			Download PDF
		</a>


		<ol class="relative border-s border-gray-200 dark:border-gray-700">
			@foreach($negotiation->logs as $log)
				<li class="mb-10 ms-4">
					<div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
					<time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
						{{ $log->created_at }}
					</time>
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
						{{ $log->action }}
						<x-dividers.dot-divider />
						<span class="text-gray-400 text-sm dark:text-gray-500">{{ $log->user->name ?? 'Unknown User' }}</span>
					</h3>

					@php
						// Define CSS classes or behavior based on the action type
						$logStyle = match ($log->action) {
							'Hook Created', 'Trigger Created' => '',
							'Hook Deleted', 'Trigger Deleted' => 'line-through',
							default => '',
						};
					@endphp

					@if(in_array($log->action, ['Hook Created', 'Trigger Created']))
						{{-- Display creation log --}}
						<p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 flex items-center space-x-2">
							<span class="capitalize">{{ $log->data['title'] }}</span>
							<x-dividers.dot-divider /> {{-- Custom Blade Component --}}
							<span class="capitalize">{{ $log->data['description'] }}</span>
						</p>
					@elseif(in_array($log->action, ['Hook Deleted', 'Trigger Deleted']))
						{{-- Display deletion log --}}
						<p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 flex items-center space-x-2 {{ $logStyle }}">
							<span class="capitalize">{{ $log->data['title'] }}</span>
							<x-dividers.dot-divider />
							<span class="capitalize">{{ $log->data['description'] }}</span>
						</p>
					@elseif(in_array($log->action, ['Hook Updated', 'Trigger Updated']))
						{{-- Display update log --}}
						<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
							<div>
								<p class="flex items-center gap-2">
									From
									<x-dividers.dot-divider />
									{{ $log->data['old']['title'] }}
									<x-dividers.dot-divider />
									<span class="inline font-normal">{{ $log->data['old']['description'] }}</span>
								</p>
							</div>
							<div>
								<p class="flex items-center gap-2">
									To
									<x-dividers.dot-divider />
									{{ $log->data['new']['title'] }}
									<x-dividers.dot-divider />
									<span class="inline font-normal">{{ $log->data['new']['description'] }}</span>
								</p>
							</div>
						</div>
					@elseif($log->action === 'Demand Updated')
						<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
							<div>
								<p class="flex items-center gap-2">
									From
									<x-dividers.dot-divider />
									{{ $log->data['old']['title'] }}
									<x-dividers.dot-divider />
									<span class="inline font-normal">{{ Carbon::parse($log->data['new']['deadline'])->format('d-m-Y H:i') }}</span>
								</p>
							</div>
							<div>
								<p class="flex items-center gap-2">
									To
									<x-dividers.dot-divider />
									{{ $log->data['new']['title'] }}
									<x-dividers.dot-divider />
									<span class="inline font-normal">{{ Carbon::parse($log->data['new']['deadline'])->format('d-m-Y H:i') }}</span>
								</p>
							</div>
						</div>
					@elseif($log->action === 'Demand Created' || $log->action === 'Demand Deleted')
						@php
							$formattedDeadline = \Carbon\Carbon::parse($log->data['deadline'])->format('d-m-Y H:i');
						@endphp
						<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
							<div>
								<p class="text-sm flex items-center gap-2 {{ $log->action === 'Demand Deleted' ? 'line-through' : '' }}">
									{{ $log->data['title'] }}
									<x-dividers.dot-divider />
									<span class="inline font-normal">{{ $formattedDeadline }}</span>
								</p>
							</div>
						</div>
					@elseif($log->action === 'Message Created')
						@php
							$to = $log->data['recipient'] ?? 'Public';
						@endphp
						{{-- Dynamic handling for new entities --}}
						<div class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">
							<div>
								<p class="font-semibold flex items-center gap-2">
									{{ is_string($to) ? $to : $to->name }}
								</p>
							</div>
							<div>
								<p>
									{{ $log->data['message'] }}
								</p>
							</div>
						</div>
					@elseif($log->action === 'Mood Log Created')
						<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
							<div>
								<p class="flex items-center text-sm gap-2">
									{{ $log->data['name'] }}
								</p>
							</div>
						</div>
					@elseif($log->action === 'Call Log Created')
						<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
							<div class="flex items-center gap-2 text-sm">
								<p class="flex items-center gap-2">
									Began:
									{{ Carbon::parse($log->data['started_at'])->format('g:ia')  }}
								</p>
								<x-dividers.dot-divider />
								<p class="flex items-center gap-2">
									Ended:
									{{ Carbon::parse($log->data['started_at'])->format('g:ia')  }}
								</p>
								<x-dividers.dot-divider />
								<p class="flex items-center gap-2">
									Duration:
									{{ $log->data['duration'] }} Seconds
								</p>
							</div>
						</div>
					@elseif($log->action === 'Objective Updated' || $log->action === 'Objective Created' || $log->action === 'Objective Deleted')
						@if($log->action === 'Objective Updated')
							<div>
								<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
									Old
									<x-dividers.dot-divider />
									{{ $log->data['old']['objective'] }} {{ $log->data['old']['status'] }} {{ $log->data['old']['priority'] }}
								</p>
							</div>
							<div>
								<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
									New
									<x-dividers.dot-divider />
									{{ $log->data['new']['objective'] }} {{ $log->data['new']['status'] }} {{ $log->data['new']['priority'] }}
								</p>
							</div>
						@else
							<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
								<div>
									<p class="text-sm flex items-center gap-2 {{ $log->action === 'Objective Deleted' ? 'line-through' : '' }}">
										{{ $log->data['objective'] }}
									</p>
								</div>
							</div>
						@endif
					@elseif($log->action === 'Request For Information Updated' || $log->action === 'Request For Information Created' || $log->action === 'Request For Information Deleted')
						@if($log->action === 'Request For Information Updated')
							<div>
								<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
									Old
									<x-dividers.dot-divider />
									{{ $log->data['old']['request'] }}
								</p>
							</div>
							<div>
								<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
									New
									<x-dividers.dot-divider />
									{{ $log->data['new']['request'] }}
								</p>
							</div>
						@else
							<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
								<div>
									<p class="text-sm flex items-center gap-2 {{ $log->action === 'Request For Information Deleted' ? 'line-through' : '' }}">
										{{ $log->data['request'] }}
									</p>
								</div>
							</div>
						@endif
					@elseif($log->action === 'Subject Updated' || $log->action === 'Subject Created' || $log->action === 'Subject Deleted')
						@if($log->action === 'Subject Updated')
							<div>
								@foreach($log->data['new'] as $key => $newValue)
									@php
										$newValue = $log->data['new'][$key] ?? null;
									@endphp

									<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
										<span>New: {{ $newValue }}</span>
									</p>
								@endforeach
							</div>
						@else
							<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
								<div>
									<p class="text-sm flex items-center gap-2 {{ $log->action === 'Subject Deleted' ? 'line-through' : '' }}">
										{{ $log->data['name'] ?? 'Unknown' }}
									</p>
								</div>
							</div>
						@endif
					@elseif($log->action === 'Warning Updated' || $log->action === 'Warning Created' || $log->action === 'Warning Deleted')
						@if($log->action === 'Warning Updated')
							<div>
								@foreach($log->data['new'] as $key => $newValue)
									@php
										$newValue = $log->data['new'][$key] ?? null;
									@endphp

									<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
										<span>New: {{ $newValue }}</span>
									</p>
								@endforeach
							</div>
						@else
							<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
								<div>
									<p class="text-sm flex items-center gap-2 {{ $log->action === 'Warning Deleted' ? 'line-through' : '' }}">
										{{ $log->data['warning'] ?? 'Unknown' }}
									</p>
								</div>
							</div>
						@endif
					@elseif($log->action === 'Warrant Updated' || $log->action === 'Warrant Created' || $log->action === 'Warrant Deleted')
						@if($log->action === 'Warrant Updated')
							<div>
								@foreach($log->data['new'] as $key => $newValue)
									@php
										$newValue = $log->data['new'][$key] ?? null;
									@endphp

									<p class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
										<span>New: {{ $newValue }}</span>
									</p>
								@endforeach
							</div>
						@else
							<div class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
								<div>
									<p class="text-sm flex items-center gap-2 {{ $log->action === 'Warrantd Deleted' ? 'line-through' : '' }}">
										{{ $log->data['offense'] ?? 'Unknown' }}
									</p>
								</div>
							</div>
						@endif
					@else
						{{-- Fallback in case of unknown actions --}}
						<p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
							{{ __('Action not recognized: :action', ['action' => $log->action]) }}
						</p>
					@endif
				</li>
			@endforeach
		</ol>
	</div>
</x-app-layout>