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

elixir(function (mix) {
    mix
        .less([
            '../../../public/themes/default/assets/css/less/style.less',
            '../../../public/themes/default/assets/css/less/theme.less',
            '../../../public/themes/default/assets/css/less/ui.less'
        ], 'public/themes/default/assets/css/less.css')
        .styles([
            '../../../public/themes/default/assets/css/less.css',
            '../../../public/assets/plugins/dropzone/dropzone.min.css',
            '../../../public/assets/plugins/input-text/style.min.css',
            '../../../public/assets/plugins/datatables/dataTables.min.css',
            '../../../public/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'
        ], 'public/themes/default/assets/css/style.min.css')
        .styles([
            '../../../public/themes/default/assets/css/less.css',
            '../../../public/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'
        ], 'public/themes/default/assets/css/login.min.css')
        .scripts([
            '../../../public/themes/default/assets/js/application.js',
            '../../../public/themes/default/assets/js/plugins.js',
            '../../../public/themes/default/assets/js/pages/form_icheck.js',
            '../../../public/assets/js/main.js'
        ], 'public/themes/default/assets/js/main.min.js')
        .scripts([
            '../../../public/themes/default/assets/js/application.js',
            '../../../public/themes/default/assets/js/plugins.js',
            '../../../public/themes/default/assets/js/pages/login-v2.js'
        ], 'public/themes/default/assets/js/login.min.js')
        .version([
            'themes/default/assets/css/style.min.css',
            'themes/default/assets/css/login.min.css',
            'themes/default/assets/js/main.min.js',
            'themes/default/assets/js/login.min.js'
        ]);
});
