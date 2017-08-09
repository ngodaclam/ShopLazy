<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/7/15
 * Time: 10:24 PM
 */

namespace Modules\Core\Repositories;

interface RoleRepository extends BaseRepository
{

    public function defaultRole();
}