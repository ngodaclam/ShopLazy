<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/3/15
 * Time: 3:08 PM
 */

namespace Modules\Core\Repositories;

interface LocaleRepository extends BaseRepository
{

    public function getByCode($code);
}