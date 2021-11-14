const colors = require('tailwindcss/colors')

module.exports = {
  mode: 'jit',
  purge: ['./resources/assets/**/*.{scss,js,vue}'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        blueGray: colors.blueGray,
        primary: colors.blue,
        sky: colors.sky,
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
