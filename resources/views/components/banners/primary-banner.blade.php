<div {{ $attributes->merge(['class' => 'lex items-center gap-x-6 bg-indigo-600 px-6 py-2.5 sm:px-3.5 justify-center']) }}>
	<p class="text-sm/6 text-white">
		<a href="{{ route('leave-impersonation') }}">
			<strong class="font-semibold">You are currently impersonating
				{{ auth()->user()->name }}</strong>
			<svg
					viewBox="0 0 2 2"
					class="mx-2 inline size-0.5 fill-current"
					aria-hidden="true">
				<circle
						cx="1"
						cy="1"
						r="1" />
			</svg>
			Click here to leave Impersonation&nbsp;<span aria-hidden="true">&rarr;</span>
		</a>
	</p>
</div>
