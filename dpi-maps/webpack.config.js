const webpack = require('webpack');

module.exports = {
  entry: ['./Assets/js/source/index.js'],
  module: {
    loaders: [
      { test: /\.js$/, loader: 'eslint-loader', enforce: 'pre', exclude: /node_modules/ },
      { test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/ }
    ]
  },
  plugins: [
    new webpack.optimize.UglifyJsPlugin({
          compressor: {warnings: false},
          output: {comments: false},
          sourceMap: false
      })
  ]
}
