const webpack = require('webpack');
const nodeEnv = process.env.NODE_ENV || 'production';

module.exports = {
  devtool: 'sourcemap',
  entry: ['./src/js/backend/app.js'],
  output: {
    filename: 'app.min.js'
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
            ['transform-react-jsx', {'pragma': 'h'}]
          ]
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
    // new webpack.optimize.UglifyJsPlugin({
    //   compressor: { warnings: false },
    //   mangle: { except: ['window.dpiSuperMenu'] },
    //   output: { comments: false },
    //   sourceMap: false
    // }),
    new webpack.DefinePlugin({
      'process.env': { NODE_ENV: JSON.stringify(nodeEnv) }
    }),
    new webpack.optimize.OccurrenceOrderPlugin()
  ]
}
