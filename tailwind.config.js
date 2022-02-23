const colors = require('tailwindcss/colors')

module.exports = {
  content: ['./resources/assets/**/*.{scss,js,vue}'],
  darkMode: 'media', // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        primary: colors.blue,
        secondary: colors.yellow,
      },
      flexShrink: {
        2: '2',
      },
      flexGrow: {
        2: '2',
      },
      fontFamily: {
        sans: ['Inter'],
      },
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
