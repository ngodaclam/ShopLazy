<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:45 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class AuthCode extends Model
{

    protected $table = 'oauth_auth_codes';

    protected $fillable = [ 'id', 'session_id', 'redirect_uri', 'expire_time' ];

    public $timestamps = true;

    public $incrementing = false;
}