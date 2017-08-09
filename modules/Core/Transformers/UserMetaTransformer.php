<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/3/15
 * Time: 8:28 PM
 */

namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Entities\UserMeta;

class UserMetaTransformer extends TransformerAbstract
{

    public function transform(UserMeta $meta)
    {
        return [
            $meta->meta_key => $meta->meta_value
        ];
    }
}