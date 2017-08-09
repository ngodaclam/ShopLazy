<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class GrantScope extends Model
{

    protected $table = 'oauth_grant_scopes';

    protected $fillable = [ 'grant_id', 'scope_id' ];

    public $timestamps = true;
}