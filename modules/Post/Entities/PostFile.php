<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/25/15
 * Time: 3:42 PM
 */

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\File;

class PostFile extends Model
{

    protected $table = 'post_file';

    protected $fillable = [ 'type', 'post_id', 'file_id' ];

    public $timestamps = false;


    public function file()
    {
        return $this->belongsTo(File::class)->first();
    }


    public function post()
    {
        return $this->belongsTo(Post::class)->first();
    }
}