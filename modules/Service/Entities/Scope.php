<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 1:43 PM
 */

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{

    protected $table = 'oauth_scopes';

    protected $fillable = [ 'id', 'description' ];

    public $timestamps = true;

    public $incrementing = false;
}