<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/29/15
 * Time: 2:14 AM
 */

namespace Modules\Service\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\Permission;
use Modules\Core\Models\EloquentModel;
use Modules\Service\Entities\Client;
use Modules\Service\Entities\ClientEndpoint;
use Modules\Service\Entities\ClientScope;
use Modules\Service\Entities\Scope;
use Modules\Service\Repositories\ClientRepository;

class EloquentClient extends EloquentModel implements ClientRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Client::class;
    }


    /**
     * Create a resource
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($attributes)
    {
        DB::beginTransaction();

        try {
            $attributes['client']['id']     = str_random();
            $attributes['client']['secret'] = str_random(32);
            $client                         = Client::create($attributes['client']);

            if (isset( $attributes['endpoint'] )) {
                $attributes['endpoint']['client_id'] = $client->id;
                ClientEndpoint::create($attributes['endpoint']);
            }

            if (isset( $attributes['scopes'] )) {
                foreach ($attributes['scopes'] as $scope) {
                    $scopes = explode('.', $scope);
                    $module = $scopes[0];
                    $scope_name = implode('.', array_except($scopes, 0));

                    if ( ! $scope = Scope::where('id', '=', $scope_name)->first()) {
                        if (!($permission = Permission::where('name', '=', $scope_name)->first())) {
                            if ($configs = config("candy.$module.api_permissions")) {
                                foreach ($configs as $role => $attributes) {
                                    if ($attributes['name'] == $scope_name) {
                                        $attributes['module'] = $module;
                                        $permission = Permission::create($attributes);
                                    }
                                }
                            }
                        }

                        $scope = Scope::create([
                            'id'          => $permission->name,
                            'description' => $permission->display_name
                        ]);
                    }

                    ClientScope::create([
                        'client_id' => $client->id,
                        'scope_id'  => $scope->id
                    ]);
                }

            }

            DB::commit();
            Log::info("Client $client->id has been created.");

            return $client;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }


    /**
     * Update a resource
     *
     * @param        $model
     * @param  array $data
     *
     * @return mixed
     */
    public function update($id, $attributes)
    {
        DB::beginTransaction();

        try {

            $client = Client::find($id);

            $client->fill($attributes['client'])->save();

            if (isset( $attributes['endpoint'] )) {
                if ( ! $endpoint = ClientEndpoint::where('client_id', '=', $client->id)->where('redirect_uri', '=',
                    $attributes['endpoint'])->first()
                ) {
                    $attributes['endpoint']['client_id'] = $client->id;
                    ClientEndpoint::create($attributes['endpoint']);
                }
            }

            $client_scope_ids = [ ];

            if (isset( $attributes['scopes'] )) {
                foreach ($attributes['scopes'] as $scope) {
                    $scopes = explode('.', $scope);
                    $module = $scopes[0];
                    $scope_name = implode('.', array_except($scopes, 0));

                    if ( ! $scope = Scope::where('id', '=', $scope_name)->first()) {
                        if (!($permission = Permission::where('name', '=', $scope_name)->first())) {
                            if ($configs = config("candy.$module.api_permissions")) {
                                foreach ($configs as $role => $attributes) {
                                    if ($attributes['name'] == $scope_name) {
                                        $attributes['module'] = $module;
                                        $permission = Permission::create($attributes);
                                    }
                                }
                            }
                        }

                        $scope = Scope::create([
                            'id'          => $permission->name,
                            'description' => $permission->display_name
                        ]);
                    }

                    if ( ! $client_scope = ClientScope::where('client_id', '=', $client->id)->where('scope_id', '=',
                        $scope->id)->first()
                    ) {
                        $client_scope = ClientScope::create([
                            'client_id' => $client->id,
                            'scope_id'  => $scope->id
                        ]);
                    }

                    $client_scope_ids = array_merge($client_scope_ids, [ $client_scope->id ]);
                }

                ClientScope::whereNotIn('id', $client_scope_ids)->delete();

            }

            DB::commit();
            Log::info("Client $client->id has been updated.");

            return $client;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }
}