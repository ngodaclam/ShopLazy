<?php
/**
 * Created by NgocNH.
 * Date: 11/15/15
 * Time: 2:01 PM
 */

namespace Modules\Post\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Post\Entities\PostMeta;

class PostMetaTransformer extends TransformerAbstract
{

    public function transform(PostMeta $post_meta)
    {
        return [
            'post_id'    => $post_meta->id,
            'meta_key'   => $post_meta->meta_key,
            'meta_value' => $post_meta->meta_value
        ];
    }
}