'use-strict';

const webpack = require('webpack');

module.exports = {
  entry: ['./src/assets/js/gcal.js'],
  output: {
    filename: 'gcal.js'
  },

  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        loader: 'babel-loader',
        babelrc: false,
        query: {
          presets: ['es2015']
        }
      }
    ]
  },

  plugins: [
    new webpack.optimize.UglifyJsPlugin({
      compressor: {
        warnings: false,
      },
    }),
    new webpack.optimize.OccurrenceOrderPlugin()
  ]
}
