<?php

return [
    'users'          => [
        'route'       => 'user.index',
        'permissions' => [ 'user.index' ],
        'active'      => 'user/*',
        'class'       => '',
        'icon'        => 'fa fa-user',
        'name'        => 'users',
        'text'        => 'core::menu.users',
        'order'       => 1,
        'subs'        => [
            'user_list' => [
                'route'       => 'user.index',
                'permissions' => [ 'user.index' ],
                'active'      => 'user/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'list',
                'text'        => 'core::menu.list',
                'order'       => 1
            ],
            'user_add'  => [
                'route'       => 'user.create',
                'permissions' => [ 'user.create' ],
                'active'      => 'user/create',
                'class'       => '',
                'icon'        => '',
                'name'        => 'add',
                'text'        => 'core::menu.add',
                'order'       => 2
            ],
        ]
    ],
    'roles'          => [
        'route'       => 'role.index',
        'permissions' => [ 'role.index' ],
        'active'      => 'role/*',
        'class'       => '',
        'icon'        => 'fa fa-users',
        'name'        => 'role',
        'text'        => 'core::menu.roles',
        'order'       => 2,
        'subs'        => [
            'role_list' => [
                'route'       => 'role.index',
                'permissions' => [ 'role.index' ],
                'active'      => 'role/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'list',
                'text'        => 'core::role.list',
                'order'       => 1
            ],
            'role_add'  => [
                'route'       => 'role.create',
                'permissions' => [ 'role.create' ],
                'active'      => 'role/create',
                'class'       => '',
                'icon'        => '',
                'name'        => 'list',
                'text'        => 'core::role.add',
                'order'       => 2
            ]
        ]
    ],
    'configurations' => [
        'route'       => 'configuration.setting.index',
        'permissions' => [ 'core.configuration.index' ],
        'active'      => 'configuration/*',
        'class'       => '',
        'icon'        => 'fa fa-cogs',
        'name'        => 'role',
        'text'        => 'core::menu.configurations',
        'order'       => 99,
        'subs'        => [
            'settings' => [
                'route'       => 'configuration.setting.index',
                'permissions' => [ 'core.configuration.setting.index' ],
                'active'      => 'configuration/setting/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'settings',
                'text'        => 'core::menu.settings',
                'order'       => 1
            ],
            'mail' => [
                'route'       => 'configuration.mail.index',
                'permissions' => [ 'core.configuration.mail.index' ],
                'active'      => 'configuration/mail/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'mail',
                'text'        => 'core::menu.mail',
                'order'       => 2
            ]
        ]
    ]
];