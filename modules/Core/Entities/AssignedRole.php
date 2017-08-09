<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 6/26/15
 * Time: 9:43 PM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class AssignedRole extends Model
{

    protected $table = "assigned_roles";

    protected $fillable = [ "user_id", "role_id" ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }


    public function role()
    {
        return $this->belongsTo(Role::class)->first();
    }
}