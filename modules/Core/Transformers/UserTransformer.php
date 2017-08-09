<?php
/**
 * Created by ngocnh.
 * Date: 8/1/15
 * Time: 3:09 PM
 */

namespace Modules\Core\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\User;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer);

        $response = [
            'id'             => $user->id,
            'username'       => $user->username,
            'email'          => $user->email,
            'activation_key' => $user->activation_key,
            'last_visited'   => $user->last_visited,
            'type'           => $user->type,
            'status'         => $user->status,
            'avatar'         => '',
            'created_at'     => $user->created_at,
            'roles'          => [ ],
            'meta'           => [ ]
        ];

        if ($roles = $user->roles()->get()) {
            $role_collection = new Collection($roles, new RoleTransformer('simple'), 'roles');
            $roles           = $manager->createData($role_collection)->toArray();
            $response        = array_merge($response, $roles);
        }

        if ($meta = $user->meta()->get()) {
            //$meta_collection = new Collection($meta, new UserMetaTransformer, 'meta');
            //$meta            = $manager->createData($meta_collection)->toArray();
            //$response        = array_merge($response, $meta);

            foreach ($meta as $user_meta) {
                $response['meta'][$user_meta->meta_key] = $user_meta->meta_value;
            }
        }

        if ($avatar = $user->files('featured')->first()) {
            $response['avatar'] = $avatar->url ?: url($avatar->path);
        }

        if ($images = $user->files('images')->get()) {
            $images   = new Collection($images, new FileTransformer, 'images');
            $images   = $manager->createData($images)->toArray();
            $response = array_merge($response, $images);
        }

        if ($data = event('user.after.transform', [ $user, $response ])) {
            $response = $data[0];
        }

        return $response;
    }
}