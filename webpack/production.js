const Merge        = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CommonConfig = require('./common.js');

module.exports = Merge(CommonConfig, {
  output: {
    filename: 'js/main-[hash:8].js'
  },
  plugins: [
    new ExtractTextPlugin('css/main-[hash:8].css')
  ]
});