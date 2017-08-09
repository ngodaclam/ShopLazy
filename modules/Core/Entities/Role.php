<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/2/15
 * Time: 11:29 PM
 */

namespace Modules\Core\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    use Sluggable;

    protected $table = "roles";

    protected $fillable = [ "name", "display_name", "description", "default" ];

    protected $dates = [ 'created_at', 'updated_at' ];

    public $timestamps = true;

    public static $rules = [
        'create' => [
            'display_name' => 'required|between:4,128',
            'permissions'  => 'required|array'
        ],
        'update' => [
            'display_name' => 'required|between:4,128',
            'permissions'  => 'required|array'
        ]
    ];


    public static function rules($action, $merge = [ ], $id = false)
    {
        $rules = self::$rules[$action];

        if ($id) {
            foreach ($rules as &$rule) {
                $rule = str_replace(':id', $id, $rule);
            }
        }

        return array_merge($rules, $merge);
    }


    public function permission_roles()
    {
        return $this->hasMany(PermissionRole::class)->get();
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')->get();
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'name' => [
                'source' => 'display_name'
            ]
        ];
    }
}