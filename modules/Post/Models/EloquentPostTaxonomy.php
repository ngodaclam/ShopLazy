<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/14/15
 * Time: 2:53 PM
 */

namespace Modules\Post\Models;

use Modules\Core\Models\EloquentModel;
use Modules\Post\Entities\PostTaxonomy;
use Modules\Post\Repositories\PostTaxonomyRepository;

class EloquentPostTaxonomy extends EloquentModel implements PostTaxonomyRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return PostTaxonomy::class;
    }


    public function create($attributes)
    {
        // TODO: Implement create() method.
    }


    public function update($attributes, $id)
    {
        // TODO: Implement update() method.
    }

    public function findBy($field, $value, $columns = [ '*' ])
    {
        // TODO: Implement findBy() method.
    }
}