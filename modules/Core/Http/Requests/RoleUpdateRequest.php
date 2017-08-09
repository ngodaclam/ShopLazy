<?php
/**
 * Created by ngocnh.
 * Date: 8/6/15
 * Time: 5:50 PM
 */

namespace Modules\Core\Http\Requests;

use Modules\Core\Repositories\RoleRepository;

class RoleUpdateRequest extends BaseRequest
{

    public function authorize(RoleRepository $role)
    {
        return $this->route('role') != 1 && $role->find($this->route('one')) && auth()->user()->can([
            'access.all',
            'core.role.edit'
        ]);
    }


    public function rules()
    {
        return [
            'id'           => 'required|integer',
            'display_name' => 'required|max:128',
            'permissions'  => 'required|array',
        ];
    }
}