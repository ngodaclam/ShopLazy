<?php
/**
 * Created by ngocnh.
 * Date: 7/20/15
 * Time: 2:26 PM
 */

namespace Modules\Service\Events;

class EventHandler
{

    public function subscribe($events)
    {
        $events->listen('user.store', 'Modules\Service\Http\Controllers\EventController@userStored');
    }
}