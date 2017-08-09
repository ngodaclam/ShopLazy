<?php
/**
 * Created by ngocnh.
 * Date: 8/5/15
 * Time: 9:25 PM
 */

namespace Modules\Core\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Modules\Core\Http\Requests\RoleStoreRequest;
use Modules\Core\Http\Requests\RoleUpdateRequest;
use Modules\Core\Repositories\PermissionRepository;
use Modules\Core\Repositories\RoleRepository;
use Modules\Core\Transformers\RoleTransformer;

class RoleController extends BackendController
{

    public function __construct(Manager $manager, RoleRepository $role, PermissionRepository $permission)
    {
        parent::__construct($manager);
        $this->role       = $role;
        $this->permission = $permission;
    }


    public function getIndex()
    {
        $roles      = $this->role->paginate();
        $collection = new Collection($roles->getCollection(), new RoleTransformer, 'roles');
        $collection->setPaginator(new IlluminatePaginatorAdapter($roles));
        $data              = $this->manager->createData($collection)->toArray();
        $data['paginator'] = $roles;

        return $this->theme->of('core::role_list', $data)->render();
    }


    public function getCreate()
    {
        $data['permissions']['core']['access.all'] = [
            'name'         => 'access.all',
            'display_name' => 'core::roles.access.all',
            'module'       => 'core'
        ];

        foreach (\Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.permissions')) {
                foreach ($configs as $role => $attributes) {
                    $data['permissions'][$module->getLowerName()][$attributes['name']] = $attributes;
                }
            }
        }

        $data['api_permissions']['core']['api.access.all'] = [
            'name'         => 'api.access.all',
            'display_name' => 'core::roles.access.all',
            'module'       => 'core'
        ];

        foreach (\Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.api_permissions')) {
                foreach ($configs as $role => $attributes) {
                    $data['api_permissions'][$module->getLowerName()][$attributes['name']] = $attributes;
                }
            }
        }

        return $this->theme->of('core::role_view', $data)->render();
    }

    public function getEdit($id)
    {
        if ($id == 1) {
            flash()->error(trans('core::general.access_dennie'));

            return redirect()->route('role.index');
        }

        $data['permissions']['core']['access.all'] = [
            'name'         => 'access.all',
            'display_name' => 'core::roles.access.all',
            'module'       => 'core'
        ];

        foreach (\Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.permissions')) {
                foreach ($configs as $role => $attributes) {
                    $data['permissions'][$module->getLowerName()][$attributes['name']] = $attributes;
                }
            }
        }

        $data['api_permissions']['core']['api.access.all'] = [
            'name'         => 'api.access.all',
            'display_name' => 'core::roles.access.all',
            'module'       => 'core'
        ];

        foreach (\Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.api_permissions')) {
                foreach ($configs as $role => $attributes) {
                    $data['api_permissions'][$module->getLowerName()][$attributes['name']] = $attributes;
                }
            }
        }

        $role = $this->role->find($id);
        $role = new Item($role, new RoleTransformer, 'role');

        $data['role'] = $this->manager->createData($role)->toArray();

        return $this->theme->of('core::role_view', $data)->render();
    }


    public function postStore(RoleStoreRequest $request, $external = false)
    {
        $attributes = [
            'attributes'  => [
                'display_name' => $request->display_name,
                'description'  => $request->description ?: '',
                'default'      => $request->default ? 1 : 0
            ],
            'permissions' => $request->permissions
        ];

        if ($response = event('role.before.store', [ $attributes ])) {
            $attributes = $response;
        }

        if ($role = $this->role->create($attributes)) {
            event('role.after.store', [ $role ]);
            flash(trans('core::role.create_success', [ 'name' => $role->name ]));

            return $external ? $role : redirect()->route('role.index');
        } else {
            flash()->error(trans('core::general.error'));

            return $external ? false : redirect()->route('role.index');
        }
    }


    public function postUpdate(RoleUpdateRequest $request, $id, $external = false)
    {
        $attributes = [
            'attributes'  => [
                'display_name' => $request->display_name,
                'description'  => $request->description,
                'default'      => $request->default ? 1 : 0
            ],
            'permissions' => $request->permissions
        ];

        if ($response = event('role.before.update', [ $attributes ])) {
            $attributes = $response;
        }

        if ($role = $this->role->update($request->id, $attributes)) {
            event('role.after.update', [ $role ]);
            flash(trans('core::role.update_success', [ 'name' => $role->name ]));

            return $external ? $role : redirect()->route('role.index');
        } else {
            flash()->error(trans('core::general.error'));

            return $external ? false : redirect()->route('role.index');
        }
    }


    public function postDestroy()
    {

    }
}