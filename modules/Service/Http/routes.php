<?php

$api = app('api.router');

Route::group([ 'namespace' => 'Modules\Service\Http\Controllers' ], function () {
    Route::group([ 'prefix' => 'configuration' ], function () {
        resource('application', 'ClientController', [
            'names' => [
                'index' => 'configuration.application.index'
            ]
        ]);
    });
});

$api->version('v1', [ 'namespace' => 'Modules\Service\Http\Controllers\API\v1' ], function ($api) {
    $api->get('client/user', 'Client@user');
    $api->post('client/access_token', 'Client@accessTokenGenerate');
});