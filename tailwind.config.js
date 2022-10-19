const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    './resources/views/app.blade.php',
    './resources/views/errors/**/*.blade.php',
    './resources/assets/**/*.{scss,js,vue}',
  ],
  darkMode: 'class',
  theme: {
    container: {
      center: true,
    },
    fontFamily: {
      sans: ['Inter', ...defaultTheme.fontFamily.sans],
    },
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
        epilogue: ['Epilogue', 'sans-serif'],
      },
      typography: theme => ({
        DEFAULT: {
          css: {
            pre: {
              color: theme('colors.slate.900'),
              backgroundColor: theme('colors.slate.100'),
            },
            'pre code::before': {
              'padding-left': 'unset',
            },
            'pre code::after': {
              'padding-right': 'unset',
            },
            code: {
              backgroundColor: theme('colors.slate.100'),
              color: '#dd1144',
              fontWeight: '400',
              padding: 'unset !important',
              'border-radius': '0.25rem',
            },
            'code::before': {
              content: '""',
              'padding-left': '0.25rem',
            },
            'code::after': {
              content: '""',
              'padding-right': '0.25rem',
            },
          },
        },
      }),
    },
  },
  plugins: [require('@tailwindcss/typography'), require('@tailwindcss/forms')],
}
