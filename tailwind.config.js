import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  mode: 'jit',
  presets: [
    require('./vendor/wireui/wireui/tailwind.config.js')
  ],
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.css',
    './resources/views/**/*.blade.php',
    './vendor/wireui/wireui/src/*.php',
    './vendor/wireui/wireui/ts/**/*.ts',
    './vendor/wireui/wireui/src/WireUi/**/*.php',
    './vendor/wireui/wireui/src/Components/**/*.php',
    './vendor/wire-elements/pro/config/wire-elements-pro.php',
    './vendor/wire-elements/pro/**/*.blade.php',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [forms],
}
