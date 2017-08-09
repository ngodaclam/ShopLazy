<?php
/**
 * Created by NgocNH.
 * Date: 2/17/16
 * Time: 2:02 PM
 */

namespace Modules\Post\Events;

class EventHandler
{

    public function subscribe($events)
    {
        $events->listen('post.store', 'Modules\Post\Http\Controllers\PostController@postStore');
        $events->listen('post.update', 'Modules\Post\Http\Controllers\PostController@postUpdate');
        $events->listen('post.lock', 'Modules\Post\Http\Controllers\PostController@postLock');
        $events->listen('post.trash', 'Modules\Post\Http\Controllers\PostController@postTrash');
        $events->listen('post.restore', 'Modules\Post\Http\Controllers\PostController@postRestore');
        $events->listen('post.destroy', 'Modules\Post\Http\Controllers\PostController@postDestroy');

        $events->listen('taxonomy.store', 'Modules\Post\Http\Controllers\CategoryController@postStore');
        $events->listen('taxonomy.update', 'Modules\Post\Http\Controllers\CategoryController@postUpdate');
        $events->listen('taxonomy.trash', 'Modules\Post\Http\Controllers\CategoryController@postTrash');
    }
}