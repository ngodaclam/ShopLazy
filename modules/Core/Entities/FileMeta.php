<?php
/**
 * Created by NgocNH.
 * Date: 6/3/16
 * Time: 8:38 AM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class FileMeta extends Model
{
    protected $table = 'file_meta';

    protected $fillable = [ 'file_id', 'group', 'meta_key', 'meta_value' ];

    public $timestamps = false;


    public function file()
    {
        return $this->belongsTo(File::class)->first();
    }

}