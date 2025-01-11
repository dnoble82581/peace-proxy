@props(['subject'])
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 p-3">
	@if(isset($subject->facebook_url))
		<div class="flex items-center justify-between border border-gray-200 rounded-md p-2 mt-4">
			<div>
				<x-svg-images.social.facebook-icon class="w-6 h-6" />
			</div>
			<div><span class="text-sm dark-light-text">Facebook</span></div>
			<div>
				<x-dropdown.dropdown
						align="left"
						width="48">
					<x-slot:trigger>
						<x-heroicons::mini.solid.ellipsis-vertical class="w-4 h-4" />
					</x-slot:trigger>
					<x-slot:content>
						<x-dropdown.dropdown-link href="{{ $subject->facebook_url }}">Visit</x-dropdown.dropdown-link>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	@endif
	@if(isset($subject->x_url))
		<div class="flex items-center justify-between border border-gray-200 rounded-md p-2 mt-4">
			<div>
				<x-svg-images.social.x-icon class="w-6 h-6 dark:fill-gray-300" />
			</div>
			<div><span class="text-sm dark-light-text">X</span></div>
			<div>
				<x-dropdown.dropdown
						align="left"
						width="48">
					<x-slot:trigger>
						<x-heroicons::mini.solid.ellipsis-vertical class="w-4 h-4" />
					</x-slot:trigger>
					<x-slot:content>
						<x-dropdown.dropdown-link href="{{ $subject->x_url }}">Visit</x-dropdown.dropdown-link>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	@endif
	@if(isset($subject->instagram_url))
		<div class="flex items-center justify-between border border-gray-200 rounded-md p-2 mt-4">
			<div>
				<x-svg-images.social.instagram-icon class="w-6 h-6" />
			</div>
			<div><span class="text-sm dark-light-text">Instagram</span></div>
			<div>
				<x-dropdown.dropdown
						align="left"
						width="48">
					<x-slot:trigger>
						<x-heroicons::mini.solid.ellipsis-vertical class="w-4 h-4" />
					</x-slot:trigger>
					<x-slot:content>
						<x-dropdown.dropdown-link href="{{ $subject->instagram_url }}">Visit</x-dropdown.dropdown-link>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	@endif
	@if(isset($subject->instagram_url))
		<div class="flex items-center justify-between border border-gray-200 rounded-md p-2 mt-4">
			<div>
				<x-svg-images.social.snapchat-icon class="w-6 h-6" />
			</div>
			<div><span class="text-sm dark-light-text">Snapchat</span></div>
			<div>
				<x-dropdown.dropdown
						align="left"
						width="48">
					<x-slot:trigger>
						<x-heroicons::mini.solid.ellipsis-vertical class="w-4 h-4" />
					</x-slot:trigger>
					<x-slot:content>
						<x-dropdown.dropdown-link href="{{ $subject->snapchat_url }}">Visit</x-dropdown.dropdown-link>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	@endif
	@if(isset($subject->youtube_url))
		<div class="flex items-center justify-between border border-gray-200 rounded-md p-2 mt-4">
			<div>
				<x-svg-images.social.youtube-icon class="w-6 h-6" />
			</div>
			<div><span class="text-sm dark-light-text">Youtube</span></div>
			<div>
				<x-dropdown.dropdown
						align="left"
						width="48">
					<x-slot:trigger>
						<x-heroicons::mini.solid.ellipsis-vertical class="w-4 h-4" />
					</x-slot:trigger>
					<x-slot:content>
						<x-dropdown.dropdown-link href="{{ $subject->youtube_url }}">Visit</x-dropdown.dropdown-link>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	@endif
</div>
