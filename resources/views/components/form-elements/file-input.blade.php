@props(['acceptedTypes' => null, 'inputType' => null, 'wireTo' => null])
<input
		{{ $attributes->merge(['class' => 'relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-300 focus:shadow-inset focus:outline-none dark:border-white/70 dark:text-white  file:dark:text-white']) }}
		type="{{ $inputType ?? 'file' }}"
		accept="{{ $acceptedTypes }}"
		wire:model="{{ $wireTo }}" />