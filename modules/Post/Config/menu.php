<?php

return [
    'posts' => [
        'route'       => 'post.index',
        'permissions' => [ 'post.index' ],
        'active'      => 'post/*',
        'class'       => '',
        'icon'        => 'fa fa-thumb-tack',
        'name'        => 'posts',
        'text'        => 'post::menu.post',
        'order'       => 0,
        'subs'        => [
            'post.index'     => [
                'route'       => 'post.index',
                'permissions' => [ 'post.index' ],
                'active'      => 'post/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'index',
                'text'        => 'post::menu.post_list',
                'order'       => 1
            ],
            'post.create'    => [
                'route'       => 'post.create',
                'permissions' => [ 'post.create' ],
                'active'      => 'post/create',
                'class'       => '',
                'icon'        => '',
                'name'        => 'create',
                'text'        => 'post::menu.post_create',
                'order'       => 2
            ],
            'category.index' => [
                'route'       => 'category.index',
                'permissions' => [ 'category.index' ],
                'active'      => 'category/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'category.index',
                'text'        => 'post::menu.category_list',
                'order'       => 3
            ],
            'tag.index'      => [
                'route'       => 'tag.index',
                'permissions' => [ 'tag.index' ],
                'active'      => 'tag/index',
                'class'       => '',
                'icon'        => '',
                'name'        => 'tag.index',
                'text'        => 'post::menu.tag_list',
                'order'       => 5
            ]
        ]
    ]
];