const merge = require('webpack-merge');
const common = require('./common.config.js');

module.exports = merge(common, {
    devtool: "cheap-module-source-map"
});