<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/14/15
 * Time: 4:21 PM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

class UserLoginRequest extends ApiRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}