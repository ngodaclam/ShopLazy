<?php
/**
 * Created by ngocnh.
 * Date: 8/5/15
 * Time: 9:31 PM
 */

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\BaseRepository;

abstract class EloquentModel implements BaseRepository
{

    protected $model;


    public function __construct()
    {
        $this->makeModel();
    }


    abstract function model();


    public function makeModel()
    {
        $model = app($this->model());

        if ( ! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }


    public function select($columns = [ '*' ])
    {
        return $this->model->select($columns);
    }


    public function count()
    {
        return $this->select()->count();
    }


    public function all($columns = [ '*' ])
    {
        return $this->model->all($columns);
    }


    public function find($id)
    {
        return $this->model->find($id);
    }


    public function findTrash($id)
    {
        return $this->model->withTrashed()->find($id);
    }


    public function trash($id)
    {
        \DB::beginTransaction();

        try {
            if ($id instanceof $this->model) {
                $obj = $id;
            } else {
                $obj = $this->find($id);
            }

            $backup_obj = $obj;

            $response = $obj->delete();

            if (config('elasticquent.enable')) {
                $backup_obj->reindex();
            }

            \DB::commit();

            return $response;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function trashed($count = false)
    {
        $query = $this->model->onlyTrashed();

        return $count ? $query->count() : $query->get();
    }


    public function restore($id)
    {
        \DB::beginTransaction();

        try {
            if ($id instanceof $this->model) {
                $obj = $id;
            } else {
                $obj = $this->find($id);
            }

            $backup_obj = $obj;

            $obj->restore();

            if (config('elasticquent.enable')) {
                $backup_obj->reindex();
            }

            \DB::commit();
            \Log::info("Restored $this->model $this->model->id success.");

            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function destroy($id)
    {
        \DB::beginTransaction();

        try {
            if ($id instanceof $this->model) {
                $obj = $id;
            } else {
                $obj = $this->find($id);
            }

            $response = $obj->forceDelete();

            \DB::commit();

            return $response;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);

            return false;
        }
    }


    public function paginate($limit = 10, $columns = [ '*' ])
    {
        return $this->model->paginate($limit, $columns);
    }
}