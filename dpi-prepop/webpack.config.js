const webpack = require('webpack');
const path = require('path');

module.exports = {
    devtool: 'source-map',
    // entry: ['./js/source/addon-backend.js', './js/source/addon-client.js'],
    entry: {
        'addon-backend.min.js': './js/source/addon-backend.js',
        'addon-client.min.js': './js/source/addon-client.js'
    },
    output: {
        path: path.join(__dirname, '/js'),
        filename: '[name]'
    },
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
            sourceMap: true
        })
    ]
}