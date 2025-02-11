@props(['message' => null, 'isOwnMessage' => false, 'isEmergent' => false])
<div class="flex items-start {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} gap-2.5">
	<div class="flex flex-col gap-1 w-full max-w-[340px]">
		<div class="flex items-center space-x-2 rtl:space-x-reverse">
			<span class="text-xs font-semibold text-gray-900 dark:text-slate-400">
                {{ $message->user->name }}
            </span>

			<span
					class="text-xs font-normal text-gray-500 dark:text-gray-400">
                {{ $message->created_at->diffForHumans() }}
            </span>
		</div>
		<div
				@php
					if($isOwnMessage){
						$messageClasses = 'bg-slate-100 dark:bg-slate-200';
					}else{
						$messageClasses = 'bg-sky-100 dark:bg-blue-200';
					}
				@endphp
				class="flex flex-col leading-1.5 p-4 border-gray-200
            rounded-e-xl rounded-es-xl relative {{ $messageClasses }}">

			<p class="text-sm font-normal text-gray-900">
				{{ $message->message }}
			</p>
			<div class="absolute bottom-0 right-3">
				<div class="space-x-2 rtl:space-x-reverse">
					<button>
						<x-heroicons::outline.hand-thumb-up class="w-4 h-4 text-teal-400 dark:text-teal-500" />
					</button>
					<button>
						<x-heroicons::outline.hand-thumb-down class="w-4 h-4 text-rose-400 dark:text-rose-500" />
					</button>
				</div>
			</div>
		</div>
		<div class="flex items-center justify-between">
			<span class="text-xs font-normal text-gray-500 dark:text-gray-400 capitalize">{{ $message->user->role }}</span>
			{{--			@if($message->responses()->count())--}}
			{{--				<button--}}
			{{--						wire:click="showResponses({{ $message->id }})"--}}
			{{--						type="button"--}}
			{{--						class="text-xs uppercase font-normal text-indigo-700 dark:text-emerald-400 mt-0.5"> {{ $message->responses()->count() }}--}}
			{{--					{{ $message->responses()->count() > 1 ? 'responses' : 'response' }}--}}
			{{--				</button>--}}
			{{--			@endif--}}
		</div>
	</div>
</div>