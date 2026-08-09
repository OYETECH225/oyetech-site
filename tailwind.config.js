/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        ink: '#0A0A0A',
        paper: '#F2F2F2',
        navy: '#111111',
        'navy-light': '#1C1C1C',
        'navy-dark': '#080808',
        brand: '#555555',
        'brand-dark': '#2A2A2A',
        'brand-light': '#8A8A8A',
        'accent-cyan': '#777777',
        'accent-orange': '#AAAAAA',
        'accent-green': '#666666',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        display: ['"Bricolage Grotesque"', 'Inter', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
