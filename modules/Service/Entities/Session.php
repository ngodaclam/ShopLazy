<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'oauth_sessions';

    protected $fillable = [ 'client_id', 'owner_type', 'owner_id', 'client_redirect_uri' ];

    public $timestamps = true;


    public function accessToken()
    {
        return $this->hasOne(AccessToken::class)->first();
    }


    public function client()
    {
        return $this->belongsTo(Client::class)->first();
    }
}