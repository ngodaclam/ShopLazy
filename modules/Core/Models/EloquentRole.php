<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/7/15
 * Time: 10:25 PM
 */

namespace Modules\Core\Models;

use Modules\Core\Entities\Permission;
use Modules\Core\Entities\Role;
use Modules\Core\Repositories\RoleRepository;

class EloquentRole extends EloquentModel implements RoleRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Role::class;
    }


    public function create($data)
    {
        \DB::beginTransaction();

        try {

            if ($data['attributes']['default'] == 1 && ($role_old = Role::where('default', '=', 1)->first())) {
                $role_old->fill(['default' => 0])->save();
            }

            $permissions = [];

            if (isset($data['permissions']) && $data['permissions']) {
                foreach ($data['permissions'] as $permission => $value) {
                    $exp = explode('.', $permission);
                    $module = $exp[0];
                    $permission_name = implode('.', array_except($exp, 0));

                    if (!($permission = Permission::where('name', '=', $permission_name)->first())) {
                        if ($configs = config("candy.$module.permissions")) {
                            foreach ($configs as $key => $attributes) {
                                if ($attributes['name'] == $permission_name) {
                                    $attributes['module'] = $module;
                                    $permission = Permission::create($attributes);
                                }
                            }
                        }
                    }

                    array_push($permissions, $permission);
                }
            }

            $role = Role::create($data['attributes']);
            $role->attachPermissions($permissions);

            \DB::commit();

            return $role;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function update($role, $data)
    {
        \DB::beginTransaction();

        try {
            if ($data['attributes']['default'] == 1 && ($role_old = Role::where('default', '=', 1)->first())) {
                $role_old->fill(['default' => 0])->save();
            }

            if ( ! $role instanceof Role) {
                $role = Role::find($role);
            }

            $permissions = [];

            if (isset($data['permissions']) && $data['permissions']) {
                foreach ($data['permissions'] as $permission => $value) {
                    $exp = explode('.', $permission);
                    $module = $exp[0];
                    $permission_name = implode('.', array_except($exp, 0));

                    if (!($permission = Permission::where('name', '=', $permission_name)->first())) {
                        if ($configs = config("candy.$module.permissions")) {
                            foreach ($configs as $key => $attributes) {
                                if ($attributes['name'] == $permission_name) {
                                    $attributes['module'] = $module;
                                    $permission = Permission::create($attributes);
                                }
                            }
                        }
                    }

                    if ($permission != null) {
                        array_push($permissions, $permission);
                    }
                }
            }

            $role->fill($data['attributes'])->save();
            $role->savePermissions(array_pluck($permissions, 'id'));
            \DB::commit();
            \Log::info("Role $role->id updated");

            return $role;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function defaultRole()
    {
        return Role::where('default', '=', 1)->first();
    }
}