<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:54 PM
 */

namespace Modules\Post\Entities;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Entities\File;
use Modules\Core\Entities\User;
use Ngocnh\Translator\Translatable;
use Ngocnh\Translator\Contracts\Translatable as TranslatableContract;

class Post extends Model implements TranslatableContract
{

    use Translatable, SoftDeletes, ElasticquentTrait;

    protected $table = "posts";

    protected $fillable = [
        'author',
        'parent',
        'order',
        'type',
        'status',
        'comment_status',
        'comment_count'
    ];

    protected $mappingProperties = [
        'title' => [
            'type' => 'string',
            'analyzer' => 'standard'
        ],
        'excerpt' => [
            'type' => 'string',
            'analyzer' => 'standard'
        ],
        'content' => [
            'type' => 'string',
            'analyzer' => 'standard'
        ],
    ];

    protected $dates = [ 'deleted_at' ];

    public $timestamps = true;

    protected $translator = PostDetail::class;

    protected $translatedAttributes = [ 'title', 'excerpt', 'content', 'slug' ];

    protected $translatableForeign = 'post_id';


    public function author()
    {
        return $this->belongsTo(User::class, 'author', 'id')->first();
    }


    public function meta_key($meta_key)
    {
        return $this->meta()->where('meta_key', '=', $meta_key)->first();
    }


    public function meta()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'id');
    }


    public function detail()
    {
        return $this->hasMany(PostDetail::class, 'post_id', 'id')->get();
    }


    public function tags()
    {
        return Taxonomy::select('taxonomies.*')->join('post_taxonomy', 'post_taxonomy.taxonomy_id', '=',
            'taxonomies.id')->where('taxonomies.type', '=', 'post_tag')->where('post_taxonomy.post_id', '=',
            $this->id)->get();
    }


    public function taxonomies()
    {
        return Taxonomy::select('taxonomies.*')->join('post_taxonomy', 'post_taxonomy.taxonomy_id', '=',
            'taxonomies.id')->where('taxonomies.type', '=', 'post_category')->where('post_taxonomy.post_id', '=',
            $this->id)->get();
    }


    public function taxonomyByType($type = 'post_category')
    {
        return Taxonomy::select('taxonomies.*')->join('post_taxonomy', 'post_taxonomy.taxonomy_id', '=',
            'taxonomies.id')->where('taxonomies.type', '=', $type)->where('post_taxonomy.post_id', '=',
            $this->id)->get();
    }


    public function post_taxonomies()
    {
        return $this->hasMany(PostTaxonomy::class, 'post_id', 'id');
    }


    public function files($type = '*', $mine = '*', $status = 'open', $deleted = null)
    {
        $files = File::select('files.*')->join('post_file', 'post_file.file_id', '=',
            'files.id')->where('post_file.post_id', '=', $this->id)->where('files.deleted_at', '=',
            $deleted)->where('files.status', '=', $status);

        if ($mine !== '*') {
            $files->where('files.type', '=', $mine);
        }

        if ($type !== '*') {
            $files->where('post_file.type', '=', $type);
        }

        return $files;
    }
}