<?php
/**
 * Created by NgocNH.
 * Date: 1/15/16
 * Time: 5:22 PM
 */

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{

    protected $table = 'user_file';

    protected $fillable = [ 'user_id', 'file_id', 'type' ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }


    public function file()
    {
        return $this->belongsTo(File::class)->first();
    }
}