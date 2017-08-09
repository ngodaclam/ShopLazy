<?php
/**
 * Created by NgocNH.
 * Date: 11/15/15
 * Time: 3:35 PM
 */

namespace Modules\Post\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Post\Entities\TaxonomyMeta;

class TaxonomyMetaTransformer extends TransformerAbstract
{

    public function transform(TaxonomyMeta $meta)
    {
        return [
            'taxonomy_id' => $meta->taxonomy_id,
            'key'         => $meta->key,
            'value'       => $meta->value
        ];
    }
}