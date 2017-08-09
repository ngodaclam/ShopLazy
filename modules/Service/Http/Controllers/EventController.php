<?php
/**
 * Created by NgocNH.
 * Date: 5/9/16
 * Time: 12:29 AM
 */

namespace Modules\Service\Http\Controllers;

use Modules\Service\Repositories\ClientRepository;

class EventController
{

    public function __construct(ClientRepository $client)
    {
        $this->client = $client;
    }

    public function userStored($user)
    {
        $attributes = [
            'client' => [
                'name' => '',
                'user_id' => $user->id
            ]
        ];

        $roles = $user->roles()->get();

        foreach ($roles as $role) {
            foreach ($role->permissions() as $permission) {
                $attributes['scopes'][] = "{$permission->module}.{$permission->name}";
            }
        }

        $this->client->create($attributes);
    }
}