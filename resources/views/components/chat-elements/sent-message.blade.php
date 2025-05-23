@props(['message', 'userAvatarUrl', 'sentAt'])
<div>
	<div class="flex items-end justify-end">
		<div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
			<div>
				<span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">{{ $message }}</span>
			</div>
		</div>
		<img
				src='{{ $userAvatarUrl }}'
				alt="My profile"
				class="w-6 h-6 rounded-full order-2">
	</div>
	<span class="text-xs text-center px-4 text-gray-500 flex justify-end py-1">Sent {{ $sentAt->diffForHumans() }}</span>
</div>