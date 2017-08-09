<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientScope extends Model
{

    protected $table = 'oauth_client_scopes';

    protected $fillable = [ 'client_id', 'scope_id' ];

    public $timestamps = true;
}