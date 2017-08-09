<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:43 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'oauth_clients';

    protected $fillable = [ 'id', 'secret', 'name', 'user_id' ];

    public $timestamps = true;

    public $incrementing = false;

    public function endpoints()
    {
        return $this->hasMany(ClientEndpoint::class)->get();
    }


    public function scopes()
    {
        return $this->hasMany(ClientScope::class)->get();
    }


    public function session()
    {
        return $this->hasMany(Session::class)->get();
    }
}