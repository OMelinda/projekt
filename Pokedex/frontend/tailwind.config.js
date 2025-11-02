/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  
  theme: {
    extend: {
      colors: {
        'pokemon-red': '#EE1515',
        'pokemon-yellow': '#FFDE00',
        'pokemon-blue': '#3B4CCA',
      },
      
      animation: {
        'bounce-slow': 'bounce 2s infinite',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      
      boxShadow: {
        'pokemon': '0 10px 25px -5px rgba(238, 21, 21, 0.3)',
      }
    },
  },
  
  plugins: [],
}