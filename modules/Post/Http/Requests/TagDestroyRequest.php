<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/15/15
 * Time: 4:16 PM
 */

namespace Modules\Post\Http\Requests;

class TagDestroyRequest extends TaxonomyDestroyRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.tag.destroy' ]);
    }
}