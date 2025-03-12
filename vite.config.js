import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/css/app.css', 'resources/js/app.js'],
			refresh: true,
		}),
	],
	server: {
		cors: {
			origin: ['http://peaceproxy.test'], // Array of allowed origins
			methods: ['GET', 'POST', 'PUT'], // Specify allowed methods
			allowedHeaders: ['Content-Type', 'Authorization'], // Allowed request headers
		},
		host: true,
	},
})
// export default defineConfig({
// 	server: {
// 		cors: true, // Or fine-grained control:
// 		cors: {
// 		  origin: ['http://peaceproxy.test'], // Array of allowed origins
// 		  methods: ['GET', 'POST', 'PUT'], // Specify allowed methods
// 		  allowedHeaders: ['Content-Type', 'Authorization'], // Allowed request headers
// 		},
// 		host: true,
// 	},
// });