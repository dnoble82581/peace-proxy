@props(['conversationName'])
<button
		class="group inline-flex items-center border-b-2 border-transparent px-1 py-4 text-xs font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
	<!-- Current: "text-indigo-500", Default: "text-gray-400 group-hover:text-gray-500" -->
	<x-heroicons::outline.chat-bubble-bottom-center-text class="w-4 h-4 mr-2" />
	<span>{{ $conversationName }}</span>
</button>