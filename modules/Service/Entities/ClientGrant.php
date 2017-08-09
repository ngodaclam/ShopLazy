<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientGrant extends Model
{

    protected $table = 'oauth_client_grants';

    protected $fillable = [ 'client_id', 'grant_id' ];

    public $timestamps = true;
}