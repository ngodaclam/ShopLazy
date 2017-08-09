<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:55 PM
 */

namespace Modules\Post\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class PostDetail extends Model
{

    use Sluggable;

    protected $table = "post_detail";

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $fillable = [ 'title', 'excerpt', 'content', 'slug', 'locale_id', 'post_id' ];


    public function post()
    {
        return $this->belongsTo(Post::class)->first();
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}