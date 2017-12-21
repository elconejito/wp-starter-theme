const Merge        = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CommonConfig = require('./common.js');

module.exports = Merge(CommonConfig, {
  output: {
    filename: 'js/main.js'
  },
  plugins: [
    new ExtractTextPlugin('css/main.css')
  ]
});