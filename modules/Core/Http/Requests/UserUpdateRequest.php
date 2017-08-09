<?php
/**
 * Created by ngocnh.
 * Date: 8/5/15
 * Time: 11:20 PM
 */

namespace Modules\Core\Http\Requests;

use Modules\Core\Repositories\UserRepository;

class UserUpdateRequest extends BaseRequest
{

    public function authorize(UserRepository $user)
    {
        if (!auth()->user()->can(['access.all'])) {
            if (auth()->user()->can(['core.user.edit']) && $user->find($this->one)) {
                return true;
            }

            return false;
        }

        return true;
    }


    public function rules()
    {
        $rules = [
            'new_password'     => 'alpha_num|min:6',
            'password_confirm' => 'alpha_num|required_with:new_password|min:6|same:new_password',
            'old_password'     => 'alpha_num|required_with:new_password',
            'meta'             => 'array',
            'type'             => 'string',
            'roles'            => 'array'
        ];

        if ($this->email != auth()->user()->email) {
            $rules['email'] = "email|unique:users,email,{$this->route('one')}";
        }

        if ($this->username != auth()->user()->username) {
            $rules['username'] = "alpha_num|between:4,24|unique:users,username,{$this->route('one')}";
        }

        return $rules;
    }
}