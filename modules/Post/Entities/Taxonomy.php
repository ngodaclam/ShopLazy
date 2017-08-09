<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:54 PM
 */

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Entities\File;
use Ngocnh\Translator\Translatable;
use Ngocnh\Translator\Contracts\Translatable as TranslatableContract;

class Taxonomy extends Model implements TranslatableContract
{

    use Translatable, SoftDeletes;

    protected $table = "taxonomies";

    protected $fillable = [
        'parent',
        'type',
        'order',
        'count'
    ];

    protected $dates = [ 'deleted_at' ];

    protected $translator = TaxonomyDetail::class;

    protected $translatedAttributes = [ 'name', 'slug', 'description' ];

    protected $translatableForeign = 'taxonomy_id';

    public $timestamps = true;

    public function meta_key($meta_key)
    {
        return $this->meta()->where('key', '=', $meta_key)->first();
    }


    public function meta()
    {
        return $this->hasMany(TaxonomyMeta::class, 'taxonomy_id', 'id');
    }

    public function files($type = '*', $mine = '*', $status = 'open', $deleted = null)
    {
        $files = File::select('files.*')->join('taxonomy_file', 'taxonomy_file.file_id', '=',
            'files.id')->where('taxonomy_file.taxonomy_id', '=', $this->id)->where('files.deleted_at', '=',
            $deleted)->where('files.status', '=', $status);

        if ($mine !== '*') {
            $files->where('files.type', '=', $mine);
        }

        if ($type !== '*') {
            $files->where('taxonomy_file.type', '=', $type);
        }

        return $files;
    }
}