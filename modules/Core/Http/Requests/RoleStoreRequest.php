<?php
/**
 * Created by ngocnh.
 * Date: 8/6/15
 * Time: 5:50 PM
 */

namespace Modules\Core\Http\Requests;

class RoleStoreRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([
            'access.all',
            'core.role.create'
        ]);
    }


    public function rules()
    {
        return [
            'display_name' => 'required|max:128',
            'permissions'  => 'required|array'
        ];
    }
}