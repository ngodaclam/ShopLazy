<?php
/**
 * Created by ngocnh.
 * Date: 7/20/15
 * Time: 2:26 PM
 */

namespace Modules\Core\Events;

class EventHandler
{

    public function subscribe($events)
    {
        $events->listen('user.store', 'Modules\Core\Http\Controllers\UserController@postStore');
        $events->listen('user.update', 'Modules\Core\Http\Controllers\UserController@postUpdate');
        $events->listen('user.lock', 'Modules\Core\Http\Controllers\UserController@postLock');
        $events->listen('user.destroy', 'Modules\Core\Http\Controllers\UserController@postDestroy');

        $events->listen('role.store', 'Modules\Core\Http\Controllers\RoleController@postStore');
        $events->listen('role.update', 'Modules\Core\Http\Controllers\RoleController@postUpdate');

        $events->listen('config.store', 'Modules\Core\Http\Controllers\ConfigController@save');

        $events->listen('backend.after.load', 'Modules\Core\Http\Controllers\EventController@after_backend_load');
    }
}