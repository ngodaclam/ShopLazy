<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 6/26/15
 * Time: 9:43 PM
 */

namespace Modules\Core\Entities;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    protected $table = "permissions";

    protected $fillable = [ "name", "display_name", "module" ];

    protected $dates = [ 'created_at', 'updated_at' ];

    public $timestamps = true;
}