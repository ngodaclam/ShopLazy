<?php
/**
 * Created by NgocNH.
 * Date: 11/15/15
 * Time: 1:54 PM
 */

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class TaxonomyMeta extends Model
{

    protected $table = 'taxonomy_meta';

    protected $fillable = [ 'taxonomy_id', 'key', 'value' ];

    public $timestamps = false;
}