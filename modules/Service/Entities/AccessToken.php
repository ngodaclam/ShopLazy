<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:46 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{

    protected $table = 'oauth_access_tokens';

    protected $fillable = [ 'id', 'session_id', 'expire_time' ];

    public $timestamps = true;

    public $incrementing = false;


    public function session()
    {
        return $this->belongsTo(Session::class)->first();
    }
}