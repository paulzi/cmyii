const fs = require('fs');
const path = require('path');
const autoprefixer = require('autoprefixer');
const webpack = require('webpack');

const ExtractTextPlugin = require('extract-text-webpack-plugin');
const extractCss  = new ExtractTextPlugin('../../web/css/[name].css');

let browsers = [
    '> 1%',
    'last 2 versions',
    'last 4 Chrome versions',
    'last 4 Firefox versions',
    'not ie < 11',
    'Safari >= 9',
    'Android >= 4.4',
    'iOS >= 7.1'
];

module.exports = {
    entry: {
        app: path.resolve(__dirname, '../../src/js/app.js')
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, '../../web/js')
    },
    module: {
        rules: [
            {
                test: /\.(woff2?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: {
                    loader: 'file-loader',
                    options: {
                        name: '[path][name].[ext]',
                        outputPath: '../f/'
                    }
                }
            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: [['env', {
                                targets: {
                                    browsers: browsers
                                }
                            }]]
                        }
                    }
                ]
            },
            {
                test: /\.scss$/,
                use: extractCss.extract([
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: "postcss-loader",
                        options: {
                            plugins: function () {
                                return [
                                    autoprefixer({
                                        browsers: browsers
                                    })
                                ];
                            },
                            sourceMap: true
                        }
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap: true
                        }
                    }
                ])
            }
        ]
    },
    externals: {
        "jquery": "jQuery"
    },
    plugins: [
        extractCss,
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
        }),
        new webpack.IgnorePlugin(/^codemirror$/),
    ]
};