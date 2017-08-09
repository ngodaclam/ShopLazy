<?php
/**
 * Created by NgocNH.
 * Date: 1/15/16
 * Time: 4:21 PM
 */

namespace Modules\Post\Http\Controllers\API\v1\Requests;

use Dingo\Api\Auth\Auth;
use Modules\Core\Entities\User;
use Modules\Core\Http\Controllers\API\v1\Requests\ApiRequest;

class CategoryShowRequest extends ApiRequest
{

    public function authorize()
    {
        $this->auth = app(Auth::class)->user();

        return $this->auth instanceof User && $this->auth->can([ 'api.access.all', 'api.category.index' ]);
    }
}