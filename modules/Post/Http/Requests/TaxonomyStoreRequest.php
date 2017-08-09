<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/12/15
 * Time: 8:43 PM
 */

namespace Modules\Post\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;

class TaxonomyStoreRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.category.create' ]);
    }


    public function rules()
    {
        $rules = [
            'translate' => 'required|array',
            'parent'    => 'integer',
            'order'     => 'integer'
        ];

        foreach ($this->translate as $locale_id => $value) {
            if ($value['name'] != '') {
                $rules["translate.$locale_id.name"] = 'required';
            }
        }

        return $rules;
    }
}