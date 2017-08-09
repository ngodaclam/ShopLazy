<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/15/15
 * Time: 4:14 PM
 */

namespace Modules\Post\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;

class TaxonomyDestroyRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.category.destroy' ]);
    }


    public function rules()
    {
        return [ ];
    }
}