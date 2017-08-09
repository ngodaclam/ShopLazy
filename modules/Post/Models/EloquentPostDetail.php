<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:58 PM
 */

namespace Modules\Post\Models;

use Modules\Core\Models\EloquentModel;
use Modules\Post\Entities\PostDetail;
use Modules\Post\Repositories\PostDetailRepository;

class EloquentPostDetail extends EloquentModel implements PostDetailRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return PostDetail::class;
    }


    public function findBySlug($slug) {
        return PostDetail::findBySlug($slug);
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