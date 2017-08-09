<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 4/29/15
 * Time: 11:51 PM
 */

namespace Modules\Core\Repositories;

interface UserRepository extends BaseRepository
{

    public function lock($user);


    public function trash($user);


    public function restore($user);
}