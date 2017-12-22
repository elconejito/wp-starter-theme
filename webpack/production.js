const Merge        = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CommonConfig = require('./common.js');

module.exports = Merge(CommonConfig, {
  output: {
    filename: 'js/[name]-[hash:8].js'
  },
  plugins: [
    new ExtractTextPlugin('css/[name]-[hash:8].css')
  ]
});