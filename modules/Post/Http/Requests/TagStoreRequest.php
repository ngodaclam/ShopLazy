<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/13/15
 * Time: 2:46 PM
 */

namespace Modules\Post\Http\Requests;

class TagStoreRequest extends TaxonomyStoreRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.tag.create' ]);
    }
}