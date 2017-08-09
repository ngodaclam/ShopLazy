<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 9:00 PM
 */

namespace Modules\Post\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TaxonomyDetailRepository extends BaseRepository
{

    public function findBySlug($taxonomy);
}