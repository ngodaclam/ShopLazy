<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/25/15
 * Time: 10:50 AM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class FileDetail extends Model
{

    protected $table = 'file_detail';

    protected $fillable = [ 'title', 'description', 'file_id', 'locale_id' ];

    public $timestamps = false;
}