<?php
/**
 * Created by ngocnh.
 * Date: 8/7/15
 * Time: 1:09 AM
 */

namespace Modules\Post\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;

class PostStoreRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'post.create' ]);
    }


    public function rules()
    {
        $rules = [
            'status'         => 'required',
            'comment_status' => 'required',
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