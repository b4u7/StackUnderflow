const mix = require('laravel-mix')

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
  .webpackConfig(require('./webpack.config'))

if (!mix.inProduction()) {
  mix.browserSync(process.env.APP_URL)
}

if (mix.inProduction()) {
  mix.version()
  mix.disableSuccessNotifications()
}
