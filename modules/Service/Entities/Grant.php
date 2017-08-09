<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:44 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{

    protected $table = 'oauth_grants';

    protected $fillable = [ 'id' ];

    public $timestamps = true;

    public $incrementing = false;
}