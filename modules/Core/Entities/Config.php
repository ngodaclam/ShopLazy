<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/4/15
 * Time: 10:27 AM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{

    protected $table = 'configs';

    protected $fillable = [ 'group', 'key', 'value' ];

    protected $dates = [ 'created_at', 'updated_at' ];

    public $timestamps = true;
}