<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/27/15
 * Time: 2:33 PM
 */
namespace Modules\Core\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\Role;

class RoleTransformer extends TransformerAbstract
{

    public function __construct($type = 'default')
    {
        $this->type = $type;
    }


    public function transform(Role $role)
    {
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        $transformed = [
            'id'           => $role->id,
            'name'         => $role->name,
            'display_name' => $role->display_name,
            'description'  => $role->description,
            'default'      => $role->default,
            'permissions'  => [ ]
        ];

        if ($permissions = $role->perms()->getResults()) {
            $permission_collection = new Collection($permissions, new PermissionTransformer($this->type), 'permissions');
            $permissions           = $manager->createData($permission_collection)->toArray();
            $transformed           = array_merge($transformed, $permissions);
        }

        return $transformed;
    }
}