const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      black: colors.black,
      gray: colors.blueGray,
      green: colors.green,
      indigo: colors.indigo,
      lightBlue: colors.lightBlue,
      primary: colors.blue,
      red: colors.red,
      transparent: 'transparent',
      white: colors.white,
    },
    textColor: {
      black: colors.black,
      lime: colors.lime,
      gray: colors.blueGray,
      green: colors.green,
      indigo: colors.indigo,
      lightBlue: colors.lightBlue,
      primary: colors.blue,
      red: colors.red,
      transparent: 'transparent',
      white: colors.white,
    },
    backgroundColor: {
      black: colors.black,
      gray: colors.blueGray,
      green: colors.green,
      indigo: colors.indigo,
      lightBlue: colors.lightBlue,
      primary: colors.blue,
      red: colors.red,
      transparent: 'transparent',
      white: colors.white,
    },
    ringColor: {
      black: colors.black,
      gray: colors.blueGray,
      green: colors.green,
      indigo: colors.indigo,
      lightBlue: colors.lightBlue,
      primary: colors.blue,
      red: colors.red,
      transparent: 'transparent',
      white: colors.white,
    },
    extend: {
      fontFamily: {
        sans: ['Inter'],
      },
    },
  },
  variants: {
    extend: {},
    backgroundColor: ['responsive', 'hover', 'focus'],
  },
  plugins: [require('@tailwindcss/forms')],
}
