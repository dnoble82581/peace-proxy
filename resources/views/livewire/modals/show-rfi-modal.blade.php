<div class="p-8">
	<div class="px-4 sm:px-0">
		<h3 class="text-base/7 font-semibold text-gray-900">Request for Information Details</h3>
		<p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Request detail information</p>
	</div>
	<div class="mt-6 border-t border-gray-100">
		<dl class="divide-y divide-gray-100">
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900">Subject Request</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $rfi->request }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900">Requested By</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $rfi->created_at }}</dd>
			</div>
		</dl>
	</div>
</div>

