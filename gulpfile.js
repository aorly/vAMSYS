var elixir = require('laravel-elixir');

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
    mix.sass(['app.scss'])
        // Theme JS
        .copy(
            "resources/js/metronic",
            "public/vendor/js/metronic"
        )
        .scripts([
            "../../vendor/bower_components/jquery/dist/jquery.min.js",
            "../../vendor/bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.min.js",
            "../../vendor/bower_components/modernizr/modernizr.js",
            "../../vendor/bower_components/jquery-migrate/jquery-migrate.min.js",
            "../../vendor/bower_components/jquery-ui/jquery-ui.min.js",
            "../../vendor/bower_components/blockui/jquery.blockUI.js",
            "../../vendor/bower_components/excanvas/excanvas.js",
            "../../vendor/bower_components/respond/dest/respond.min.js",
            "../../vendor/bower_components/jquery.cookie/jquery.cookie.js",
            "../../vendor/bower_components/jquery.uniform/jquery.uniform.min.js",
            "../../vendor/bower_components/jquery.validate/dist/jquery.validate.min.js",
            "../../vendor/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
            "../../vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js",
            "../../vendor/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js",
            "../../vendor/bower_components/jstree/dist/jstree.min.js",
            "vendor/gmaps.min.js",
            "app.js"
        ], 'public/js/combined.js')
        // JSTree
        .copy(
            "vendor/bower_components/jstree/dist/themes/default/",
            "public/vendor/css/jstree/"
        )
        // Bootstrap Switch
        .copy(
            "vendor/bower_components/bootstrap-switch/dist/css/bootstrap3/",
            "public/vendor/css/bootstrap-switch/dist/css/bootstrap3/"
        )
        // AMCharts
        .copy(
            "vendor/bower_components/amcharts/dist/amcharts",
            "public/vendor/js/amcharts"
        )
        // Version Files
        .version([
            "css/app.css",
            "js/combined.js"
        ])

});
