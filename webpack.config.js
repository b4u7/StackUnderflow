const path = require('path')

module.exports = {
  output: {
    chunkFilename: 'js/[name].js?id=[chunkhash]',
  },
  resolve: {
    alias: {
      '@': path.resolve('resources/assets/js'),
    },
  },
  stats: {
    children: true,
  },
}
