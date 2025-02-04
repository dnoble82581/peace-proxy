<x-negotiation-layout>
	<div class="max-w-6xl mx-auto dark:bg-gray-900 mt-5 flex items-center gap-2 text-sm mb-4">
		<x-heroicons::micro.solid.arrow-left class="w-4 h-4 dark-light-text" />
		<a
				class="dark-light-text"
				href="{{ route('negotiation.room', $associate->room->id) }}">Back To Negotiation</a>
	</div>
	<div class="max-w-6xl mx-auto p-8 bg-white dark:bg-gray-800">
		<div class="px-4 sm:px-0 \">
			<h3 class="text-base/7 font-semibold text-gray-900 dark-light-text">Associate Information</h3>
			<p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark-light-text">Personal details and application.</p>
		</div>
		<div class="mt-6">
			<dl class="grid grid-cols-1 sm:grid-cols-4">
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-4 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Images</dt>
					<div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-900">
						@foreach($associate->images as $image)
							<button
									onClick="Livewire.dispatch('modal.open', {component: 'modals.show-image', arguments: {image: '{{ $associate->imageUrl($image->image) }}'}})"
									class="">
								<img
										src="{{ $associate->imageUrl($image->image) }}"
										alt="Image"
										class="w-32 h-32 object-cover rounded-md">
							</button>
						@endforeach
					</div>
				</div>
				<x-list-elements.data-tag
						:label="'Full Name'"
						:value="$associate->name"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Gender'"
						:value="$associate->gender"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Email Address'"
						:value="$associate->email"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Phone'"
						:value="$associate->phone()"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Race'"
						:value="$associate->race"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Gender'"
						:value="$associate->gender"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Address'"
						class="col-span-4 sm:col-span-1">
					<span class="block">{{ $associate->address }}</span>
					<span lass="block">{{ $associate->city }}</span>
					<span lass="block">{{ $associate->state }}</span>
					<span lass="block">{{ $associate->zip }}</span>
				</x-list-elements.data-tag>
				<x-list-elements.data-tag
						:label="__('Date of Birth')"
						:value="$associate->dob ? $associate->dob->format('M-d-Y') : 'N/A'"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="__('Age')"
						:value="$associate->getAge()"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Children'"
						:value="$associate->children"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="'Veteran'"
						:value="$associate->veteran"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="__('Highest Level of Education')"
						:value="$associate->highest_education"
						class="col-span-4 sm:col-span-1" />
				<x-list-elements.data-tag
						:label="__('Substance Abuse')"
						:value="$associate->substance_abuse" />
				<x-list-elements.data-tag
						:label="__('Mental Health History')"
						:value="$associate->mental_health_history" />
				<x-list-elements.data-tag
						:label="__('Last Contacted At')"
						:value="$associate->last_contacted_at" />
				<x-list-elements.data-tag
						:label="__('Physical Description')"
						:value="$associate->physical_description"
						class="col-span-4 sm:col-span-4" />
				<x-list-elements.data-tag
						:label="'Notes'"
						:value="$associate->notes"
						class="col-span-4 sm:col-span-4" />
				@if($associate->facebook_url)
					<x-list-elements.data-tag
							:label="__('Facebook Url')">
						<a href=""></a>
						<x-svg-images.social.facebook-icon class="w-6 h-6" />
					</x-list-elements.data-tag>
				@endif
				@if($associate->x_url)
					<x-list-elements.data-tag
							:label="__('X Url')">
						<a href="{{ $associate->x_url }}">
							<x-svg-images.social.x-icon class="w-6 h-6" />
						</a>
					</x-list-elements.data-tag>
				@endif

				@if($associate->instagram_url)
					<x-list-elements.data-tag
							:label="__('Instagram Url')">
						<a href="{{ $associate->instagram_url }}">
							<x-svg-images.social.instagram-icon class="w-6 h-6" />
						</a>
					</x-list-elements.data-tag>
				@endif

				@if($associate->snapchat_url)
					<x-list-elements.data-tag
							:label="__('Snapchat Url')">
						<a href="{{ $associate->snapchat_url }}">
							<x-svg-images.social.snapchat-icon class="w-6 h-6" />
						</a>
					</x-list-elements.data-tag>
				@endif
				{{--				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-4 sm:px-0">--}}
				{{--					<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Attachments</dt>--}}
				{{--					<dd class="mt-2 text-sm text-gray-900 dark-light-text">--}}
				{{--						<x-list-elements.attachment-container>--}}
				{{--							@foreach($associate->documents as $document)--}}
				{{--								<x-list-elements.attachment-item :document="$document" />--}}
				{{--							@endforeach--}}
				{{--						</x-list-elements.attachment-container>--}}
				{{--					</dd>--}}
				{{--				</div>--}}
				{{--				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-4 sm:px-0">--}}
				{{--					<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Warrants</dt>--}}
				{{--					<dd class="mt-2 text-sm text-gray-900 dark-light-text">--}}
				{{--						<x-list-elements.attachment-container>--}}
				{{--							@foreach($associate->warrants as $warrant)--}}
				{{--								<x-list-elements.attachment-item :document="$warrant" />--}}
				{{--							@endforeach--}}
				{{--						</x-list-elements.attachment-container>--}}
				{{--					</dd>--}}
				{{--				</div>--}}
			</dl>
		</div>
	</div>

</x-negotiation-layout>