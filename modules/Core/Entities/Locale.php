<?php
/**
 * Created by Ngọc Nguyễn.
 * User: NgocNH
 * Date: 5/3/15
 * Time: 2:45 PM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{

    protected $table = 'locales';

    protected $fillable = [ 'name', 'code', 'image', 'order', 'status' ];

    protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];

    public $timestamps = true;
}