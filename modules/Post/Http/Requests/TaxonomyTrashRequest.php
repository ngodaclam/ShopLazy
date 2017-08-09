<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/15/15
 * Time: 4:13 PM
 */

namespace Modules\Post\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;

class TaxonomyTrashRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.category.trash' ]);
    }


    public function rules()
    {
        return [ ];
    }
}