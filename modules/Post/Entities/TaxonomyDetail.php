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

class TaxonomyDetail extends Model
{

    use Sluggable;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    protected $table = "taxonomy_detail";

    protected $fillable = [ 'name', 'slug', 'description', 'locale_id', 'taxonomy_id' ];


    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class)->first();
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
                'source' => 'name'
            ]
        ];
    }
}