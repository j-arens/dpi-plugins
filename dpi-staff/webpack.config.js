const webpack = require('webpack');
const nodeEnv = process.env.NODE_ENV || 'production';

module.exports = {
  devtool: 'source-map',
  entry: ['babel-polyfill', './src/assets/js/app.js'],
  output: {
    filename: 'app.js'
  },

  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        loader: 'eslint-loader',
        enforce: 'pre'
      },
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        loader: 'babel-loader',
        babelrc: false,
        query: {
          presets: ['es2015']
        }
      },
      {
        test: /\.css$/,
        loaders: [
          'style-loader',
          'css-loader?importLoaders=1',
          'postcss-loader'
        ]
      }
    ]
  },

  plugins: [
    new webpack.optimize.UglifyJsPlugin({
      compressor: { warnings: false },
      output: { comments: false },
      sourceMap: true
    }),
    new webpack.DefinePlugin({
      'process.env': { NODE_ENV: JSON.stringify(nodeEnv) }
    }),
    new webpack.optimize.OccurrenceOrderPlugin()
  ]
}
