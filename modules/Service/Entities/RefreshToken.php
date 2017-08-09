<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{

    protected $table = 'oauth_refresh_tokens';

    protected $fillable = [ 'id', 'access_token_id', 'expire_time' ];

    public $timestamps = true;

    public $incrementing = false;
}