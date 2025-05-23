@props(['message', 'userAvatarUrl', 'sentAt'])
<div class="">
	<div class="flex items-center space-x-2">
		<div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
			<div>
				<span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">{{ $message }}</span>
			</div>
		</div>
		<img
				src="{{ $userAvatarUrl }}"
				alt="My profile"
				class="w-6 h-6 rounded-full order-1">
	</div>
	<span class="text-xs text-center px-4 text-gray-500">Sent {{ $sentAt->diffForHumans() }}</span>
</div>
