/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./resources/**/*.blade.php",
    "./**/*.html"
  ],
  theme: {
    extend: {
        keyframes: {
            'spin-y': {
                '0%': { transform: 'rotateY(0deg)' },
                '100%': { transform: 'rotateY(360deg)' },
            },
        },
        animation: {
            'spin-y': 'spin-y 3s linear infinite',
        },
    },
  },
  plugins: [],
}

