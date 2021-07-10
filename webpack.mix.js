const mix = require('laravel-mix')
const path = require('path')
const del = require('del')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/assets/js/app.js', 'public/js')
  .vue()
  .sass('resources/assets/sass/app.scss', 'public/css')
  .options({
    postCss: [require('tailwindcss'), require('autoprefixer')],
  })
  .browserSync('stackunderflow.test')
  .webpackConfig({
    output: {
      chunkFilename: 'js/[name].js?id=[chunkhash]',
    },
    resolve: {
      alias: {
        '@': path.resolve('resources/assets/js'),
      },
    },
  })
  .before(() => {
    del(['/public/js', '/public/css'])
  })

if (mix.inProduction()) {
  mix.version()
  mix.disableSuccessNotifications()
}
