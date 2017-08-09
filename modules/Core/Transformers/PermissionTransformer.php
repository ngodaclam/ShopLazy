<?php
/**
 * Created by ngocnh.
 * Date: 8/6/15
 * Time: 2:40 PM
 */

namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\Permission;

class PermissionTransformer extends TransformerAbstract
{

    public function __construct($type = 'default')
    {
        $this->type = $type;
    }

    public function transform(Permission $permission)
    {
        if ($this->type == 'simple') {
            return [
                $permission->name => trans($permission->display_name)
            ];
        } else {
            return [
                'id'           => $permission->id,
                'name'         => $permission->name,
                'display_name' => $permission->display_name,
                'module'       => $permission->module
            ];
        }
    }
}