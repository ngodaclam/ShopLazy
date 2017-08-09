<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/15/15
 * Time: 4:15 PM
 */

namespace Modules\Post\Http\Requests;

class TagTrashRequest extends TaxonomyTrashRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.tag.trash' ]);
    }
}