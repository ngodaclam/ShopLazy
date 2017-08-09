<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/4/15
 * Time: 10:33 AM
 */

namespace Modules\Core\Http\Requests;

class ConfigStoreRequest extends BaseRequest
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'core.configuration.store' ]);
    }


    public function rules()
    {
        return [];
    }
}