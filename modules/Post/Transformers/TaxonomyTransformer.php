<?php
/**
 * Created by PhpStorm.
 * User: ngocnh
 * Date: 7/13/15
 * Time: 8:57 PM
 */

namespace Modules\Post\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\Locale;
use Modules\Core\Transformers\FileTransformer;
use Modules\Post\Entities\Taxonomy;

class TaxonomyTransformer extends TransformerAbstract
{

    public function __construct($translate = false)
    {
        $this->translate = $translate;
    }


    public function transform(Taxonomy $taxonomy)
    {
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer);

        $translates = [ ];

        if ($this->translate) {
            $locale = new Locale;
            foreach ($locale->all() as $locale) {
                $translates[$locale->code] = [
                    'name'        => $taxonomy->translate($locale->code)->name,
                    'slug'        => $taxonomy->translate($locale->code)->slug,
                    'description' => $taxonomy->translate($locale->code)->description,
                    'locale_id'   => $locale->id
                ];
            }

        }

        $return = [
            'id'          => $taxonomy->id,
            'name'        => $taxonomy->name,
            'slug'        => $taxonomy->slug,
            'description' => $taxonomy->description,
            'parent'      => $taxonomy->parent,
            'order'       => $taxonomy->order,
            'type'        => $taxonomy->type,
            'count'       => $taxonomy->count,
            'translate'   => $translates,
            'meta'        => [ ]
        ];

        if ($featured = $taxonomy->files('featured')->first()) {
            $featured           = new Item($featured, new FileTransformer);
            $return['featured'] = $manager->createData($featured)->toArray();
        }

        if ($images = $taxonomy->files('images')->get()) {
            $images = new Collection($images, new FileTransformer, 'images');
            $images = $manager->createData($images)->toArray();
            $return = array_merge($return, $images);
        }

        if ($meta = $taxonomy->meta()->get()) {
            foreach ($meta as $item) {
                $return['meta'][$item->key] = $item->value;
            }
            //$meta   = new Collection($meta, new TaxonomyMetaTransformer(), 'meta');
            //$meta   = $manager->createData($meta)->toArray();
            //$return = array_merge($return, $meta);
        }

        return $return;
    }
}