<?php

return [
    'inherit' => null,
    'events'  => [
        'before'             => function ($theme) {
            $theme->setTitle(' CandyCMS v1.1');
            $theme->setAuthor('NgocNH');
            $theme->setKeywords('candycms, candy, cms');
            $theme->setDescription('CandyCMS - Copyright ©  2015');
            $theme->setCopyright('Copyright ©  2015 - me@ngocnh.info');
        },
        'beforeRenderTheme'  => function ($theme) {
            $theme->asset()->add('jquery-1.11.1', url('assets/js/libs/jquery/jquery-1.11.1.min.js'), ['core-js']);
            $theme->asset()->container('footer')->add('bootstrap', url('assets/plugins/bootstrap/js/bootstrap.min.js'), ['core-js']);
        },
        'beforeRenderLayout' => [
            'default' => function ($theme) {
                $theme->asset()->add('style', url('themes/default/assets/css/style.min.css'), ['core-css']);

                $theme->asset()->container('footer')->add('jquery-migrate', url('assets/js/libs/jquery/jquery-migrate-1.2.1.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('jquery-ui', url('assets/js/libs/jquery-ui/jquery-ui-1.11.2.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('bootstrap-dropdown', url('assets/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('bootstrap-datepicker', 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', ['core-js']);
                //$theme->asset()->container('footer')->add('retina', url('themes/default/assets/js/plugins/retina/retina.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('select2', url('assets/plugins/select2/select2.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('icheck', url('themes/default/assets/js/plugins/icheck/icheck.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('bootstrap-tags-input', url('assets/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('search', url('themes/default/assets/js/pages/search.js'), ['core-js']);
                $theme->asset()->container('footer')->add('switchery', url('assets/plugins/switchery/switchery.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('timepicker', url('assets/plugins/timepicker/jquery-ui-timepicker-addon.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('multidatepicker', url('assets/plugins/multidatepicker/multidatespicker.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('charts-highstock', url('assets/plugins/charts-highstock/js/highstock.min.js'), ['core-js']);
                $theme->asset()->container('footer')->add('ckeditor', url('assets/js/libs/ckeditor/ckeditor.js'), ['core-js']);
                $theme->asset()->container('footer')->add('ckfinder', url('assets/js/libs/ckfinder/ckfinder.js'), ['core-js']);
                $theme->asset()->container('footer')->add('datatable', url('assets/plugins/datatables/jquery.dataTables.min.js'), ['plugin-js']);
                $theme->asset()->container('footer')->add('main', url('themes/default/assets/js/main.min.js'), ['core-js']);
            },
            'login'   => function ($theme) {
                $theme->asset()->add('style', url('themes/default/assets/css/login.min.css'), ['core-css']);

                $theme->asset()->container('footer-scripts')->add('login-v2', url('themes/default/assets/js/pages/login-v2.js'), ['login-js']);
                $theme->asset()->container('footer-scripts')->add('lada', url('assets/plugins/bootstrap-loading/lada.min.js'), ['login-js']);
                $theme->asset()->container('footer-scripts')->add('backstretch', url('themes/default/assets/js/plugins/backstretch/backstretch.min.js'), ['login-js']);
                $theme->asset()->container('footer')->add('icheck', url('themes/default/assets/js/plugins/icheck/icheck.min.js'), ['login-js']);
                $theme->asset()->container('footer')->add('main', url('themes/default/assets/js/login.min.js'), ['core-js']);
            }
        ]
    ]
];