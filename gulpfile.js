var elixir = require('laravel-elixir');
var paths = {
    'root': '../../../',
    'bower_components': 'vendor/bower_components/',
    'build': 'public/build/',
    'js': 'public/js/',
    'css': 'public/css/'
};
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    mix.copy(
    		paths.bower_components + 'jquery/dist/jquery.min.js',
    		paths.js + 'vendor/jquery.js'
    	)
        .copy(
            paths.bower_components + 'jquery-ui/jquery-ui.min.js',
            paths.js + 'vendor/jquery-ui.js'
        )
    	.copy(
    		paths.bower_components + 'bootstrap-sass/assets/javascripts/bootstrap.js',
    		paths.js + 'vendor/bootstrap.js'
    	)
        .copy(
            paths.bower_components + 'jquery-ui/themes/ui-lightness/jquery-ui.min.css',
            paths.css + 'vendor/jquery-ui.css'
        )
    	.copy(
    		paths.bower_components + 'font-awesome/css/font-awesome.min.css',
    		paths.css + 'vendor/font-awesome.css'
    	)
        .copy(
            paths.bower_components + 'css-spinners/css/spinner/circles.css',
            paths.css + 'vendor/css-spinners.css'
        )
        .copy(
            paths.bower_components + 'jquery-ui/themes/ui-lightness/images',
            paths.build + 'css/images'
        )
        .copy(
            paths.bower_components + 'font-awesome/fonts',
            paths.build + 'fonts'
        )
        .copy(
            paths.bower_components + 'bootstrap-sass/assets/fonts/bootstrap/**',
            paths.build + 'fonts/bootstrap'
        );
    
    mix.styles([
            paths.root + 'public/css/vendor/jquery-ui.css',
            paths.root + 'public/css/vendor/font-awesome.css',
            paths.root + 'public/css/vendor/mapbox.css',
            paths.root + 'public/css/vendor/MarkerCluster.css',
            paths.root + 'public/css/vendor/MarkerCluster.default.css',
            paths.root + 'public/css/vendor/css-spinners.css',
            paths.root + 'public/css/app.css'
        ])
        .scripts([
            paths.root + 'public/js/vendor/jquery.js',
            paths.root + 'public/js/vendor/jquery-ui.js',
            paths.root + 'public/js/vendor/bootstrap.js',
            paths.root + 'public/js/vendor/mapbox.js',
            paths.root + 'public/js/vendor/leaflet.markercluster.js',
            paths.root + 'public/js/vendor/turf.min.js',
            paths.root + 'public/js/vendor/realworld.388.js',
            paths.root + 'public/js/app.js'
        ])
        .version([paths.css + 'all.css', paths.js + 'all.js']);
});
