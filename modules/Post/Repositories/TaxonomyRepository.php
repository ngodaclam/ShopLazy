<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 9:00 PM
 */

namespace Modules\Post\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TaxonomyRepository extends BaseRepository
{

    public function trash($ids);


    public function findByType($id, $type = 'post_category');


    public function getCategoriesByType($type = 'post_category');


    public function paginateCategoriesByType($type = 'post_category', $limit = 10, $columns = [ '*' ]);
}