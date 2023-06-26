const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts([
                'assets/js/*.js'
            ], 
            'assets/dist/js/ascent-pagebuilder-bundle.js', 
            'assets/dist/js'
            )

    .styles([
                'assets/css/*.css'
            ], 
                'assets/dist/css/ascent-pagebuilder-bundle.css', 
                'assets/dist/css'
                );
   
   
   
   
    // .minify(['assets/js/ascent-cms-bundle.js', 'assets/css/ascent-cms-bundle.css']);
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ]);
