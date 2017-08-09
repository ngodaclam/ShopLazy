<?php
/**
 * Created by NgocNH.
 * Date: 11/21/15
 * Time: 3:05 PM
 */

namespace Modules\Post\Http\Controllers\API\v1\Requests;

use Dingo\Api\Auth\Auth;
use Modules\Core\Entities\User;
use Modules\Core\Http\Controllers\API\v1\Requests\ApiRequest;

class CategoryIndexRequest extends ApiRequest
{

    public function authorize()
    {
        $this->auth = app(Auth::class)->user();
        return $this->auth instanceof User && $this->auth->can(['api.access.all', 'api.category.index']);
    }


    public function rules()
    {
        return [
            'limit' => 'integer',
            'type'  => 'string'
        ];
    }
}