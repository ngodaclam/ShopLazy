<?php
/**
 * Created by NgocNH.
 * Date: 4/30/2015
 * Time: 4:34 AM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{

    protected $table = "user_meta";

    protected $fillable = [ "user_id", "group", "meta_key", "meta_value" ];

    protected $guarded = [ "user_id" ];

    public $timestamps = false;

    public $errors;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}