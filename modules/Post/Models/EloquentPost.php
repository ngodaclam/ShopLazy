<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:58 PM
 */

namespace Modules\Post\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\File;
use Modules\Core\Entities\Locale;
use Modules\Core\Models\EloquentModel;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\PostDetail;
use Modules\Post\Entities\PostFile;
use Modules\Post\Entities\PostMeta;
use Modules\Post\Entities\PostTaxonomy;
use Modules\Post\Entities\Taxonomy;
use Modules\Post\Entities\TaxonomyDetail;
use Modules\Post\Repositories\PostRepository;
use Log;

class EloquentPost extends EloquentModel implements PostRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    public function model()
    {
        return Post::class;
    }


    public function create($data)
    {
        DB::beginTransaction();

        try {
            $post = Post::create($data['attributes']);

            if (isset( $data['translate'] ) && $data['translate']) {
                foreach ($data['translate'] as $locale_id => $translate) {
                    $translate['post_id'] = $post->id;
                    PostDetail::create($translate);
                }
            }

            if (isset( $data['taxonomies'] ) && $data['taxonomies']) {
                foreach ($data['taxonomies'] as $taxonomy) {
                    if ($taxonomy = Taxonomy::find($taxonomy)) {
                        PostTaxonomy::create([ 'post_id' => $post->id, 'taxonomy_id' => $taxonomy->id ]);
                        $taxonomy->fill([ 'count' => $taxonomy->count + 1 ])->save();
                    }
                }
            }

            if ($data['tags']) {
                $tag_ids = [ ];
                foreach ($data['tags'] as $tag_id) {
                    if ($tag = Taxonomy::select('taxonomies.*')->join('taxonomy_detail', 'taxonomy_detail.taxonomy_id',
                        '=', 'taxonomies.id')->where('taxonomy_detail.taxonomy_id', '=', $tag_id)->first()
                    ) {
                        $tag->fill([ 'count' => $tag->count + 1 ])->save();

                        if ($post_tag = PostTaxonomy::where('post_id', '=', $post->id)->where('taxonomy_id', '=',
                            $tag->id)->first()
                        ) {
                            $tag_ids = array_merge($tag_ids, [ $post_tag->id ]);
                        } else {
                            PostTaxonomy::create([ 'post_id' => $post->id, 'taxonomy_id' => $tag->id ]);
                        }
                    } else {
                        $tag = Taxonomy::create([
                            'type'  => "{$post->type}_tag",
                            'count' => 1
                        ]);

                        $locale = Locale::where('code', '=', app()->getLocale())->first();

                        TaxonomyDetail::create([
                            'id'          => $tag_id,
                            'locale_id'   => $locale->id,
                            'taxonomy_id' => $tag->id
                        ]);

                        PostTaxonomy::create([ 'post_id' => $post->id, 'taxonomy_id' => $tag->id ]);
                    }
                }

                PostTaxonomy::whereIn('id', $tag_ids)->delete();

            }

            if (isset( $data['meta'] ) && $data['meta']) {
                foreach ($data['meta'] as $key => $value) {
                    PostMeta::create([
                        'post_id'    => $post->id,
                        'meta_key'   => $key,
                        'meta_value' => $value
                    ]);
                }
            }

            if (isset( $data['image'] ) && $data['image']) {
                $info           = File::getInfo($data['image']);
                $info['author'] = auth()->user()->id;
                $info['status'] = 'open';

                if ($image = File::where('mine', '=', $info['mine'])->where('path', '=', $info['path'])->first()) {
                    $image->fill($info)->save();
                } else {
                    $image = File::create($info);
                }

                if ($post_file = PostFile::where('post_id', '=', $post->id)->where('file_id', '=',
                    $image->id)->where('type', '=', 'featured')->first()
                ) {

                } else {
                    PostFile::create([
                        'type'    => 'featured',
                        'post_id' => $post->id,
                        'file_id' => $image->id
                    ]);
                }
            }

            if (config('elasticquent.enable')) {
                $post->addToIndex();
            }

            DB::commit();
            Log::info("Post $post->id has been created");

            return $post;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }


    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            $post->fill($data['attributes'])->save();

            if (isset( $data['translate'] ) && $data['translate']) {
                $post_defailt_ids = [ ];

                foreach ($data['translate'] as $translate) {
                    if ($post_detail = PostDetail::where('post_id', '=', $post->id)->where('locale_id', '=',
                        $translate['locale_id'])->first()
                    ) {
                        $post_detail->fill($translate)->save();
                    } else {
                        $translate['post_id'] = $post->id;
                        PostDetail::create($translate);
                    }

                    $post_defailt_ids = array_merge($post_defailt_ids, [ $post_detail->id ]);
                }

                PostDetail::whereNotIn('id', $post_defailt_ids)->where('post_id', '=', $post->id)->delete();
            }

            $taxonomy_ids = [ ];

            if (isset( $data['taxonomies'] ) && $data['taxonomies']) {
                foreach ($data['taxonomies'] as $taxonomy) {
                    if ($taxonomy = Taxonomy::find($taxonomy)) {
                        if ( ! $post_taxonomy = PostTaxonomy::where('post_id', '=', $post->id)->where('taxonomy_id',
                            '=', $taxonomy->id)->first()
                        ) {
                            PostTaxonomy::create([ 'post_id' => $post->id, 'taxonomy_id' => $taxonomy->id ]);
                            $taxonomy->fill([ 'count' => $taxonomy->count + 1 ])->save();
                        }

                        $taxonomy_ids = array_merge($taxonomy_ids, [ $taxonomy->id ]);
                    }
                }
            }

            if (isset( $data['tags'] ) && $data['tags']) {
                foreach ($data['tags'] as $tag_id) {
                    if ($tag = Taxonomy::select('taxonomies.*')->join('taxonomy_detail', 'taxonomy_detail.taxonomy_id',
                        '=', 'taxonomies.id')->where('taxonomy_detail.taxonomy_id', '=', $tag_id)->first()
                    ) {
                        $tag->fill([ 'count' => $tag->count + 1 ])->save();

                        if ( ! $post_tag = PostTaxonomy::where('post_id', '=', $post->id)->where('taxonomy_id', '=',
                            $tag->id)->first()
                        ) {
                            PostTaxonomy::create([ 'post_id' => $post->id, 'taxonomy_id' => $tag->id ]);
                        }
                    } else {
                        $tag = Taxonomy::create([
                            'type'  => 'post_tag',
                            'count' => 1
                        ]);

                        $locale = Locale::where('code', '=', app()->getLocale())->first();

                        TaxonomyDetail::create([
                            'id'          => $tag_id,
                            'locale_id'   => $locale->id,
                            'taxonomy_id' => $tag->id
                        ]);

                        PostTaxonomy::create([ 'post_id' => $post->id, 'taxonomy_id' => $tag->id ]);
                    }

                    $taxonomy_ids = array_merge($taxonomy_ids, [ $tag->id ]);
                }
            }

            $meta_ids = [ ];

            if (isset( $data['meta'] ) && $data['meta']) {
                foreach ($data['meta'] as $key => $value) {
                    if ($meta = PostMeta::where('post_id', '=', $post->id)->where('meta_key', '=', $key)->first()) {
                        $meta->fill([ 'meta_value' => $value ])->save();
                    } else {
                        $meta = PostMeta::create([
                            'post_id'    => $post->id,
                            'meta_key'   => $key,
                            'meta_value' => $value
                        ]);
                    }

                    $meta_ids = array_merge($meta_ids, [ $meta->id ]);
                }
            }

            PostMeta::whereNotIn('id', $meta_ids)->where('post_id', '=', $post->id)->delete();

            if (isset( $data['image'] ) && $data['image']) {
                $info           = File::getInfo($data['image']);
                $info['author'] = auth()->user()->id;
                $info['status'] = 'open';

                if ( ! ( $image = File::where('mine', '=', $info['mine'])->where('path', '=',
                    $info['path'])->first() )
                ) {
                    $image = File::create($info);
                }

                if ($post_file = PostFile::where('post_id', '=', $post->id)->where('type', '=', 'featured')->first()
                ) {
                    $post_file->fill([ 'file_id' => $image->id ])->save();
                } else {
                    PostFile::create([
                        'type'    => 'featured',
                        'post_id' => $post->id,
                        'file_id' => $image->id
                    ]);
                }
            }

            PostTaxonomy::whereNotIn('taxonomy_id', $taxonomy_ids)->where('post_id', '=', $post->id)->delete();

            if (config('elasticquent.enable')) {
                $post->reindex();
            }

            DB::commit();
            Log::info("Post $post->id has been updated");

            return $post;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }


    public function getPostsByType($type = 'post')
    {
        return Post::where('type', '=', $type)->get();
    }


    public function selectByType($type = 'post', $columns = [ 'posts.*' ])
    {
        return $this->model->select($columns)->join('post_detail', 'post_detail.post_id', '=',
            'posts.id')->where('posts.type', '=', $type)->groupBy('posts.id');
    }
}