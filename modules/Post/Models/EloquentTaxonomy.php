<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:58 PM
 */

namespace Modules\Post\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\File;
use Modules\Core\Models\EloquentModel;
use Modules\Post\Entities\Taxonomy;
use Modules\Post\Entities\TaxonomyDetail;
use Modules\Post\Entities\TaxonomyFile;
use Modules\Post\Entities\TaxonomyMeta;
use Modules\Post\Repositories\TaxonomyRepository;

class EloquentTaxonomy extends EloquentModel implements TaxonomyRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Taxonomy::class;
    }


    /**
     * Create a resource
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($attributes)
    {
        DB::beginTransaction();

        try {
            $taxonomy = Taxonomy::create($attributes['attributes']);

            if (isset( $attributes['featured'] ) && $attributes['featured']) {
                $info           = File::getInfo($attributes['featured']);
                $info['author'] = auth()->user()->id;
                $info['status'] = 'open';

                if ( ! $image = File::where('path', '=', $info['path'])->where('mine', '=', $info['mine'])->first()) {
                    $image = File::create($info);
                }

                TaxonomyFile::create([ 'type' => 'featured', 'taxonomy_id' => $taxonomy->id, 'file_id' => $image->id ]);
            }

            if (isset( $attributes['images'] ) && $attributes['images']) {
                foreach ($attributes['images'] as $taxonomy_image) {
                    $info           = File::getInfo($taxonomy_image);
                    $info['author'] = auth()->user()->id;
                    $info['status'] = 'open';

                    if ( ! $taxonomy_image = File::where('path', '=', $info['path'])->where('mine', '=',
                        $info['mine'])->first()
                    ) {
                        $taxonomy_image = File::create($info);
                    }

                    TaxonomyFile::create([
                        'type'        => 'image',
                        'taxonomy_id' => $taxonomy->id,
                        'file_id'     => $taxonomy_image->id
                    ]);
                }
            }

            if (isset( $attributes['meta'] ) && $attributes['meta']) {
                foreach ($attributes['meta'] as $key => $value) {
                    if ($meta = TaxonomyMeta::where('taxonomy_id', '=', $taxonomy->id)->where('key', '=',
                        $key)->first()
                    ) {
                        $meta->fill([ 'value' => $value ])->save();
                    } else {
                        TaxonomyMeta::create([
                            'taxonomy_id' => $taxonomy->id,
                            'key'         => $key,
                            'value'       => $value
                        ]);
                    }
                }
            }

            foreach ($attributes['translate'] as $translate) {
                $translate['taxonomy_id'] = $taxonomy->id;
                TaxonomyDetail::create($translate);
            }

            DB::commit();
            Log::info("Taxonomy $taxonomy->id has been created");

            return $taxonomy;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }


    /**
     * Update a resource
     *
     * @param        $model
     * @param  array $data
     *
     * @return mixed
     */
    public function update($id, $attributes)
    {
        DB::beginTransaction();

        try {
            $taxonomy = Taxonomy::find($id);
            $taxonomy->fill($attributes['attributes'])->save();

            if (isset( $attributes['featured'] ) && $attributes['featured']) {
                $info           = File::getInfo($attributes['featured']);
                $info['author'] = auth()->user()->id;
                $info['status'] = 'open';

                if ( ! $image = File::where('path', '=', $info['path'])->where('mine', '=', $info['mine'])->first()) {
                    $image = File::create($info);
                }

                if ( ! TaxonomyFile::where('taxonomy_id', '=', $taxonomy->id)->where('file_id', '=',
                    $image->id)->first()
                ) {
                    TaxonomyFile::create([
                        'type'        => 'featured',
                        'taxonomy_id' => $taxonomy->id,
                        'file_id'     => $image->id
                    ]);
                }
            } else {
                TaxonomyFile::where('type', '=', 'featured')->where('taxonomy_id', '=', $taxonomy->id)->delete();
            }

            if (isset( $attributes['images'] ) && $attributes['images']) {
                $image_ids = [ ];

                foreach ($attributes['images'] as $taxonomy_image) {
                    $info           = File::getInfo($taxonomy_image);
                    $info['author'] = auth()->user()->id;
                    $info['status'] = 'open';

                    if ( ! $file = File::where('path', '=', $info['path'])->where('mine', '=',
                        $info['mine'])->first()
                    ) {
                        $file = File::create($info);
                    }

                    if ( ! $taxonomy_image = TaxonomyFile::where('taxonomy_id', '=', $taxonomy->id)->where('file_id',
                        '=', $file->id)->first()
                    ) {
                        $taxonomy_image = TaxonomyFile::create([
                            'taxonomy_id' => $taxonomy->id,
                            'file_id'     => $file->id
                        ]);
                    }

                    $image_ids = array_merge($image_ids, [ $taxonomy_image->id ]);
                }

                TaxonomyFile::whereNotIn('id', $image_ids)->where('taxonomy_id', '=', $taxonomy->id)->where('type', '=',
                    'image')->delete();
            }

            $meta_ids = [ ];

            if (isset( $attributes['meta'] ) && $attributes['meta']) {
                foreach ($attributes['meta'] as $key => $value) {
                    if ($meta = TaxonomyMeta::where('taxonomy_id', '=', $taxonomy->id)->where('key', '=',
                        $key)->first()
                    ) {
                        $meta->fill([ 'value' => $value ])->save();
                    } else {
                        $meta = TaxonomyMeta::create([
                            'taxonomy_id' => $taxonomy->id,
                            'key'         => $key,
                            'value'       => $value
                        ]);
                    }

                    $meta_ids = array_merge($meta_ids, [ $meta->id ]);
                }
            }

            TaxonomyMeta::whereNotIn('id', $meta_ids)->where('taxonomy_id', '=', $taxonomy->id)->delete();

            $translate_ids = [ ];

            foreach ($attributes['translate'] as $translate) {
                $translate['taxonomy_id'] = $taxonomy->id;
                if ($detail = TaxonomyDetail::where('locale_id', '=', $translate['locale_id'])->where('taxonomy_id',
                    '=', $taxonomy->id)->first()
                ) {
                    $detail->fill($translate)->save();
                } else {
                    $detail = TaxonomyDetail::create($translate);
                }

                $translate_ids = array_merge($translate_ids, [ $detail->id ]);
            }

            TaxonomyDetail::whereNotIn('id', $translate_ids)->where('taxonomy_id', '=', $taxonomy->id)->delete();

            DB::commit();
            Log::info("Taxonomy $taxonomy->id has been updated");

            return $taxonomy;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }


    public function findByType($id, $type = 'post_category')
    {
        return Taxonomy::where('type', '=', $type)->where('id', '=', $id)->first();
    }


    public function getCategoriesByType($type = 'post_category')
    {
        return Taxonomy::where('type', '=', $type)->get();
    }


    public function paginateCategoriesByType($type = 'post_category', $limit = 10, $columns = [ '*' ])
    {
        return Taxonomy::where('type', '=', $type)->paginate($limit);
    }
}
