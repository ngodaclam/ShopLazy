<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:46 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class AccessTokenScope extends Model
{

    protected $table = 'oauth_access_token_scopes';

    protected $fillable = [ 'access_token_id', 'scope_id' ];

    public $timestamps = true;
}