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
    mix.sass(['app.scss', 'pages/login.scss', 'pages/error.scss', 'pages/flights.scss', 'pages/staff.scss'])
        // Theme JS
        .copy(
            "resources/assets/js/metronic/global/metronic.js",
            "public/js/metronic.js"
        )
        .copy(
            "resources/assets/js/metronic/layout/quick-sidebar.js",
            "public/js/quick-sidebar.js"
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
        .publish(
            "bootstrap-sass-official/assets/javascripts/bootstrap.min.js",
            "public/js/vendor/bootstrap.js"
        )
        // Modernizr
        .publish(
            "modernizr/modernizr.min.js",
            "public/js/vendor/modernizr.js"
        )
        // jQuery
        .publish(
            "jquery/dist/jquery.min.js",
            "public/js/vendor/jquery.js"
        )
        // jQuery Migrate
        .publish(
            "jquery-migrate/jquery-migrate.min.js",
            "public/js/vendor/jquery-migrate.js"
        )
        // jQuery UI
        .publish(
            "jquery-ui/jquery-ui.min.js",
            "public/js/vendor/jquery-ui.js"
        )
        // blockUI
        .publish(
            "blockui/jquery.blockUI.js",
            "public/js/vendor/blockUI.js"
        )
        // excanvas
        .publish(
            "excanvas/excanvas.js",
            "public/js/vendor/excanvas.js"
        )
        // respond
        .publish(
            "respond/dest/respond.min.js",
            "public/js/vendor/respond.js"
        )
        // jQuery Cookie
        .publish(
            "jquery.cookie/jquery.cookie.js",
            "public/js/vendor/jquery.cookie.js"
        )
        // jQuery Uniform
        .publish(
            "jquery.uniform/jquery.uniform.min.js",
            "public/js/vendor/jquery.uniform.js"
        )
        // jQuery Validate
        .publish(
            "jquery.validate/dist/jquery.validate.min.js",
            "public/js/vendor/jquery.validate.js"
        )
        // Bootstrap Hover Dropdown Validate
        .publish(
            "boostrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
            "public/js/vendor/bootstrap-hover-dropdown.js"
        )
        // jQuery Slimscroll
        .publish(
            "jquery-slimscroll/jquery.slimscroll.min.js",
            "public/js/vendor/jquery.slimscroll.js"
        )
        // Bootstrap Switch
        .publish(
            "bootstrap-switch/dist/js/bootstrap-switch.min.js",
            "public/js/vendor/bootstrap-switch.js"
        )
        // JSTree
        .publish(
            "jstree/dist/jstree.min.js",
            "public/js/vendor/jstree.js"
        )
        .publish(
            "jstree/dist/themes/default/",
            "public/css/vendor/jstree/"
        )
        // Create "Common" JS file
        .scripts([
            "js/vendor/jquery.js",
            "js/vendor/jquery-migrate.js",
            "js/vendor/jquery-ui.js",
            "js/vendor/bootstrap.js",
            "js/vendor/blockUI.js",
            "js/vendor/jquery.cokie.js",
            "js/vendor/jquery.uniform.js",
            "js/vendor/jquery.validate.js",
            "js/vendor/jquery.slimscroll.js",
            "js/vendor/bootstrap-hover-dropdown.js",
            "js/vendor/bootstrap-switch.js",
            "js/vendor/gmaps.js",
            "js/vendor/jstree.js",
            "js/metronic.js",
            "js/layout.js",
            // "js/quick-sidebar.js",
            "js/app.js"
        ])

        // Version Files
        .version([
            "css/app.css",
            "css/login.css",
            "css/error.css",
            "css/flights.css",
            "css/staff.css",
            "js/all.js",
            "js/login.js"
        ])

});
