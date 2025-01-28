<x-negotiation-layout>
	<div class="max-w-6xl mx-auto dark:bg-gray-800 mt-5 flex items-center gap-2 text-sm mb-4">
		<x-heroicons::micro.solid.arrow-left class="w-4 h-4 dark-light-text" />
		<a
				class="dark-light-text"
				href="{{ route('negotiation.room', $subject->room->id) }}">Back To Negotiation</a>
	</div>
	<div class="max-w-6xl mx-auto p-8 bg-white dark:bg-gray-800 mt-5">
		<div class="px-4 sm:px-0 \">
			<h3 class="text-base/7 font-semibold text-gray-900 dark-light-text">Subject Information</h3>
			<p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark-light-text">Personal details and application.</p>
		</div>
		<div class="mt-6">
			<dl class="grid grid-cols-1 sm:grid-cols-4">

				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-4 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Images</dt>
					<div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-900">
						@foreach($subject->images as $image)
							<button
									onClick="Livewire.dispatch('modal.open', {component: 'modals.show-image', arguments: {image: '{{ $subject->imageUrl($image->image) }}'}})"
									class="">
								<img
										src="{{ $subject->imageUrl($image->image) }}"
										alt="Image"
										class="w-32 h-32 object-cover rounded-md">
							</button>
						@endforeach

					</div>
				</div>
				<x-list-elements.data-tag
						:label="'Full Name'"
						:value="$subject->name"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Gender'"
						:value="$subject->gender"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Email Address'"
						:value="$subject->email"
						class="col-span-4 sm:col-span-1" />

				<x-list-elements.data-tag
						:label="'Phone'"
						:value="$subject->phone()"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Race'"
						:value="$subject->race"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Gender'"
						:value="$subject->gender"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Address'"
						class="col-span-4 sm:col-span-1">
					<span class="block">{{ $subject->address }}</span>
					<span lass="block">{{ $subject->city }}</span>
					<span lass="block">{{ $subject->state }}</span>
					<span lass="block">{{ $subject->zip }}</span>
				</x-list-elements.data-tag>
				<x-list-elements.data-tag
						:label="__('Date of Birth')"
						:value="$subject->date_of_birth ? $subject->date_of_birth->format('M-d-Y') : 'N/A'"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="__('Age')"
						test
						:value="$subject->getAge($subject->date_of_birth)"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Children'"
						:value="$subject->children"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Veteran'"
						:value="$subject->veteran"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="__('Highest Level of Education')"
						:value="$subject->highest_education"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="__('Substance Abuse')"
						:value="$subject->substance_abuse" />
				<x-list-elements.data-tag
						:label="__('Mental Health History')"
						:value="$subject->mental_health_history" />
				<x-list-elements.data-tag
						:label="__('Physical Description')"
						:value="$subject->physical_description"
						class="col-span-4 sm:col-span-4" />
				<x-list-elements.data-tag
						:label="'Notes'"
						:value="$subject->notes"
						class="col-span-4 sm:col-span-4" />
				@if($subject->facebook_url)
					<x-list-elements.data-tag
							:label="__('Facebook Url')">
						<a href=""></a>
						<x-svg-images.social.facebook-icon class="w-6 h-6" />
					</x-list-elements.data-tag>
				@endif
				@if($subject->x_url)
					<x-list-elements.data-tag
							:label="__('X Url')">
						<a href="{{ $subject->x_url }}">
							<x-svg-images.social.x-icon class="w-6 h-6" />
						</a>
					</x-list-elements.data-tag>
				@endif

				@if($subject->instagram_url)
					<x-list-elements.data-tag
							:label="__('Instagram Url')">
						<a href="{{ $subject->instagram_url }}">
							<x-svg-images.social.instagram-icon class="w-6 h-6" />
						</a>
					</x-list-elements.data-tag>
				@endif

				@if($subject->snapchat_url)
					<x-list-elements.data-tag
							:label="__('Snapchat Url')">
						<a href="{{ $subject->snapchat_url }}">
							<x-svg-images.social.snapchat-icon class="w-6 h-6" />
						</a>
					</x-list-elements.data-tag>
				@endif

				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-4 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Attachments</dt>
					<dd class="mt-2 text-sm text-gray-900 dark-light-text">
						<x-list-elements.attachment-container>
							@foreach($subject->documents as $document)
								<x-list-elements.attachment-item :document="$document" />
							@endforeach
						</x-list-elements.attachment-container>
					</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-4 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Warrants</dt>
					<dd class="mt-2 text-sm text-gray-900 dark-light-text">
						<x-list-elements.attachment-container>
							@foreach($subject->warrants as $warrant)
								<x-list-elements.attachment-item :document="$warrant" />
							@endforeach
						</x-list-elements.attachment-container>
					</dd>
				</div>
			</dl>
		</div>
	</div>

</x-negotiation-layout>