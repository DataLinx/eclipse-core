let mix = require('laravel-mix');

mix .setPublicPath('public')
    .js('resources/js/core.js', 'js')
    .sass('resources/sass/core.scss', 'public/css');
