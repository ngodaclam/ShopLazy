<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:46 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class AuthCodeScope extends Model
{

    protected $table = 'oauth_auth_code_scopes';

    protected $fillable = [ 'auth_code_id', 'scope_id' ];

    public $timestamps = true;
}