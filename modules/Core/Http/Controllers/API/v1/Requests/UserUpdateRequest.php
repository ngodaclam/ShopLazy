<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/1/15
 * Time: 11:06 AM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

use Dingo\Api\Auth\Auth;
use Modules\Core\Entities\User;

class UserUpdateRequest extends ApiRequest
{

    public function authorize()
    {
        $this->auth = app(Auth::class)->user();
        return $this->auth instanceof User && $this->auth->can(['api.access.all', 'core.api.user.edit']);
    }


    public function rules()
    {
        return [
            'username'         => "alpha_num|between:4,24|unique:users,username,{$this->route('user')}",
            'new_password'     => 'alpha_num|min:6',
            'password_confirm' => 'alpha_num|required_with:new_password|min:6|same:new_password',
            //'meta'             => 'json',
            'type'             => 'string'
        ];
    }
}