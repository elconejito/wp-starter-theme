const path = require('path');

module.exports = {
    entry: './assets/scripts/main.js',
    output: {
        path: path.resolve(__dirname, 'dist/scripts'),
        filename: 'main.js'
    }
};
