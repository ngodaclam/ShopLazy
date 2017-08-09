<?php
/**
 * Created by ngocnh.
 * Date: 8/6/15
 * Time: 11:41 AM
 */

if ( ! function_exists('paginator')) {
    /**
     * Get the available auth instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    function paginator($items)
    {
        return (new Modules\Core\Pagination\Paginator($items))->render();
    }
}