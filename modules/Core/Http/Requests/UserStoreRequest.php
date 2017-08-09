<?php
/**
 * Created by ngocnh.
 * Date: 8/6/15
 * Time: 12:01 AM
 */

namespace Modules\Core\Http\Requests;

class UserStoreRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'core.user.create' ]);
    }


    public function rules()
    {
        return [
            'username'         => 'alpha_num|between:4,24|unique:users,username',
            'email'            => 'required|email|max:128|unique:users,email',
            'password'         => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
            'type'             => 'string|required',
            'roles'            => 'array|required'
        ];
    }
}