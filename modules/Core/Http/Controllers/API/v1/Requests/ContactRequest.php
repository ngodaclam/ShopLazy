<?php
/**
 * Created by NgocNH.
 * Date: 6/7/16
 * Time: 10:42 PM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

class ContactRequest extends ApiRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required',
            'message' => 'required'
        ];
    }
}