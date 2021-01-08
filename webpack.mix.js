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

    .sass('resources/sass/welcome.scss', 'public/css')
    .sass('resources/sass/styles.scss', 'public/css')
    .sass('resources/sass/section_index.scss', 'public/css')
    .sass('resources/sass/section_create_edit.scss', 'public/css')
    .sass('resources/sass/paginacion.scss', 'public/css')
    .sass('resources/sass/header.scss', 'public/css')
    .sass('resources/sass/footer.scss', 'public/css')
    .sass('resources/sass/comentarios.scss', 'public/css')
    .sass('resources/sass/ayuda.scss', 'public/css')
    .sass('resources/sass/temas/temas_show.scss', 'public/css/temas')
    .sass('resources/sass/temas/tema.scss', 'public/css/temas')
    .sass('resources/sass/noticias/noticias_show.scss', 'public/css/noticias')
    .sass('resources/sass/noticias/noticias_index.scss', 'public/css/noticias')
    .sass('resources/sass/cuenta/perfil.scss', 'public/css/cuenta');
