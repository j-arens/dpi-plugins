
'use-strict';

const webpack = require('webpack');

module.exports = {
    devtool: 'inline-source-map',
    output: {
        filename: '[name]'
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
                    presets: ['es2015'],
                    plugins: ['transform-runtime']
                }
            }
        ]
    },
    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            output: {comments: false}
        })
    ]
}