<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:56 PM
 */

namespace Modules\Post\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\Locale;
use Modules\Core\Transformers\FileTransformer;
use Modules\Core\Transformers\UserTransformer;
use Modules\Post\Entities\Post;

class PostTransformer extends TransformerAbstract
{

    public function __construct($translate = false)
    {
        $this->translate = $translate;
    }


    public function transform(Post $post)
    {
        $manager = new Manager;
        $manager->setSerializer(new ArraySerializer());

        $translates = [ ];

        if ($this->translate) {
            $locale = new Locale;
            foreach ($locale->all() as $locale) {
                $translates[$locale->code] = [
                    'title'     => $post->translate($locale->code)->title,
                    'excerpt'   => $post->translate($locale->code)->excerpt,
                    'slug'      => $post->translate($locale->code)->slug,
                    'content'   => $post->translate($locale->code)->content,
                    'locale_id' => $locale->id
                ];
            }
        }

        $return = [
            'id'             => $post->id,
            'title'          => $post->title,
            'excerpt'        => $post->excerpt,
            'slug'           => $post->slug,
            'content'        => $post->content,
            'order'          => $post->order,
            'type'           => $post->type,
            'status'         => $post->status,
            'comment_status' => $post->comment_status,
            'comment_count'  => $post->comment_count,
            'author'         => [ ],
            'taxonomies'     => [ ],
            'tags'           => [ ],
            'image'          => [ ],
            'images'         => [ ],
            'translate'      => $translates
        ];

        if ($author = $post->author()) {
            $author           = new Item($author, new UserTransformer, 'user');
            $author           = $manager->createData($author)->toArray();
            $return['author'] = array_merge($return['author'], $author);
        }

        if ($featured = $post->files('featured')->first()) {
            $featured        = new Item($featured, new FileTransformer, 'featured');
            $featured        = $manager->createData($featured)->toArray();
            $return['image'] = array_merge($return['image'], $featured);
        }

        if ($images = $post->files('images')->get()) {
            $image_collection = new Collection($images, new FileTransformer, 'images');
            $images           = $manager->createData($image_collection)->toArray();
            $return           = array_merge($return, $images);
        }

        if ($taxonomies = $post->taxonomies()) {
            $taxonomy_collection = new Collection($taxonomies, new TaxonomyTransformer('taxonomies'), 'taxonomies');
            $taxonomies          = $manager->createData($taxonomy_collection)->toArray();
            $return              = array_merge($return, $taxonomies);
        }

        if ($tags = $post->tags()) {
            $tag_collection = new Collection($tags, new TaxonomyTransformer('tags'), 'tags');
            $tags           = $manager->createData($tag_collection)->toArray();
            $return         = array_merge($return, $tags);
        }

        if ($meta = $post->meta()->get()) {
            $meta_collection = new Collection($meta, new PostMetaTransformer(), 'meta');
            $meta            = $manager->createData($meta_collection)->toArray();
            $return          = array_merge($return, $meta);
        }

        return $return;
    }
}