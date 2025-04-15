<x-layouts.guest>
    <flux:header class="justify-between bg-white dark:bg-primary-500 p-4">
        <div>
            <flux:button-or-link href="/">
                <x-logos.full-logo-icon />
            </flux:button-or-link>

        </div>
        <div class="flex items-center justify-center space-x-4 uppercase text-md">
            <flux:button-or-link
                    href="#"
                    class="hover:text-accent-500 transition-colors ease-in-out">About
            </flux:button-or-link>
            <flux:button-or-link
                    href="#"
                    class="hover:text-accent-500 transition-colors ease-in-out">Product
            </flux:button-or-link>
            <flux:button-or-link
                    href="#"
                    class="hover:text-accent-500 transition-colors ease-in-out">Contact
            </flux:button-or-link>
        </div>
        <div class="flex items-center justify-center space-x-4 uppercase text-sm">
            @auth
                <flux:button-or-link
                        href="{{ route('dashboard') }}"
                        icon="bolt"
                        class="hover:text-accent-500 transition-colors ease-in-out">Dashboard
                </flux:button-or-link>
            @else
            <flux:button-or-link
                    href="{{ route('login') }}"
                    icon="bolt"
                    class="hover:text-accent-500 transition-colors ease-in-out">Login
            </flux:button-or-link>

            <flux:button-or-link
                    href="{{ route('register') }}"
                    class="hover:text-accent-500 transition-colors ease-in-out">Register
            </flux:button-or-link>
            @endauth
        </div>
    </flux:header>
    <section id="hero">
        @include('partials.welcome._hero')
    </section>
    <section
            class="dark:bg-primary-600 bg-white"
            id="communication">
        @include('partials.welcome._real-time-communication')
    </section>
    <section id="mood-tracking">
        @include('partials.welcome._mood-tracking')
    </section>
    <section
            id="unified-interface"
            class="dark:bg-primary-600 bg-white h-screen">
        @include('partials.welcome._unified-interface')
    </section>
    <section id="Phone Integration">
        @include('partials.welcome._phone-integration')
    </section>
    <section
            id="Objective Tracking"
            class="dark:bg-primary-600 bg-white">
        @include('partials.welcome._objective-tracking')
    </section>
    <section id="reporting">
        @include('partials.welcome._advanced-reporting')
    </section>
    <section
            id="Hostage Tracking"
            class="dark:bg-primary-600 bg-white">
        @include('partials.welcome._hostage-tracking')
    </section>
    @push('scripts')
        <script>
            anime({
                targets: '#bottom-text',
                keyframes: [
                    { translateY: ['100%', '-10%'], opacity: [0, 1], easing: 'easeOutQuad', duration: 1000 },
                    { translateY: '0%', easing: 'easeInOutQuad', duration: 800 },
                    { translateY: '0%', easing: 'easeInOutQuad', duration: 800 }
                ],
                delay: 1000 // Starts after 1 second
            })
            anime({
                targets: '#top-text', // Selects all <p> inside #bottom-text
                keyframes: [
                    { translateX: ['-100%', '10%'], opacity: [0, 1], easing: 'easeOutQuad', duration: 2000 },
                    { translateX: '0%', easing: 'easeInOutQuad', duration: 1000 },
                ],
            })
            anime({
                targets: '#buttons', // Selects all <p> inside #bottom-text
                opacity: [0, 1],
                duration: 1000,
                easing: 'easeInOutQuad',
                delay: 2000
            })

        </script>
        @endpush

</x-layouts.guest>