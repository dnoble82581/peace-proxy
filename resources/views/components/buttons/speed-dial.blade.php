<div class="group z-50 inline-flex items-center space-x-2">
	<!-- Main Speed Dial Button -->
	<button
			class="w-12 h-12 bg-indigo-500 text-white rounded-full shadow-lg hover:bg-indigo-600 focus:outline-none flex items-center group-hover:rotate-45 transition-all duration-100 ease-linear justify-center mt-2 speed-dial-main">
		<x-heroicons::micro.solid.plus class="w-6 h-6" />
	</button>
	<!-- Buttons container -->
	<div
			class="hidden group-hover:flex flex-row items-center transition-opacity space-x-2 duration-300 ease-in-out speed-dial-menu">

		<button
				class="w-12 h-12 text-gray-900 bg-white rounded-full border border-gray-300 shadow-sm hover:text-gray-900 hover:bg-gray-50 focus:outline-none relative">
			<span class="absolute -top-5 text-sm left-1/2 -translate-x-1/2">Base</span>
			<x-svg-images.mood_emojis.base_line class="" />
		</button>
		<button
				class="w-12 h-12 text-gray-900 bg-white rounded-full border border-gray-300 shadow-sm hover:text-gray-900 hover:bg-gray-50 focus:outline-none">
			Action 2
		</button>
		<button
				class="w-12 h-12 text-gray-900 bg-white rounded-full border border-gray-300 shadow-sm hover:text-gray-900 hover:bg-gray-50 focus:outline-none">
			Action 3
		</button>
	</div>

</div>

<script>
	document.querySelector('.speed-dial-main').addEventListener('click', () => {
		const menu = document.querySelector('.speed-dial-menu')
		if (menu.classList.contains('hidden')) {
			menu.classList.remove('hidden')
		} else {
			menu.classList.add('hidden')
		}
	})
</script>
