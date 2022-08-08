const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    //解决浏览器缓存
    .version()
    //复制指定的js和css文件到指定目录
    .copyDirectory('resources/editor/js', 'public/js')
    .copyDirectory('resources/editor/css', 'public/css');
