const webpack = require('webpack');
const path = require('path');

module.exports = {
    devtool: 'source-map',
    entry: {
        'tabs.min.js': './Assets/js/source/index.js',
    },
    output: {
        path: path.join(__dirname, './Assets/js'),
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