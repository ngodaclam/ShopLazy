<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/14/15
 * Time: 2:52 PM
 */

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class PostTaxonomy extends Model
{

    protected $table = 'post_taxonomy';

    protected $fillable = [
        'post_id',
        'taxonomy_id'
    ];

    public $timestamps = true;


    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }


    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id', 'id')->first();
    }
}