<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/12/15
 * Time: 10:00 PM
 */

namespace Modules\Post\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\Post\Repositories\TaxonomyRepository;

class TaxonomyUpdateRequest extends BaseRequest
{

    public function authorize(TaxonomyRepository $taxonomy)
    {
        return $taxonomy->find($this->route('one')) && auth()->user()->can([ 'access.all', 'post.category.update' ]);
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