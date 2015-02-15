process.env.DISABLE_NOTIFIER = true;
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
    mix.sass(['app.scss', 'pages/*'])
        // Theme JS
        .copy(
            "resources/assets/js/metronic/global/metronic.js",
            "public/js/metronic.js"
        )
        .copy(
            "resources/assets/js/metronic/layout/layout.js",
            "public/js/layout.js"
        )
        .copy(
            "resources/assets/js/metronic/layout/pages/login.js",
            "public/js/login.js"
        )
        .copy(
            "resources/assets/js/vendor/gmaps.min.js",
            "public/js/vendor/gmaps.js"
        )
        // App JS
        .copy(
            "resources/assets/js/app.js",
            "public/js/app.js"
        )
        // Bower Dependencies
        // Bootstrap JS
        .copy(
            "bootstrap-sass-official/assets/javascripts/bootstrap.min.js",
            "public/js/vendor/bootstrap.js"
        )
        // Modernizr
        .copy(
            "modernizr/modernizr.min.js",
            "public/js/vendor/modernizr.js"
        )
        // jQuery
        .copy(
            "jquery/dist/jquery.min.js",
            "public/js/vendor/jquery.js"
        )
        // jQuery Migrate
        .copy(
            "jquery-migrate/jquery-migrate.min.js",
            "public/js/vendor/jquery-migrate.js"
        )
        // jQuery UI
        .copy(
            "jquery-ui/jquery-ui.min.js",
            "public/js/vendor/jquery-ui.js"
        )
        // blockUI
        .copy(
            "blockui/jquery.blockUI.js",
            "public/js/vendor/blockUI.js"
        )
        // excanvas
        .copy(
            "excanvas/excanvas.js",
            "public/js/vendor/excanvas.js"
        )
        // respond
        .copy(
            "respond/dest/respond.min.js",
            "public/js/vendor/respond.js"
        )
        // jQuery Cookie
        .copy(
            "jquery.cookie/jquery.cookie.js",
            "public/js/vendor/jquery.cookie.js"
        )
        // jQuery Uniform
        .copy(
            "jquery.uniform/jquery.uniform.min.js",
            "public/js/vendor/jquery.uniform.js"
        )
        // jQuery Validate
        .copy(
            "jquery.validate/dist/jquery.validate.min.js",
            "public/js/vendor/jquery.validate.js"
        )
        // Bootstrap Hover Dropdown Validate
        .copy(
            "boostrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
            "public/js/vendor/bootstrap-hover-dropdown.js"
        )
        // jQuery Slimscroll
        .copy(
            "jquery-slimscroll/jquery.slimscroll.min.js",
            "public/js/vendor/jquery.slimscroll.js"
        )
        // Bootstrap Switch
        .copy(
            "bootstrap-switch/dist/js/bootstrap-switch.min.js",
            "public/js/vendor/bootstrap-switch.js"
        )
        // JSTree
        .copy(
            "jstree/dist/jstree.min.js",
            "public/js/vendor/jstree.js"
        )
        .copy(
            "jstree/dist/themes/default/",
            "public/css/vendor/jstree/"
        )
        // Create "Common" JS file
        .scripts([
            "js/vendor/*",
            "js/*",
        ])

        // Version Files
        .version([
            "css/*.css",
            "js/*.js"
        ])

});
