<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/4/15
 * Time: 10:26 AM
 */

namespace Modules\Core\Repositories;

interface ConfigRepository extends BaseRepository
{

    public function save($attributes);


    public function getByGroup($group, $key = false);


    public function getByKey($key);
}