<?php
/**
 * Created by NgocNH.
 * Date: 10/7/15
 * Time: 9:42 PM
 */

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class TaxonomyFile extends Model
{

    protected $table = "taxonomy_file";

    protected $fillable = [ "type", "taxonomy_id", "file_id" ];

    public $timestamps = false;
}