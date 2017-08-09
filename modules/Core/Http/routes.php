<?php
$api = app('api.router');

Route::group([ 'prefix' => 'auth', 'namespace' => 'Modules\Core\Http\Controllers' ], function () {
    get('login', [ 'as' => 'login', 'uses' => 'AuthController@login' ]);
    post('login', [ 'as' => 'login', 'uses' => 'AuthController@do_login' ]);
    get('logout', [ 'as' => 'logout', 'uses' => 'AuthController@logout' ]);
    get('register', [ 'as' => 'register', 'uses' => 'AuthController@register' ]);
    post('register', [ 'as' => 'register', 'uses' => 'AuthController@do_register' ]);
    get('forget-password', [ 'as' => 'forget_password', 'uses' => 'AuthController@forget_password' ]);
});

Route::group([ 'namespace' => 'Modules\Core\Http\Controllers' ], function () {
    Route::controller('user', 'UserController', [
        'getIndex'        => 'user.index',
        'getCreate'       => 'user.create',
        'getEdit'         => 'user.edit',
        'getLock'         => 'user.lock',
        'getProfile'      => 'user.profile',
        'postStore'       => 'user.store',
        'postUpdate'      => 'user.update',
        'postApplication' => 'user.application',
        'postTrash'       => 'user.trash',
        'postDestroy'     => 'user.destroy',
        'postDatatables'  => 'user.datatables'

    ]);

    Route::controller('role', 'RoleController', [
        'getIndex'    => 'role.index',
        'getCreate'   => 'role.create',
        'getEdit'     => 'role.edit',
        'postStore'   => 'role.store',
        'postUpdate'  => 'role.update',
        'postDestroy' => 'role.destroy'
    ]);

    get('/', 'AdminController@index');
    get('/locale/{code}', [ 'as' => 'locale', 'uses' => 'AdminController@locale' ]);

    Route::group([ 'prefix' => 'configuration' ], function () {
        post('save', [ 'as' => 'configuration.save', 'uses' => 'ConfigController@save' ]);

        Route::controller('setting', 'SettingController', [
            'getIndex' => 'configuration.setting.index',
            'getMail'  => 'configuration.mail.index'
        ]);
    });
});

$api->version('v1', [ 'namespace' => 'Modules\Core\Http\Controllers\API\v1' ], function ($api) {
    $api->post('user/login', 'User@login');
    $api->post('contact', 'General@contact');
    $api->get('setting', [ 'middleware' => 'api.auth', 'providers' => [ 'oauth' ], 'uses' => 'Setting@index' ]);
    $api->resource('user', 'User');
});