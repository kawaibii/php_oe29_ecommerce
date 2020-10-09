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
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/productjs.js', 'public/js');
mix.js('resources/js/orderjs.js', 'public/js');
mix.js('resources/js/product_detail.js', 'public/js');

mix.styles([
    'resources/css/admin_menu.css',
    'resources/css/detail_page.css',
    'resources/css/user_login.css',
    'resources/css/user_register.css',
    'resources/css/page_detail_product.css',
    'resources/css/user_product.css',
    'resources/css/order.css',
    'resources/css/user_product_detail.css',
    ], 'public/css/all.css'
);
