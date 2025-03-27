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
		host: '127.0.0.1', // Bind to localhost explicitly
		port: 5173,        // Default Vite port
		cors: {
			origin: '*', // Allow all origins (use specific origins for more control)
		},
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