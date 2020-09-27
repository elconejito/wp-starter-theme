const path = require('path');
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;

module.exports = (env, argv) => {
  // console.log('webpack.config.js environment', argv.mode);
  const devMode = argv.mode === 'development';

  return {
    entry: {
      main: './assets/index.js',
      vendors: [ 'jquery', 'bootstrap', 'popper.js' ],
    },
    output: {
      path: path.resolve(__dirname, 'dist'),
      filename: `js/[name]${! devMode ? '-[hash:8]' : ''}.js`,
    },
    externals: {
      jquery: 'jQuery',
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: 'babel-loader',
        },
        {
          test: /\.(sa|sc|c)ss$/,
          use: [
            {
              loader: MiniCssExtractPlugin.loader,
              options: {
                hmr: devMode,
              },
            },
            { loader: 'css-loader', options: { sourceMap: devMode } },
            { loader: 'postcss-loader', options: { sourceMap: devMode } },
            { loader: 'sass-loader', options: { sourceMap: devMode } },
          ],
        },
        {
          test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
          exclude: /images/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '[name].[ext]',
                outputPath: 'fonts/',
                publicPath: '../fonts/',
              },
            },
          ],
        },
        {
          test: /\.(gif|png|jpe?g|svg)$/i,
          exclude: /node_modules/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '[name].[ext]',
                outputPath: 'images/',
                publicPath: '../',
              },
            },
            {
              loader: 'image-webpack-loader',
              options: {
                bypassOnDebug: true,
              },
            },
          ],
        },
      ],
    },
    devtool: devMode ? 'source-map' : false,
    plugins: [
      new CleanWebpackPlugin(),
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        Popper: 'popper.js',
      }),
      new ManifestPlugin({
        filter: ({ path }) => path.startsWith('js') || path.startsWith('css'),
      }),
      new CopyWebpackPlugin({
        patterns: [
          {
            from: './assets/images',
            to: 'images/',
          },
        ],
      }),
      new ImageminPlugin({
        test: /\.(gif|png|jpe?g|svg)$/i,
        pngquant: {
          quality: '90-100',
        },
      }),
      new MiniCssExtractPlugin({
        filename: `css/[name]${! devMode ? '-[hash:8]' : ''}.css`,
        allChunks: true,
      }),
    ],
  };

};
