import './bootstrap'

function addReusableTransitions (el) {
	el.setAttribute('x-transition:enter', 'transition ease-out duration-200')
	el.setAttribute('x-transition:enter-start', 'opacity-0 scale-95')
	el.setAttribute('x-transition:enter-end', 'opacity-100 scale-100')
	el.setAttribute('x-transition:leave', 'transition ease-in duration-75')
	el.setAttribute('x-transition:leave-start', 'opacity-100 scale-100')
	el.setAttribute('x-transition:leave-end', 'opacity-0 scale-95')
}

// Apply it to elements dynamically
document.querySelectorAll('.reusable-transition').forEach((el) => {
	addReusableTransitions(el)
})