const mix = require('laravel-mix');
const StylelintPlugin = require('stylelint-webpack-plugin');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .webpackConfig({
    module: {
        rules: [{
            test: /\.(js|vue)$/,
            loader: 'eslint-loader',
            enforce: 'pre',
            exclude: /node_modules/,
            options: {
                formatter: require('eslint-friendly-formatter'),
            },
        },],
    },
    plugins: [
        new StylelintPlugin({
            files: ['resources/**/*.?(vue|scss)'],
            fix: false,
        }),
    ],
});
