<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/10/15
 * Time: 10:36 AM
 */

namespace Modules\Post\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;

class PostUpdateRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.update' ]);
    }


    public function rules()
    {
        $rules = [
            'status'         => 'required',
            'comment_status' => 'required',
            'order'          => 'required',
            'taxonomies'     => 'required|array'
        ];

        foreach ($this->translate as $locale_id => $value) {
            if ($value['title'] != '') {
                $rules["translate.$locale_id.title"]   = 'required';
                $rules["translate.$locale_id.content"] = 'required';
            }
        }

        return $rules;
    }
}