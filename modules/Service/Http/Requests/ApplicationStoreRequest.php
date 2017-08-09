<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 8/31/15
 * Time: 8:58 PM
 */

namespace Modules\Service\Http\Requests;

use App\Http\Requests\Request;

class ApplicationStoreRequest extends Request
{

    public function authorize()
    {
        return auth()->user()->can([ 'access.all', 'service.application.create' ]);
    }


    public function rules()
    {
        return [
            'client_name' => 'required'
        ];
    }
}