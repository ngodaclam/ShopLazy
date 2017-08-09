<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:59 PM
 */

namespace Modules\Post\Models;

use Modules\Core\Models\EloquentModel;
use Modules\Post\Entities\CommentMeta;
use Modules\Post\Repositories\CommentMetaRepository;

class EloquentCommentMeta extends EloquentModel implements CommentMetaRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return CommentMeta::class;
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