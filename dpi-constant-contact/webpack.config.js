const webpack = require('webpack');
const nodeEnv = process.env.NODE_ENV || 'production';

module.exports = {
  // devtool: 'sourcemap',
  entry: ['./source/js/main.js'],
  output: {filename: 'main.js'},

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
          presets: [
            'es2015',
            [
              'env',
              {
                'targets': {
                  'browsers': [
                    'last 3 versions',
                    'IE >=10'
                  ]
                },
                'useBuiltIns': true
              }
            ],
          ],
          plugins: [
            ['transform-runtime'],
          ]
        }
      }
    ]
  },

  plugins: [
    new webpack.optimize.UglifyJsPlugin({
      compressor: { warnings: false },
      output: { comments: false },
      sourceMap: false
    }),
    new webpack.DefinePlugin({
      'process.env': { NODE_ENV: JSON.stringify(nodeEnv) }
    })
  ]
}
