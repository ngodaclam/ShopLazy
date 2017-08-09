<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/29/15
 * Time: 1:59 AM
 */

return [
    'configurations' => [
        'subs' => [
            'applications' => [
                'route'       => 'configuration.application.index',
                'permissions' => [ 'service.application.index' ],
                'active'      => 'configuration/application/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'list',
                'text'        => 'service::menu.applications',
                'order'       => 2
            ]
        ]
    ],
];