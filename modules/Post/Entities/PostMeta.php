<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:55 PM
 */

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{

    protected $table = "post_meta";

    protected $fillable = [
        'post_id',
        'meta_key',
        'meta_value'
    ];

    public $timestamps = true;

    public static $rules = [
        'create' => [
        ],
        'update' => [
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
}