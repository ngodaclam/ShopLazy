<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 6/26/15
 * Time: 9:44 PM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{

    protected $table = "permission_role";

    protected $fillable = [ "permission_id", "role_id" ];

    public $timestamps = false;


    public function permission()
    {
        return $this->belongsTo(Permission::class)->first();
    }


    public function role()
    {
        return $this->belongsTo(Role::class)->first();
    }
}