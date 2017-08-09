<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/28/15
 * Time: 12:00 AM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

use Dingo\Api\Auth\Auth;
use Modules\Core\Entities\User;

class UserStoreRequest extends ApiRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'username'         => 'alpha_num|between:4,24|unique:users,username',
            'email'            => 'required|email|max:128|unique:users,email',
            'password'         => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
            //'meta'             => 'json',
            'type'             => 'string'
        ];
    }
}