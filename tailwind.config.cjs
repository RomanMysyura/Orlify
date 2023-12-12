/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./App/**/*.html",
    "./App/**/*.php",
  ],
  theme: {
    extend: { 
      container: {  
        margin:{
          'margintop':'578px',
        },
      animation: {
      'infinite-scroll': 'infinite-scroll 25s linear infinite',
    },
  },
    keyframes: {
      'infinite-scroll': {
        from: { transform: 'translateX(0)' },
        to: { transform: 'translateX(-100%)' },
      }
    }  },
  },
  plugins: [
    require("daisyui"),
  ],
}
