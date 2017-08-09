<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/29/15
 * Time: 2:04 AM
 */

namespace Modules\Service\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Modules\Core\Http\Controllers\BackendController;
use Modules\Core\Repositories\PermissionRepository;
use Modules\Core\Transformers\PermissionTransformer;
use Modules\Service\Http\Requests\ApplicationStoreRequest;
use Modules\Service\Http\Requests\ApplicationUpdateRequest;
use Modules\Service\Repositories\ClientRepository;
use Modules\Service\Transformers\ClientTransformer;

class ClientController extends BackendController
{

    public function __construct(Manager $manager, ClientRepository $client, PermissionRepository $permission)
    {
        parent::__construct($manager);
        $this->client     = $client;
        $this->permission = $permission;
    }


    public function index()
    {
        $clients    = $this->client->paginate();
        $collection = new Collection($clients, new ClientTransformer, 'clients');
        $collection->setPaginator(new IlluminatePaginatorAdapter($clients));

        $data              = $this->manager->createData($collection)->toArray();
        $data['paginator'] = $clients;

        return $this->theme->of('service::applications', $data)->render();
    }


    public function create()
    {
        $data['permissions']['core']['api.access.all'] = [
            'name'         => 'api.access.all',
            'display_name' => 'core::roles.access.all',
            'module'       => 'core'
        ];

        foreach (\Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.api_permissions')) {
                foreach ($configs as $role => $attributes) {
                    $data['permissions'][$module->getLowerName()][$attributes['name']] = $attributes;
                }
            }
        }

        return $this->theme->of('service::application_view', $data)->render();
    }


    public function store(ApplicationStoreRequest $request)
    {
        $attributes = [
            'client' => [
                'name' => $request->client_name
            ]
        ];

        if ($request->client_url) {
            $attributes['endpoint']['redirect_uri'] = $request->client_url;
        }

        foreach ($request->scopes as $scope => $status) {
            if ($status == 1) {
                $attributes['scopes'][] = $scope;
            }
        }

        if ($response = event('application.before.store', [ $attributes ])) {
            $attributes = $response;
        }

        if ($client = $this->client->create($attributes)) {
            event('application.after.store');

            return redirect()->route('configuration.application.index');
        } else {
            return redirect()->back()->withInput();
        }
    }


    public function edit($id)
    {
        $data['permissions']['core']['api.access.all'] = [
            'name'         => 'api.access.all',
            'display_name' => 'core::roles.access.all',
            'module'       => 'core'
        ];

        foreach (\Module::enabled() as $module) {
            if ($configs = config('candy.' . $module->getLowerName() . '.api_permissions')) {
                foreach ($configs as $role => $attributes) {
                    $data['permissions'][$module->getLowerName()][$attributes['name']] = $attributes;
                }
            }
        }

        $client         = $this->client->find($id);
        $client         = new Item($client, new ClientTransformer, 'client');
        $data['client'] = $this->manager->createData($client)->toArray();

        return $this->theme->of('service::application_view', $data)->render();
    }


    public function update(ApplicationUpdateRequest $request)
    {
        $attributes = [
            'client' => [
                'name' => $request->client_name
            ]
        ];

        if ($request->client_url) {
            $attributes['endpoint']['redirect_uri'] = $request->client_url;
        }

        foreach ($request->scopes as $scope => $status) {
            if ($status == 1) {
                $attributes['scopes'][] = $scope;
            }
        }

        if ($response = event('application.before.update', [ $attributes ])) {
            $attributes = $response;
        }

        if ($client = $this->client->update($request->id, $attributes)) {
            event('application.after.update');

            return redirect()->route('configuration.application.index');
        } else {
            return redirect()->back()->withInput();
        }
    }


    public function destroy($id)
    {
        if ($this->client->destroy($id)) {
            flash(( trans('service::application.destroy_success') ));
        } else {
            flash()->error(trans('service::application.error'));
        }

        return redirect()->route('configuration.application.index');
    }
}