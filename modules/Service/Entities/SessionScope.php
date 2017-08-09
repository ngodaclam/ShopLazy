<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class SessionScope extends Model
{

    protected $table = 'oauth_session_scopes';

    protected $fillable = [ 'session_id', 'scope_id' ];

    public $timestamps = true;
}