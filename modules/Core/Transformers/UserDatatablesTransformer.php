<?php
/**
 * Created by NgocNH.
 * Date: 11/16/15
 * Time: 8:49 AM
 */

namespace Modules\Core\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\User;

class UserDatatablesTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        $return = [
            'email' => $user->email
        ];

        if ($roles = $user->roles()->get()) {
            $role_collection = new Collection($roles, new RoleTransformer('simple'), 'roles');
            $roles           = $manager->createData($role_collection)->toArray();
            $return['roles'] = array_pluck($roles['roles'], [ 'display_name' ]);
        }

        if (!($fullname = $user->meta_key('fullname'))) {
            $first_name = $user->meta_key('first_name');
            $last_name = $user->meta_key('last_name');

            $return['name'] = ($first_name ? $first_name->meta_value . ' ' : '') . ($last_name ? $last_name->meta_value : '');
        } else {
            $return['name'] = $fullname->meta_value;
        }

        $status = $user->status == 1 ? 'lock' : 'unlock';
        $return['action'] = \Form::open(['url' => route('user.trash', ['id' => $user->id]), 'class' => 'form-horizontal']);
        $return['action'] .= \Form::button("<i class='fa fa-trash-o'></i>", [ 'type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'title' => trans('core::user.trash') ]);
        $return['action'] .= "<a href='".route('user.lock', ['id' => $user->id])."' class='btn btn-sm btn-warning' rel='tooltip' title='".trans("core::user.$status")."'><i class='fa fa-$status'></i></a>";
        $return['action'] .= "<a href='".route('user.edit', ['id' => $user->id])."' class='btn btn-sm btn-default' rel='tooltip' title='".trans('core::user.edit')."'><i class='fa fa-pencil'></i></a>";
        $return['action'] .= \Form::close();

        return $return;
    }
}