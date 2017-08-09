<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 6/28/15
 * Time: 1:10 AM
 */
namespace Modules\Core\Models;

use Modules\Core\Entities\Permission;
use Modules\Core\Repositories\PermissionRepository;

class EloquentPermission extends EloquentModel implements PermissionRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Permission::class;
    }


    public function create($attributes)
    {
    }


    public function update($id, $attributes)
    {
        // TODO: Implement trash() method.
    }
}