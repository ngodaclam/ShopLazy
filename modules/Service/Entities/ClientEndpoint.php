<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:45 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientEndpoint extends Model
{

    protected $table = 'oauth_client_endpoints';

    protected $fillable = [ 'client_id', 'redirect_uri' ];

    public $timestamps = true;


    public function client()
    {
        return $this->belongsTo(Client::class)->first();
    }
}