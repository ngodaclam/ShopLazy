<?php

$api = app('api.router');

Route::group([ 'namespace' => 'Modules\Post\Http\Controllers' ], function () {
    Route::controller('post', 'PostController', [
        'getIndex'       => 'post.index',
        'getCreate'      => 'post.create',
        'getEdit'        => 'post.edit',
        'postStore'      => 'post.store',
        'postUpdate'     => 'post.update',
        'postLock'       => 'post.lock',
        'postTrash'      => 'post.trash',
        'postRestore'    => 'post.restore',
        'postDestroy'    => 'post.destroy',
        'postDatatables' => 'post.datatables'
    ]);

    Route::controller('category', 'CategoryController', [
        'getIndex'       => 'category.index',
        'getEdit'        => 'category.edit',
        'postStore'      => 'category.store',
        'postUpdate'     => 'category.update',
        'postTrash'      => 'category.trash',
        'postDatatables' => 'category.datatables',
    ]);

    Route::controller('tag', 'TagController', [
        'getIndex'       => 'tag.index',
        'getEdit'        => 'tag.edit',
        'postStore'      => 'tag.store',
        'postUpdate'     => 'tag.update',
        'postTrash'      => 'tag.trash',
        'postDatatables' => 'tag.datatables',
    ]);
});

$api->version('v1', [ 'namespace' => 'Modules\Post\Http\Controllers\API\v1' ], function ($api) {
    $api->resource('post', 'Post', [ 'only' => [ 'index', 'show' ] ]);
    $api->resource('category', 'Category', [ 'only' => [ 'index', 'show' ] ]);
    $api->resource('tag', 'Tag', [ 'only' => [ 'index', 'show' ] ]);
});