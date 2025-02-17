<div class="absolute bottom-0 left-0 group z-50">
	<!-- Buttons container -->
	<div
			class="hidden group-hover:flex flex-row items-center space-x-2 transition-opacity duration-300 ease-in-out">
		<button
				class="w-16 h-16 text-gray-900 bg-white rounded-full border border-gray-300 shadow-sm hover:text-gray-900 hover:bg-gray-50 focus:outline-none">
			Action 1
		</button>
		<button
				class="w-16 h-16 text-gray-900 bg-white rounded-full border border-gray-300 shadow-sm hover:text-gray-900 hover:bg-gray-50 focus:outline-none">
			Action 2
		</button>
		<button
				class="w-16 h-16 text-gray-900 bg-white rounded-full border border-gray-300 shadow-sm hover:text-gray-900 hover:bg-gray-50 focus:outline-none">
			Action 3
		</button>
	</div>
	<!-- Main Speed Dial Button -->
	<button
			class="w-16 h-16 bg-purple-500 text-white rounded-full shadow-lg hover:bg-purple-600 focus:outline-none">
		+
	</button>
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
