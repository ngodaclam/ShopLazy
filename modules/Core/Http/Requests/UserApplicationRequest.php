<?php
/**
 * Created by NgocNH.
 * Date: 5/8/16
 * Time: 11:55 PM
 */

namespace Modules\Core\Http\Requests;

class UserApplicationRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'core.user.application' ]);
    }


    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}