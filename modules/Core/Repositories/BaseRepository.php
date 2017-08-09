<?php
/**
 * Created by ngocnh.
 * Date: 8/4/15
 * Time: 10:56 PM
 */

namespace Modules\Core\Repositories;

interface BaseRepository
{

    public function select($columns = [ '*' ]);


    public function count();


    /**
     * @param  int $id
     *
     * @return $model
     */
    public function find($id);


    public function findTrash($id);


    /**
     * Return a collection of all elements of the resource
     * @return mixed
     */
    public function all($columns = [ '*' ]);


    /**
     * Create a resource
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($attributes);


    /**
     * Update a resource
     *
     * @param        $model
     * @param  array $data
     *
     * @return mixed
     */
    public function update($id, $attributes);


    /**
     * Destroy a resource
     *
     * @param $model
     *
     * @return mixed
     */
    public function destroy($ids);


    public function trash($id);


    public function trashed($count = false);


    public function restore($id);


    public function paginate($limit = 10, $columns = [ '*' ]);
}