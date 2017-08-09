<?php
/**
 * Created by NgocNH.
 * Date: 1/15/16
 * Time: 11:10 AM
 */

return [
    'core.api.user.index'  => [
        'name'         => 'core.api.user.index',
        'display_name' => 'core::roles.user.index',
        'module'       => 'core',
        'module_name'  => 'core::user.account'
    ],
    'core.api.user.create' => [
        'name'         => 'core.api.user.store',
        'display_name' => 'core::roles.user.create',
        'module'       => 'core',
        'module_name'  => 'core::user.account'
    ],
    'core.api.user.edit'   => [
        'name'         => 'core.api.user.edit',
        'display_name' => 'core::roles.user.edit',
        'module'       => 'core',
        'module_name'  => 'core::user.account'
    ],
    'core.api.user.show'   => [
        'name'         => 'core.api.user.show',
        'display_name' => 'core::roles.user.show',
        'module'       => 'core',
        'module_name'  => 'core::user.account'
    ],
    'core.api.role.index'  => [
        'name'         => 'core.api.role.index',
        'display_name' => 'core::roles.role.index',
        'module'       => 'core',
        'module_name'  => 'core::role.role'
    ],
    'core.api.role.index2'  => [
        'name'         => 'core.api.role.index2',
        'display_name' => 'core::roles.role.index2',
        'module'       => 'core',
        'module_name'  => 'core::role.role'
    ]
];