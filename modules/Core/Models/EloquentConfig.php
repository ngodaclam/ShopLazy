<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/4/15
 * Time: 10:26 AM
 */

namespace Modules\Core\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\Config;
use Modules\Core\Repositories\ConfigRepository;

class EloquentConfig extends EloquentModel implements ConfigRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Config::class;
    }


    public function getByGroup($group, $key = false)
    {
        $configs = Config::where('group', '=', $group);

        if ($key) {
            $configs->where('key', '=', $key);

            return $configs->first();
        } else {
            return $configs->get();
        }
    }


    public function getByKey($key)
    {
        return Config::where('key', '=', $key)->get();
    }


    public function save($attributes)
    {
        DB::beginTransaction();

        try {

            foreach ($attributes as $attribute) {
                if ($config = Config::where('group', '=', $attribute['group'])->where('key', '=',
                    $attribute['key'])->first()
                ) {
                    $config->fill($attribute)->save();
                } else {
                    Config::create($attribute);
                }
            }

            DB::commit();
            Log::info('Configurations has been saved.');

            return true;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
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
        // TODO: Implement create() method.
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
        // TODO: Implement update() method.
    }
}