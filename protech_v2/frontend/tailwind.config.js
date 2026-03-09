/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        'protech-gold': '#D4AF37',
        'protech-green': '#2D5A27',
        'protech-green-light': '#3d7a35',
        'protech-black': '#1a1a1a',
        'protech-gray-dark': '#2d2d2d',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
